<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentTypesMaster extends Model
{
    protected $table = 'document_types_masters';

    protected $fillable = [
        'document_name',
        'category',
        'description',
        'allowed_file_types',
        'max_file_size',
        'min_pages',
        'sensitivity_level',
        'visible_to_merchant',
        'visible_to_admin',
        'mask_metadata',
        'required_acquirers',
        'required_countries',
        'required_solutions',
        'kyc_section',
        'status',
        'internal_notes',
    ];

    protected $casts = [
        'allowed_file_types' => 'array',
        'required_acquirers' => 'array',
        'required_countries' => 'array',
        'required_solutions' => 'array',
        'visible_to_merchant' => 'boolean',
        'visible_to_admin' => 'boolean',
        'mask_metadata' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
