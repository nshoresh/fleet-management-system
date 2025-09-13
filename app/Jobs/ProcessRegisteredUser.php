<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;

class ProcessRegisteredUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public User $user
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Fire the Registered event in the background
        event(new Registered($this->user));
    }

    /**
     * The job failed to process.
     */
    public function failed(\Throwable $exception): void
    {
        // Handle job failure if needed
        // You might want to log this or retry
        Log::error('ProcessRegisteredUser job failed', [
            'user_id' => $this->user->id,
            'error' => $exception->getMessage()
        ]);
    }
}
