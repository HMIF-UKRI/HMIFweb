<?php

namespace App\Services\Event;

use App\Mail\EventCertificateMail;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;

class EventCertificateService
{
    public function sendSingleCertificate(
        Event $event,
        EventRegistration $registration,
        array $validated,
        UploadedFile $file
    ): void {
        Mail::to($registration->email)->send(new EventCertificateMail(
            event: $event,
            registration: $registration,
            messageBody: $validated['certificate_message'],
            certificatePath: $file->getRealPath(),
            certificateName: $file->getClientOriginalName(),
            customSubject: $validated['certificate_subject'] ?? null,
        ));

        $registration->forceFill([
            'certificate_sent_at' => now(),
        ])->save();
    }

    public function sendBulkCertificates(
        Event $event,
        array $validated,
        UploadedFile $file
    ): array {
        $sent = 0;
        $failed = 0;

        $event->registrations()
            ->whereNotNull('email')
            ->orderBy('id')
            ->chunk(50, function ($registrations) use ($event, $validated, $file, &$sent, &$failed) {
                foreach ($registrations as $registration) {
                    try {
                        Mail::to($registration->email)->send(new EventCertificateMail(
                            event: $event,
                            registration: $registration,
                            messageBody: $validated['certificate_message'],
                            certificatePath: $file->getRealPath(),
                            certificateName: $file->getClientOriginalName(),
                            customSubject: $validated['certificate_subject'] ?? null,
                        ));

                        $registration->forceFill([
                            'certificate_sent_at' => now(),
                        ])->save();

                        $sent++;
                    } catch (\Throwable $exception) {
                        report($exception);
                        $failed++;
                    }
                }
            });

        return [
            'sent' => $sent,
            'failed' => $failed,
        ];
    }
}
