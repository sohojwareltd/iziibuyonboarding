<?php

namespace App\Mail;

use App\Models\Onboarding;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KycLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Onboarding $onboarding
    )
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Complete Your KYC - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.kyc-link',
            with: [
                'onboarding' => $this->onboarding,
                'kycLink' => route('merchant.kyc.start', $this->onboarding->kyc_link),
                'businessName' => $this->onboarding->legal_business_name,
                'requestId' => $this->onboarding->request_id,
                'solutionName' => $this->onboarding->solution?->name ?? 'N/A',
                'partnerName' => $this->onboarding->partner?->title ?? 'Direct',
            ]
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
