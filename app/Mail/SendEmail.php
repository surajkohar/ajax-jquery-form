<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;

    public $body;

    public $filePath;

    /**
     * Create a new message instance.
     */
    public function __construct($subject, $body, $filePath = null)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->filePath = $filePath;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,

        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.send-email',
            with: [
                'body' => $this->body,
            ],
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

    // public function build()
    // {
    //     $mail = $this->subject($this->subject)
    //         ->view('Mail.mail') // Blade view for email body
    //         ->with([
    //             'body' => $this->body,
    //         ]);

    //     if ($this->filePath) {
    //         $mail->attach(storage_path('app/'.$this->filePath));
    //     }

    //     return $mail;
    // }
}
