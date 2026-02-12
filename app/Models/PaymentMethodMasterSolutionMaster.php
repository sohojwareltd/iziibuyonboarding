<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PaymentMethodMasterSolutionMaster extends Pivot
{
    protected $table = 'pm_master_solution_master';

    protected $guarded = [];
}
