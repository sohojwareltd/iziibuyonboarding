<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KYCFieldMaster extends Model
{
    protected $table = 'k_y_c_field_masters';

    protected $fillable = [
        'field_name',
        'internal_key',
        'kyc_section',
        'description',
        'data_type',
        'is_required',
        'sensitivity_level',
        'visible_to_merchant',
        'visible_to_admin',
        'visible_to_partner',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'visible_to_merchant' => 'boolean',
        'visible_to_admin' => 'boolean',
        'visible_to_partner' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
