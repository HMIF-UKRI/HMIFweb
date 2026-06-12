<?php

namespace App\Mail;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class EventCertificateMail extends Mailable
{
    public function __construct(
        public Event $event,
        public EventRegistration $registration,
        public string $messageBody,
        public string $certificatePath,
        public string $certificateName,
        public ?string $customSubject = null,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->customSubject ?: 'Sertifikat Kegiatan - ' . $this->event->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.event-certificate',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromPath($this->certificatePath)
                ->as($this->certificateName),
        ];
    }
}
