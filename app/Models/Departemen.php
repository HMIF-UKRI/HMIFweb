<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Departemen extends Model
{
    protected $table = 'departments';

    protected $fillable = [
        'name',
        'description',
    ];

    public function events(): HasManyThrough
    {
        return $this->hasManyThrough(Event::class, Member::class, 'department_id', 'member_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(Member::class, 'department_id');
    }

    public function pengurus(): HasMany
    {
        return $this->hasMany(Pengurus::class, 'department_id');
    }

    public function bidang(): HasMany
    {
        return $this->hasMany(Bidang::class, 'department_id');
    }
}
