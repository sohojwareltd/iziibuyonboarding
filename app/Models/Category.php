<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $guarded = [];

    public function documentTypes()
    {
        return $this->hasMany(DocumentTypesMaster::class, 'category_id');
    }
}
