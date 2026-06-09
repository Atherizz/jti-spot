<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class WhatsAppNotification extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_SENT = 'sent';
    public const STATUS_FAILED = 'failed';
    public const STATUS_SKIPPED = 'skipped';

    protected $table = 'whatsapp_notifications';

    protected $fillable = [
        'class_group_id',
        'recipient_user_id',
        'event_type',
        'notifiable_type',
        'notifiable_id',
        'dedupe_key',
        'target',
        'message',
        'scheduled_for',
        'sent_at',
        'status',
        'provider_request_id',
        'provider_message_ids',
        'provider_response',
        'failure_reason',
    ];

    protected $casts = [
        'scheduled_for' => 'datetime',
        'sent_at' => 'datetime',
        'provider_message_ids' => 'array',
        'provider_response' => 'array',
    ];

    public function classGroup(): BelongsTo
    {
        return $this->belongsTo(ClassGroup::class);
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_user_id');
    }

    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeDue(Builder $query): Builder
    {
        return $query
            ->where('status', self::STATUS_PENDING)
            ->where(function (Builder $query) {
                $query
                    ->whereNull('scheduled_for')
                    ->orWhere('scheduled_for', '<=', now());
            });
    }
}
