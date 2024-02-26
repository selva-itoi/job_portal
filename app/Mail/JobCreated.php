<?php


namespace App\Mail;

use App\Models\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $jobs;

    public function __construct(Jobs $jobs)
    {
        $this->jobs = $jobs;
    }

    public function build()
    {
        return $this->markdown('emails.jobs.created');
    }
}


