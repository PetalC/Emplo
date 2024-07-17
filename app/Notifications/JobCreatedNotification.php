<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;
use App\Models\Job;

class JobCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $job;

    /**
     * Create a new notification instance.
     */
    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $jobBoardList = '<ul>';

        foreach($this->job->postings as $board) {
            $jobBoardList .= '<li>'.$board->job_board->value."</li>";
        }

        $jobBoardList .= '</ul>';

        return (new MailMessage)
            ->subject('A new Job has been Published')
            ->greeting($this->job->title)
            ->line(new HtmlString($jobBoardList))
            ->action('View Job', url('/job/'.$this->job->uuid));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
