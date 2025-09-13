<?php

namespace App\Mail;

use App\Models\VehicleOwner;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BusinessRegistrationReceived extends Mailable
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
            subject: 'New Business Registration Received - ' . $this->vehicleOwner->business_name,
            replyTo: [
                config('mail.from.address', 'noreply@example.com'),
            ],
            tags: ['business-registration', 'admin-notification'],
            metadata: [
                'business_id' => $this->vehicleOwner->id,
                'business_uuid' => $this->vehicleOwner->uuid,
                'notification_type' => 'admin',
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.business-registration-received',
            text: 'emails.admin.business-registration-received-text',
            with: [
                'business' => $this->vehicleOwner,
                'businessName' => $this->vehicleOwner->business_name,
                'registrationNumber' => $this->vehicleOwner->business_registration_number,
                'ownerEmail' => $this->vehicleOwner->email,
                'submittedAt' => $this->vehicleOwner->created_at,
                // 'reviewUrl' => route('admin.business.show', $this->vehicleOwner->uuid ?? $this->vehicleOwner->id),
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
