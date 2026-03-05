<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Information extends Model
{
    protected $table = 'informations';

    protected $fillable = [
        'onboarding_id',
        'kyc_section_id',
        'kyc_field_master_id',
        'field_key',
        'field_value',
        'group_index',
    ];

    protected $casts = [
        'group_index' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(KycSection::class, 'kyc_section_id');
    }

    public function onboarding(): BelongsTo
    {
        return $this->belongsTo(Onboarding::class);
    }

    public function field(): BelongsTo
    {
        return $this->belongsTo(KYCFieldMaster::class, 'kyc_field_master_id');
    }
}
