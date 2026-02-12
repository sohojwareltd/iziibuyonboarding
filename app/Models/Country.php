<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'code',
    ];

    public function paymentMethods()
    {
        return $this->belongsToMany(
            PaymentMethodMaster::class,
            'country_payment_method_master',   // pivot table
            'country_id',                      // this model fk in pivot
            'payment_method_id'                // related model fk in pivot
        )->withTimestamps();
    }

    public function solutionMasters()
    {
        return $this->belongsToMany(
            SolutionMaster::class,
            'country_solution_master',
            'country_id',
            'solution_master_id'
        )->withTimestamps();
    }

    /**
     * Scope to search countries by name or code.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'LIKE', "%{$search}%")
            ->orWhere('code', 'LIKE', "%{$search}%");
    }
}
