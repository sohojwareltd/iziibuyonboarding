<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AcquirerMasterSolutionMaster extends Pivot
{
    protected $table = 'acquirer_master_solution_master';

    protected $guarded = [];
}
