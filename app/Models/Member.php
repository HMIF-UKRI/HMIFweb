<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'member';

    protected $fillable = [
        'name',
        'student_id_number',
        'image',
        'position',
        'organization_period_id',
        'department_id',
    ];

    public function organizationPeriod()
    {
        return $this->belongsTo(OrganizationPeriods::class);
    }

    public function department()
    {
        return $this->belongsTo(Departemen::class);
    }
}
