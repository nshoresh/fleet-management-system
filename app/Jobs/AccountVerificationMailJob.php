<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountVerificationMail;
use Exception;

class AccountVerificationMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 60;

    /**
     * Create a new job instance.
     */
    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::info('Sending user verification email to ' . $this->user->email);

            // Send the verification email
            Mail::to($this->user->email)
                ->send(new AccountVerificationMail($this->user));

            Log::info('Verification email sent successfully to ' . $this->user->email);
        } catch (Exception $e) {
            Log::error('Failed to send verification email to ' . $this->user->email . ': ' . $e->getMessage());

            // Re-throw the exception if we want the job to be retried
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Account verification email job failed permanently for user ' . $this->user->email);
        // You could notify admins or add the user to a list for manual verification here
    }
}
