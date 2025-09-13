<?php

namespace App\Jobs;

use App\Mail\UserVerificationMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendUserVerificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $tries = 3;
    public $timeout = 120;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(): void
    {
        try {
            Log::info('Starting to send verification email', [
                'user_id' => $this->user->id,
                'user_email' => $this->user->email
            ]);

            Mail::to($this->user->email)->send(new UserVerificationMail($this->user));

            Log::info('Verification email sent successfully', [
                'user_id' => $this->user->id,
                'user_email' => $this->user->user
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send verification email', [
                'user_id' => $this->user->id,
                'user_email' => $this->user->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e; // Re-throw to mark job as failed
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('SendUserVerificationEmail job failed permanently', [
            'user_id' => $this->user->id,
            'user_email' => $this->user->email,
            'error' => $exception->getMessage(),
            'attempts' => $this->attempts()
        ]);
    }
}
