<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StaffroomFollowersEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    public string $titleText;

    /**
     * @var string
     */
    public string $messageText;

    /**
     * Create a new message instance.
     */
    public function __construct($titleText, $messageText)
    {
        $this->titleText = $titleText;
        $this->messageText = $messageText;
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Staffroom Followers Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.staffroomfollowers',
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
