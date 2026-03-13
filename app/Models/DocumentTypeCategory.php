<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentTypeCategory extends Model
{
    protected $table = 'document_type_categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function documentTypes()
    {
        return $this->hasMany(DocumentTypesMaster::class, 'category_id');
    }
}
