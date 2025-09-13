<?php

namespace App\Jobs;

use App\Mail\BusinessRegistrationSubmitted;
use App\Mail\BusinessRegistrationReceived;
use App\Models\VehicleOwner;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class BusinessRegistrationNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The vehicle owner instance.
     */
    public VehicleOwner $vehicleOwner;

    /**
     * The email address to send notifications to.
     */
    public string $email;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The maximum number of seconds the job can run.
     */
    public int $timeout = 120;

    /**
     * Create a new job instance.
     */
    public function __construct(VehicleOwner $vehicleOwner, string $email)
    {
        $this->vehicleOwner = $vehicleOwner;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Send confirmation email to vehicle owner
            Mail::to($this->email)->send(new BusinessRegistrationSubmitted($this->vehicleOwner));

            // Send notification to admin
            $adminEmail = config('mail.admin_email', 'admin@example.com');
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new BusinessRegistrationReceived($this->vehicleOwner));
            }

            Log::info('Business registration notification emails sent successfully', [
                'vehicle_owner_id' => $this->vehicleOwner->id,
                'business_name' => $this->vehicleOwner->business_name,
                'email' => $this->email,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send business registration notification emails', [
                'vehicle_owner_id' => $this->vehicleOwner->id,
                'business_name' => $this->vehicleOwner->business_name,
                'email' => $this->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Re-throw the exception to trigger job retry
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Business registration notification job failed permanently', [
            'vehicle_owner_id' => $this->vehicleOwner->id,
            'business_name' => $this->vehicleOwner->business_name,
            'email' => $this->email,
            'error' => $exception->getMessage(),
            'attempts' => $this->attempts(),
        ]);

        // Optionally, you could send a notification to administrators
        // about the failed job or store it in a failed notifications table
    }

    /**
     * Get the tags that should be assigned to the job.
     *
     * @return array<int, string>
     */
    public function tags(): array
    {
        return [
            'email',
            'business-registration',
            'notification',
            'vehicle-owner:' . $this->vehicleOwner->id,
        ];
    }
}
