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

    public $body;
    public $fromName;
    public $recipientEmail;
    public $recipientName;
    public $appStoreLink;
    public $playStoreLink;

    public function __construct(
        $subject,
        $body,
        $fromName       = 'Task Concierge',
        $recipientEmail = '',
        $recipientName  = '',
        $appStoreLink   = '#',
        $playStoreLink  = '#'
    ) {
        $this->subject        = $subject;
        $this->body           = $body;
        $this->fromName       = $fromName;
        $this->recipientEmail = $recipientEmail;
        $this->recipientName  = $recipientName;
        $this->appStoreLink   = $appStoreLink;
        $this->playStoreLink  = $playStoreLink;
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.invitation',
            with: [
                'emailBody'      => $this->body,
                'fromName'       => $this->fromName,
                'emailSubject'   => $this->subject,
                'recipientEmail' => $this->recipientEmail,
                'recipientName'  => $this->recipientName,
                'appStoreLink'   => $this->appStoreLink,
                'playStoreLink'  => $this->playStoreLink,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
