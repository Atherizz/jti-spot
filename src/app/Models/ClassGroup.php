<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassGroup extends Model
{
    protected $fillable = [
        'name',
        'major',
    ];

    /**
     * Get the users (students) in this class group.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the schedules for this class group.
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
