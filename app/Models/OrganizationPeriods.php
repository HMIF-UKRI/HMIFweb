<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationPeriods extends Model
{
    protected $table = 'organization_periods';

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'is_current',
    ];

    public function members()
    {
        return $this->hasMany(Member::class, 'organization_period_id');
    }
}
