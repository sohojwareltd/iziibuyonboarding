<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Onboarding extends Model
{
    protected $fillable = [
        'solution_id',
        'partner_id',
        'legal_business_name',
        'trading_name',
        'registration_number',
        'business_website',
        'merchant_contact_email',
        'merchant_phone_number',
        'country_of_operation',
        'payment_methods',
        'acquirers',
        'price_list_id',
        'custom_pricing',
        'internal_tags',
        'internal_notes',
        'request_id',
        'status',
        'created_by',
        'approved_by',
        'sent_at',
        'approved_at',
        'kyc_link',
        'kyc_completed_at',
        'rejection_reason',
        'revision_count',
    ];

    protected $casts = [
        'payment_methods' => 'array',
        'acquirers' => 'array',
        'custom_pricing' => 'array',
        'internal_tags' => 'array',
        'sent_at' => 'datetime',
        'approved_at' => 'datetime',
        'kyc_completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the solution associated with the onboarding.
     */
    public function solution(): BelongsTo
    {
        return $this->belongsTo(SolutionMaster::class);
    }

    /**
     * Get the partner associated with the onboarding.
     */
    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    /**
     * Get the user who created the onboarding.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who approved the onboarding.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the price list associated with the onboarding.
     */
    public function priceList(): BelongsTo
    {
        return $this->belongsTo(PriceListMaster::class, 'price_list_id');
    }

    /**
     * Get acquirer names as comma-separated string.
     */
    public function getAcquirerNamesAttribute(): string
    {
        if (is_null($this->acquirers)) {
            return '';
        }

        $names = array_map(function ($code) {
            return match($code) {
                'elavon' => 'Elavon (Email Submission)',
                'surfboard' => 'Surfboard (API)',
                default => ucfirst($code),
            };
        }, $this->acquirers);

        return implode(', ', $names);
    }

    /**
     * Get payment method names as comma-separated string.
     */
    public function getPaymentMethodNamesAttribute(): string
    {
        if (is_null($this->payment_methods)) {
            return '';
        }

        $names = array_map(function ($code) {
            return match($code) {
                'visa' => 'Visa',
                'mastercard' => 'Mastercard',
                'apple-pay' => 'Apple Pay',
                'google-pay' => 'Google Pay',
                'vipps' => 'Vipps',
                default => ucfirst(str_replace('-', ' ', $code)),
            };
        }, $this->payment_methods);

        return implode(', ', $names);
    }

    /**
     * Check if onboarding is in draft status.
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    /**
     * Check if onboarding has been sent.
     */
    public function isSent(): bool
    {
        return in_array($this->status, ['sent', 'in-review', 'approved', 'active']);
    }

    /**
     * Check if KYC is completed.
     */
    public function isKycCompleted(): bool
    {
        return !is_null($this->kyc_completed_at);
    }

    /**
     * Generate unique request ID.
     */
    public static function generateRequestId(): string
    {
        $prefix = 'OBD';
        $timestamp = now()->format('YmdHi');
        $random = strtoupper(substr(uniqid(), -4));
        return "{$prefix}-{$timestamp}-{$random}";
    }

    /**
     * Generate unique KYC link token.
     */
    public static function generateKycLink(): string
    {
        return 'kyc_' . bin2hex(random_bytes(16));
    }
}
