<?php

namespace App\Mail;

use App\Models\VehicleOwner;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BusinessRegistrationSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public VehicleOwner $vehicleOwner;

    /**
     * Create a new message instance.
     */
    public function __construct(VehicleOwner $vehicleOwner)
    {
        $this->vehicleOwner = $vehicleOwner;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Business Registration Submitted Successfully - ' . $this->vehicleOwner->business_name,
            replyTo: [
                config('mail.from.address', 'noreply@example.com'),
            ],
            tags: ['business-registration', 'confirmation'],
            metadata: [
                'business_id' => $this->vehicleOwner->id,
                'business_uuid' => $this->vehicleOwner->uuid,
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.business.registration-submitted',
            text: 'emails.business.registration-submitted-text',
            with: [
                'business' => $this->vehicleOwner,
                'businessName' => $this->vehicleOwner->business_name,
                'registrationNumber' => $this->vehicleOwner->business_registration_number,
                'submittedAt' => $this->vehicleOwner->created_at,
                // 'supportEmail' => config('mail.support_email', 'support@example.com'),
                'appName' => config('app.name', 'Vehicle Registration System'),
                'appUrl' => config('app.url'),
            ],
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
}
