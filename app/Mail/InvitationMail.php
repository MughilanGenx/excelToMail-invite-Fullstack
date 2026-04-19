<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param string $subject   The email subject
     * @param string $body      The email body message
     * @param string $fromName  Sender display name
     */
    public function __construct(
        public string $subject,
        public string $body,
        public string $fromName = 'TC Invitation',
    ) {}

    /**
     * Get the message envelope (subject + sender).
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content — uses our custom blade template.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invitation',
            with: [
                'emailBody'  => $this->body,
                'fromName'   => $this->fromName,
                'emailSubject' => $this->subject,
            ],
        );
    }

    /**
     * No attachments.
     */
    public function attachments(): array
    {
        return [];
    }
}
