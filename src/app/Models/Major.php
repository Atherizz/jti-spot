<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Major extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * Get the class groups belonging to this major.
     */
    public function classGroups(): HasMany
    {
        return $this->hasMany(ClassGroup::class, 'major', 'name');
    }
}
