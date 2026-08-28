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
    public const EXPORT_COLUMNS = [
        'registered_at' => 'Waktu Daftar',
        'full_name' => 'Nama Lengkap',
        'email' => 'Email',
        'phone' => 'No. WhatsApp',
        'participant_category' => 'Kategori Peserta',
        'institution' => 'Instansi',
        'major' => 'Prodi/Jurusan',
        'batch' => 'Angkatan',
        'normalized_batch' => 'Angkatan Terdeteksi',
        'certificate_sent_at' => 'Sertifikat Dikirim',
        'notes' => 'Catatan',
    ];

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

    public function exportRegistrations(Event $event, array $columns, string $format): StreamedResponse
    {
        $columns = array_values(array_filter(
            $columns,
            fn (string $column) => array_key_exists($column, self::EXPORT_COLUMNS)
        ));

        return $format === 'word'
            ? $this->exportWord($event, $columns)
            : $this->exportCsv($event, $columns);
    }

    private function exportCsv(Event $event, array $columns): StreamedResponse
    {
        $filename = $this->exportFilename($event, 'csv');

        return response()->streamDownload(function () use ($event, $columns) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fwrite($handle, "sep=,\r\n");

            fputcsv(
                $handle,
                array_map(fn (string $column) => self::EXPORT_COLUMNS[$column], $columns),
                ',',
                '"',
                ''
            );

            $event->registrations()
                ->oldest()
                ->chunk(200, function ($registrations) use ($handle, $columns) {
                    foreach ($registrations as $registration) {
                        $row = array_map(
                            fn (string $column) => $this->formatCsvCell(
                                $this->exportValue($registration, $column),
                                $column
                            ),
                            $columns
                        );

                        fputcsv($handle, $row, ',', '"', '');
                    }
                });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function exportWord(Event $event, array $columns): StreamedResponse
    {
        $filename = $this->exportFilename($event, 'doc');

        return response()->streamDownload(function () use ($event, $columns) {
            $tableFontSize = count($columns) > 7 ? '8pt' : '10pt';

            echo "\xEF\xBB\xBF";
            echo '<!DOCTYPE html><html><head><meta charset="UTF-8">';
            echo '<style>';
            echo '@page WordSection1{size:841.95pt 595.35pt;mso-page-orientation:landscape;margin:36pt}';
            echo 'div.WordSection1{page:WordSection1}';
            echo 'body{font-family:Arial,sans-serif;font-size:11pt;color:#111827}';
            echo 'h1{font-size:18pt;margin:0 0 6px}p{margin:0 0 16px;color:#4b5563}';
            echo 'table{width:100%;border-collapse:collapse;font-size:' . $tableFontSize . '}';
            echo 'th,td{border:1px solid #9ca3af;padding:7px;text-align:left;vertical-align:top;word-break:break-word}';
            echo 'th{background:#e5e7eb;font-weight:bold}tr:nth-child(even){background:#f9fafb}';
            echo '</style></head><body><div class="WordSection1">';
            echo '<h1>Data Pendaftaran</h1>';
            echo '<p>' . $this->escapeWordValue($event->title) . '</p>';
            echo '<table><thead><tr>';

            foreach ($columns as $column) {
                echo '<th>' . $this->escapeWordValue(self::EXPORT_COLUMNS[$column]) . '</th>';
            }

            echo '</tr></thead><tbody>';

            $event->registrations()
                ->oldest()
                ->chunk(200, function ($registrations) use ($columns) {
                    foreach ($registrations as $registration) {
                        echo '<tr>';

                        foreach ($columns as $column) {
                            echo '<td>' . $this->escapeWordValue($this->exportValue($registration, $column)) . '</td>';
                        }

                        echo '</tr>';
                    }
                });

            echo '</tbody></table></div></body></html>';
        }, $filename, [
            'Content-Type' => 'application/msword; charset=UTF-8',
        ]);
    }

    private function exportValue(EventRegistration $registration, string $column): string
    {
        return match ($column) {
            'registered_at' => optional($registration->created_at)->format('Y-m-d H:i:s') ?? '',
            'full_name' => (string) $registration->full_name,
            'email' => (string) $registration->email,
            'phone' => (string) $registration->phone,
            'participant_category' => $registration->participant_category ?: 'Tidak Diisi',
            'institution' => (string) ($registration->institution ?? ''),
            'major' => (string) ($registration->major ?? ''),
            'batch' => (string) ($registration->batch ?? ''),
            'normalized_batch' => (string) ($this->normalizeBatchYear($registration->batch) ?? ''),
            'certificate_sent_at' => $registration->certificate_sent_at
                ? $registration->certificate_sent_at->format('Y-m-d H:i:s')
                : 'Belum Dikirim',
            'notes' => (string) ($registration->notes ?? ''),
            default => '',
        };
    }

    private function exportFilename(Event $event, string $extension): string
    {
        return Str::slug($event->title)
            . '-data-pendaftaran-'
            . now()->format('Ymd-His')
            . '.'
            . $extension;
    }

    private function formatCsvCell(string $value, string $column): string
    {
        $value = trim($value);

        if ($value === '') {
            return '';
        }

        if (in_array($column, ['phone', 'batch'], true)) {
            return "\t" . $value;
        }

        return preg_match('/^[=+\-@]/', $value) ? "\t" . $value : $value;
    }

    private function escapeWordValue(string $value): string
    {
        return nl2br(htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));
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

}
