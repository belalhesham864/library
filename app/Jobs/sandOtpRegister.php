<?php

namespace App\Jobs;

use App\Notifications\SendOtpEmailNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class sandOtpRegister implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $user;
    public function __construct($user)
    {
        $this->user=$user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
         $this->user->notify(new SendOtpEmailNotification());
    }
}
