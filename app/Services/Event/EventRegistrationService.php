<?php

namespace App\Services\Event;

use App\Mail\EventRegistrationMail;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EventRegistrationService
{
    public function register(Event $event, array $data, ?User $user = null): array
    {
        if (in_array($event->status, ['completed', 'cancelled'], true)) {
            return [
                'status' => 'closed',
                'message' => 'Pendaftaran untuk kegiatan ini sudah ditutup.',
            ];
        }

        if ($user) {
            $member = $user->member;
            $email = $user->email;

            $alreadyRegistered = $event->registrations()->where('email', $email)->exists();
            if ($alreadyRegistered) {
                return [
                    'status' => 'already_registered',
                    'message' => 'Kehadiran / pendaftaran Anda sudah tercatat untuk kegiatan ini.',
                ];
            }

            $registrationData = [
                'full_name'            => $member?->full_name ?? ($data['full_name'] ?? $user->email),
                'email'                => $email,
                'phone'                => $user->no_hp ?? ($data['phone'] ?? '08123456789'),
                'institution'          => $data['institution'] ?? 'Universitas Kebangsaan Republik Indonesia',
                'participant_category' => $data['participant_category'] ?? 'Mahasiswa',
                'major'                => $member?->department?->name ?? ($data['major'] ?? 'Teknik Informatika'),
                'batch'                => $member?->generation?->year ? (string) $member->generation->year : ($data['batch'] ?? null),
                'notes'                => $data['notes'] ?? 'Presensi & Pendaftaran Mandiri Anggota HMIF',
            ];
        } else {
            $registrationData = $data;
        }

        $registration = $event->registrations()->create($registrationData);
        $emailSent = true;

        try {
            Mail::to($registration->email)->send(new EventRegistrationMail($event, $registration));
        } catch (\Throwable $exception) {
            report($exception);
            $emailSent = false;
        }

        return [
            'status' => 'success',
            'registration' => $registration,
            'email_sent' => $emailSent,
            'whatsapp_group_link' => $event->whatsapp_group_link,
        ];
    }

    public function updateRegistration(EventRegistration $registration, array $data): EventRegistration
    {
        $registration->update($data);
        return $registration;
    }

    public function deleteRegistration(EventRegistration $registration): void
    {
        $registration->delete();
    }

    public function exportCsv(Event $event): StreamedResponse
    {
        $filename = Str::slug($event->title) . '-data-pendaftaran-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($event) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'Waktu Daftar',
                'Nama Lengkap',
                'Email',
                'No. WhatsApp',
                'Kategori Peserta',
                'Instansi',
                'Prodi/Jurusan',
                'Angkatan',
                'Angkatan Terdeteksi',
                'Sertifikat Dikirim',
                'Catatan',
            ]);

            $event->registrations()
                ->oldest()
                ->chunk(200, function ($registrations) use ($handle) {
                    foreach ($registrations as $registration) {
                        fputcsv($handle, [
                            optional($registration->created_at)->format('Y-m-d H:i:s'),
                            $registration->full_name,
                            $registration->email,
                            $this->formatCsvTextCell($registration->phone),
                            $registration->participant_category ?: 'Tidak Diisi',
                            $registration->institution,
                            $registration->major,
                            $this->formatCsvTextCell($registration->batch),
                            $this->normalizeBatchYear($registration->batch) ?: '',
                            optional($registration->certificate_sent_at)->format('Y-m-d H:i:s'),
                            $registration->notes,
                        ]);
                    }
                });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function summarizeDemographics(Event $event): array
    {
        $categoryLabels = $event->registrations()
            ->selectRaw("COALESCE(NULLIF(participant_category, ''), 'Tidak Diisi') as label")
            ->toBase();

        $categories = DB::query()
            ->fromSub($categoryLabels, 'category_labels')
            ->selectRaw('label, COUNT(*) as total')
            ->groupBy('label')
            ->orderByDesc('total')
            ->get();

        $years = $event->registrations()
            ->where('participant_category', 'Mahasiswa')
            ->whereNotNull('batch')
            ->pluck('batch')
            ->map(fn ($batch) => $this->normalizeBatchYear($batch))
            ->filter()
            ->values();

        $distribution = $years
            ->countBy()
            ->sortKeysDesc()
            ->map(fn ($total, $year) => [
                'year' => (int) $year,
                'total' => $total,
            ])
            ->values();

        $mostCommon = $distribution
            ->sortByDesc('total')
            ->first();

        $batchSummary = [
            'most_common' => $mostCommon['year'] ?? null,
            'most_common_total' => $mostCommon['total'] ?? 0,
            'count' => $years->count(),
            'invalid_count' => $event->registrations()
                ->where('participant_category', 'Mahasiswa')
                ->whereNotNull('batch')
                ->get()
                ->filter(fn ($registration) => !$this->normalizeBatchYear($registration->batch))
                ->count(),
            'distribution' => $distribution,
        ];

        return [
            'categories' => $categories,
            'batches' => $batchSummary,
        ];
    }

    public function normalizeBatchYear(?string $batch): ?int
    {
        if (!$batch) {
            return null;
        }

        preg_match_all('/\d{2,4}/', $batch, $matches);

        foreach ($matches[0] as $candidate) {
            $number = (int) $candidate;

            if (strlen($candidate) === 4 && $number >= 1990 && $number <= now()->year + 1) {
                return $number;
            }

            if (strlen($candidate) === 2) {
                $year = $number <= (now()->year + 1) % 100 ? 2000 + $number : 1900 + $number;

                if ($year >= 1990 && $year <= now()->year + 1) {
                    return $year;
                }
            }
        }

        return null;
    }

    public function formatCsvTextCell(?string $value): string
    {
        $value = trim((string) $value);

        return $value === '' ? '' : "\t" . $value;
    }
}
