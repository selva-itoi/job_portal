<?php 
// app/Notifications/JobCreatedNotification.php

namespace App\Notifications;

use App\Models\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification as BaseNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class JobCreatedNotification extends BaseNotification implements ShouldQueue
{
    use Queueable;

    protected $job;

    public function __construct(Jobs $job)
    {
        $this->job = $job;
    }

    public function toFirebase($notifiable)
    {
        return (new PushMessage)
            ->setPlatform('fcm')
            ->setTitle('New Job Created')
            ->setBody('A new job has been created: ' . $this->job->title)
            ->setData(['job_id' => $this->job->id]);
    }
}
