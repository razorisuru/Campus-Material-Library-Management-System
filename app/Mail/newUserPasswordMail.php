<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class newUserPasswordMail extends Mailable
{
    use Queueable, SerializesModels;
    private $password;
    private $email;
    private $UserName;

    public function __construct($password, $email, $UserName)
    {
        $this->password = $password;
        $this->email = $email;
        $this->UserName = $UserName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New User Password Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.newUserPasswordMail',
            with: [
                'password' => $this->password,
                'email' => $this->email,
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
