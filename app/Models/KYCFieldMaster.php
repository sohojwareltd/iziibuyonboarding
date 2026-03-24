<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KYCFieldMaster extends Model
{
    protected $table = 'k_y_c_field_masters';

    protected $fillable = [
        'field_name',
        'internal_key',
        'kyc_section_id',
        'description',
        'data_type',
        'document_type_id',
        'options',
        'is_required',
        'sensitivity_level',
        'visible_to_merchant',
        'visible_to_admin',
        'visible_to_partner',
        'visible_countries',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'visible_to_merchant' => 'boolean',
        'visible_to_admin' => 'boolean',
        'visible_to_partner' => 'boolean',
        'options' => 'array',
        'visible_countries' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the KYC section this field belongs to.
     */
    public function kycSection()
    {
        return $this->belongsTo(KycSection::class, 'kyc_section_id');
    }

    /**
     * Get the linked document type rule set for file upload fields.
     */
    public function documentType()
    {
        return $this->belongsTo(DocumentTypesMaster::class, 'document_type_id');
    }
}
