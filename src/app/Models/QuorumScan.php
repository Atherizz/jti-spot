<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuorumScan extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'user_id',
        'room_id',
        'schedule_id',
        'claim_id',
        'scanned_date',
        'scanned_at',
    ];

    protected $casts = [
        'scanned_date' => 'date',
        'scanned_at' => 'datetime',
    ];

    /**
     * Get the user that owns the quorum scan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the room that owns the quorum scan.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the schedule that owns the quorum scan.
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
