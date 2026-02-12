<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcquirerMaster extends Model
{
    protected $fillable = [
        'name',
        'mode',
        'is_active',
        'description',
        'supported_countries',
        'supported_solutions',
        'email_recipient',
        'email_subject_template',
        'email_body_template',
        'attachment_format',
        'secure_email_required',
        'requires_beneficial_owner_data',
        'requires_board_member_data',
        'requires_signatories',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'secure_email_required' => 'boolean',
        'requires_beneficial_owner_data' => 'boolean',
        'requires_board_member_data' => 'boolean',
        'requires_signatories' => 'boolean',
        'supported_countries' => 'array',
        'supported_solutions' => 'array',
    ];

    public function getAttributeValue($key)
    {
        $value = parent::getAttributeValue($key);
        
        // Handle JSON string to array conversion for compatibility
        if (in_array($key, ['supported_countries', 'supported_solutions'])) {
            if (is_string($value)) {
                return json_decode($value, true) ?? [];
            }
        }
        
        return $value;
    }

    public function solutionMasters()
    {
        return $this->belongsToMany(
            SolutionMaster::class,
            'acquirer_master_solution_master',
            'acquirer_master_id',
            'solution_master_id'
        )->withTimestamps();
    }
}
