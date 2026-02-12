<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolutionMaster extends Model
{
    protected $table = 'solution_masters';

    protected $guarded = [];

    protected $casts = [
        'tags' => 'array',
        'acquirers' => 'array',
        'alternative_methods' => 'array',
    ];

    /**
     * Get the category that owns the solution.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function countries()
    {
        return $this->belongsToMany(
            Country::class,
            'country_solution_master',
            'solution_master_id',
            'country_id'
        )->withTimestamps();
    }

    public function paymentMethodMasters()
    {
        return $this->belongsToMany(
            PaymentMethodMaster::class,
            'pm_master_solution_master',
            'solution_master_id',
            'payment_method_master_id'
        )->withTimestamps();
    }
}
