<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'room_id',
        'class_group_id',
        'day_of_week',
        'start_time',
        'end_time',
        'course_name',
    ];

    /**
     * Get the room that owns the schedule.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the class group that owns the schedule.
     */
    public function classGroup()
    {
        return $this->belongsTo(ClassGroup::class);
    }

    /**
     * Get the quorum scans for the schedule.
     */
    public function quorumScans()
    {
        return $this->hasMany(QuorumScan::class);
    }
}
