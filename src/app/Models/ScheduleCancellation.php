<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduleCancellation extends Model
{
    /**
     * Tabel hanya memiliki created_at (tidak ada updated_at).
     */
    public $timestamps = false;

    protected $fillable = [
        'schedule_id',
        'cancelled_by',
        'cancellation_date',
        'cancellation_type',
        'reason',
        'created_at',
    ];

    protected $casts = [
        'cancellation_date' => 'date',
        'created_at'        => 'datetime',
    ];

    // ─── Relations ───────────────────────────────────────────────

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function cancelledBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }

    // ─── Helpers ─────────────────────────────────────────────────



    /**
     * Label human-readable untuk tipe pembatalan.
     */
    public function typeLabel(): string
    {
        return match ($this->cancellation_type) {
            'sakit'           => 'Sakit / Kondisi Medis',
            'kegiatan_kampus' => 'Kegiatan Resmi Kampus',
            'musibah'         => 'Musibah / Force Majeure',
            default           => 'Lainnya',
        };
    }
}
