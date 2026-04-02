<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class KycSection extends Model
{
    protected $table = 'kyc_sections';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'sort_order',
        'status',
        'allow_multiple',
    ];

    protected $casts = [
        'allow_multiple' => 'boolean',
        'created_at'     => 'datetime',
        'updated_at'     => 'datetime',
    ];

    /**
     * Boot method to auto-generate slug from name.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($section) {
            if (empty($section->slug)) {
                $section->slug = Str::slug($section->name);
            }
        });
    }

    /**
     * Get the KYC fields that belong to this section.
     */
    public function kycFields()
    {
        if (!Schema::hasTable('kyc_section_field_mappings')) {
            return $this->hasMany(KYCFieldMaster::class, 'kyc_section_id')
                ->orderBy('k_y_c_field_masters.sort_order')
                ->orderBy('k_y_c_field_masters.id');
        }

        return $this->belongsToMany(KYCFieldMaster::class, 'kyc_section_field_mappings', 'kyc_section_id', 'field_id')
            ->withPivot('sort_order')
            ->orderBy('kyc_section_field_mappings.sort_order')
            ->orderBy('k_y_c_field_masters.id');
    }

    /**
     * Get the document types that belong to this section.
     */
    public function documentTypes()
    {
        return $this->hasMany(DocumentTypesMaster::class, 'kyc_section', 'slug');
    }

    /**
     * Scope: only active sections.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope: ordered by sort_order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
