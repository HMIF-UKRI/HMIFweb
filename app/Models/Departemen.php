<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    protected $table = 'departemens';

    protected $fillable = [
        'name',
        'description',
    ];

    public function members()
    {
        return $this->hasMany(Member::class, 'department_id');
    }
}
