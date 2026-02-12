<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CountrySolutionMaster extends Pivot
{
    protected $table = 'country_solution_master';

    protected $guarded = [];
}
