<?php

namespace App\Mail\Application\External;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicantHiredEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    public $subject;

    /**
     * @var string
     */
    public string $message;

    /**
     * Create a new message instance.
     */
    public function __construct($subject, $message)
    {
        $this->subject = $subject;
        $this->message = $message;
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
            markdown: 'emails.application.external.hired',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return $this->attachments;
    }
}
