<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceListMaster extends Model
{
    protected $fillable = [
        'name',
        'type',
        'currency',
        'status',
        'assignment_level',
        'assignment_rules',
        'price_lines',
        'version',
        'effective_from',
        'effective_to',
    ];

    protected $casts = [
        'assignment_rules' => 'array',
        'price_lines' => 'array',
        'effective_from' => 'date',
        'effective_to' => 'date',
    ];
}
