<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class VerificationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The verification code to be sent.
     */
    public string $verificationCode;

    /**
     * The recipient's email address for personalization.
     */
    public ?string $recipientEmail;

    /**
     * Code expiry time in minutes.
     */
    public int $expiryMinutes;

    /**
     * Optional verification URL for direct verification.
     */
    public ?string $verificationUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(
        string $verificationCode,
        ?string $recipientEmail = null,
        int $expiryMinutes = 15,
        ?string $verificationUrl = null
    ) {
        $this->verificationCode = $verificationCode;
        $this->recipientEmail = $recipientEmail;
        $this->expiryMinutes = $expiryMinutes;
        $this->verificationUrl = $verificationUrl;

        // Configure queue settings
        $this->onQueue('emails');
        $this->delay(now()->addSeconds(2)); // Small delay to ensure transaction completion
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify Your Email Address - ' . config('app.name'),
            tags: ['email-verification'],
            metadata: [
                'type' => 'verification',
                'expiry_minutes' => $this->expiryMinutes,
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.verification-code',
            text: 'emails.verification-code-text', // Plain text fallback
            with: $this->getEmailData(),
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

    /**
     * Get data to pass to the email view.
     *
     * @return array<string, mixed>
     */
    private function getEmailData(): array
    {
        return [
            'verificationCode' => $this->verificationCode,
            'recipientEmail' => $this->recipientEmail,
            'expiryMinutes' => $this->expiryMinutes,
            'verificationUrl' => $this->verificationUrl,
            'appName' => config('app.name'),
            'appUrl' => config('app.url'),
            'supportEmail' => $this->getSupportEmail(),
            'companyName' => $this->getCompanyName(),
            'currentYear' => now()->year,
            'expiryTime' => now()->addMinutes($this->expiryMinutes)->format('M j, Y g:i A'),
        ];
    }

    /**
     * Get the support email address.
     */
    private function getSupportEmail(): string
    {
        return config('mail.support.address')
            ?? config('mail.from.address')
            ?? 'support@' . parse_url(config('app.url'), PHP_URL_HOST);
    }

    /**
     * Get the company name.
     */
    private function getCompanyName(): string
    {
        return config('app.company_name')
            ?? config('app.name')
            ?? 'Our Team';
    }

    /**
     * Determine if the email should be queued.
     */
    public function shouldQueue(): bool
    {
        // Only queue if the queue system is configured
        return config('queue.default') !== 'sync';
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        // Log the failure for debugging
        Log::error('Verification email failed to send', [
            'recipient' => $this->recipientEmail,
            'verification_code' => $this->verificationCode,
            'exception' => $exception->getMessage(),
        ]);
    }

    /**
     * Configure retry settings for the queued job.
     */
    public function retryUntil(): \DateTime
    {
        return now()->addMinutes(5); // Retry for 5 minutes max
    }

    /**
     * Get the number of times the job may be attempted.
     */
    public function tries(): int
    {
        return 3;
    }

    /**
     * Calculate the number of seconds to wait before retrying the job.
     */
    public function backoff(): array
    {
        return [10, 30, 60]; // Wait 10s, then 30s, then 60s between retries
    }
}
