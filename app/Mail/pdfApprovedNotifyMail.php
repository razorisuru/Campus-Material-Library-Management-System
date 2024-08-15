<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class pdfApprovedNotifyMail extends Mailable
{
    use Queueable, SerializesModels;

    private $pdfName;
    private $UserName;

    /**
     * Create a new message instance.
     */
    public function __construct($pdfName, $UserName)
    {
        $this->pdfName = $pdfName;
        $this->UserName = $UserName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'SIBA LMS PDF Status Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.pdfApprovedNotifyMail',
            with: [
                'pdfName' => $this->pdfName,
                'UserName' => $this->UserName,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
