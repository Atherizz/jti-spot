<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name',
        'current_status',
        'qr_token',
        'floor',
        'room_code',
        'quorum_extended_until',
    ];

    protected $casts = [
        'quorum_extended_until' => 'datetime',
    ];

    /**
     * Get the schedules for the room.
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Get the quorum scans for the room.
     */
    public function quorumScans()
    {
        return $this->hasMany(QuorumScan::class);
    }
}
