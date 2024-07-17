<?php

namespace App\Mail\Subscription;

use App\Models\School;
use App\Models\Subscription;
use App\Nova\Subscriptions;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionChanged extends Mailable {
    use Queueable, SerializesModels;

    public School $school;

    public Subscription|null $previous_subscription;

    /**
     * Create a new message instance.
     */
    public function __construct( School $school, Subscription|null $previous_subscription ) {
        $this->school = $school;
        $this->previous_subscription = $previous_subscription;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope {
        return new Envelope(
            subject: 'Subscription Changed',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content {
        return new Content(
            markdown: 'emails.subscription.subscription-changed',
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
