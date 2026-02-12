<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
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
        return $this->hasMany(KYCFieldMaster::class, 'kyc_section_id');
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
