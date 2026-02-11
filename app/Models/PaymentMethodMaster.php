<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethodMaster extends Model
{
    protected $fillable = [
        'name',
        'display_label',
        'category',
        'description',
        'supported_countries',
        'supported_acquirers',
        'supported_solutions',
        'scheme',
        'supports_3ds',
        'allows_tokenization',
        'is_active',
        'notes',
        'requires_additional_documents',
        'requires_acquirer_configuration',
    ];

    protected $casts = [
        'supported_countries' => 'array',
        'supported_acquirers' => 'array',
        'supported_solutions' => 'array',
        'supports_3ds' => 'boolean',
        'allows_tokenization' => 'boolean',
        'is_active' => 'boolean',
        'requires_additional_documents' => 'boolean',
        'requires_acquirer_configuration' => 'boolean',
    ];

    public function countries()
    {
        return $this->belongsToMany(
            Country::class,
            'country_payment_method_master',
            'payment_method_id',
            'country_id'
        )->withTimestamps();
    }


    /**
     * Override getAttributeValue to automatically decode JSON strings to arrays
     */
    public function getAttributeValue($key)
    {
        $value = parent::getAttributeValue($key);

        // Auto-decode JSON strings for these fields
        if (in_array($key, ['supported_countries', 'supported_acquirers', 'supported_solutions'])) {
            if (is_string($value)) {
                return json_decode($value, true) ?? [];
            }
        }

        return $value;
    }
}
