<?php

namespace App\Jobs;

use App\Mail\SendCode;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class ForgotPassword  implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected User|Provider $model, 
        protected int $code
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->model->email)
            ->send(new SendCode($this->model, $this->code));
    }
}
