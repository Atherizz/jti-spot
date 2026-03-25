<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomClaim extends Model
{
    protected $fillable = [
        'room_id',
        'schedule_id',
        'claimer_group_id',
        'claimed_by_user_id',
        'claim_date',
        'start_time',
        'end_time',
        'status',
    ];

    /**
     * Get the room that was claimed.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the schedule associated with the claim.
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Get the class group that claimed the room.
     */
    public function claimerGroup()
    {
        return $this->belongsTo(ClassGroup::class, 'claimer_group_id');
    }

    /**
     * Get the user who made the claim.
     */
    public function claimedByUser()
    {
        return $this->belongsTo(User::class, 'claimed_by_user_id');
    }
}
