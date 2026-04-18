<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'schedule_id',
        'room_claim_id',
        'class_group_id',
        'event_type',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function classGroup()
    {
        return $this->belongsTo(ClassGroup::class);
    }
}
