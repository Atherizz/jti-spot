<?php

namespace App\Services;

use App\Models\QuorumScan;
use App\Models\RoomClaim;
use App\Models\Schedule;
use App\Models\ScheduleCancellation;
use App\Models\User;
use App\Models\WhatsAppNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class WhatsAppNotificationService
{
    public function __construct(
        private readonly WhatsAppService $whatsApp,
        private readonly WhatsAppMessageFactory $messageFactory,
    ) {
    }

    public function queueOpportunityAlert(ScheduleCancellation $cancellation): int
    {
        $cancellation->loadMissing(['schedule.room', 'schedule.classGroup']);
        $schedule = $cancellation->schedule;

        if (! $schedule) {
            return 0;
        }

        $cancellationDate = Carbon::parse($cancellation->cancellation_date)->toDateString();

        $alreadyClaimed = RoomClaim::where('schedule_id', $schedule->id)
            ->where('claim_date', $cancellationDate)
            ->whereIn('status', ['pending_quorum', 'locked'])
            ->exists();

        if ($alreadyClaimed) {
            return 0;
        }

        $recipients = User::query()
            ->with('classGroup')
            ->where('role', 'class_rep')
            ->whereNotNull('phone_number')
            ->where('phone_number', '!=', '')
            ->where('class_group_id', '!=', $schedule->class_group_id)
            ->whereHas('classGroup', function ($query) {
                $query->where('room_opportunity_alert_enabled', true);
            })
            ->orderBy('class_group_id')
            ->orderBy('id')
            ->get();

        $queued = 0;

        foreach ($recipients as $recipient) {
            $conflict = $this->findActiveScheduleConflict(
                (int) $recipient->class_group_id,
                $schedule,
                $cancellationDate
            );

            $notification = $this->createNotification(
                recipient: $recipient,
                eventType: 'room_opportunity',
                notifiable: $cancellation,
                dedupeKey: "room_opportunity:cancellation:{$cancellation->id}:recipient:{$recipient->id}",
                message: $this->messageFactory->opportunityAlert(
                    $cancellation,
                    (bool) $conflict,
                    $conflict?->course_name
                ),
                scheduledFor: now()
            );

            if ($notification->wasRecentlyCreated) {
                $queued++;
            }
        }

        return $queued;
    }

    public function queueReservationReminder(RoomClaim $claim): int
    {
        $claim->loadMissing(['room', 'schedule', 'claimerGroup.users']);
        $startAt = Carbon::parse($claim->claim_date . ' ' . $claim->start_time);
        $scheduledFor = $startAt->copy()->subHours(3);

        if ($scheduledFor->isPast()) {
            $scheduledFor = now();
        }

        return $this->queueForClassReps(
            claim: $claim,
            eventType: 'reservation_reminder',
            keySuffix: 't3h',
            messageBuilder: fn () => $this->messageFactory->reservationReminder($claim),
            scheduledFor: $scheduledFor
        );
    }

    public function queueQuorumCriticalForClaim(RoomClaim $claim): int
    {
        $claim->loadMissing(['room', 'schedule', 'claimerGroup.users']);
        $quorumSize = (int) env('QUORUM_SIZE', 5);
        $currentQuorum = QuorumScan::where('claim_id', $claim->id)
            ->where('scanned_date', Carbon::parse($claim->claim_date)->toDateString())
            ->count();

        if ($currentQuorum >= $quorumSize) {
            return 0;
        }

        return $this->queueForClassReps(
            claim: $claim,
            eventType: 'quorum_critical',
            keySuffix: Carbon::parse($claim->claim_date)->toDateString(),
            messageBuilder: fn () => $this->messageFactory->quorumCritical($claim, $currentQuorum, $quorumSize),
            scheduledFor: now()
        );
    }

    public function sendDueNotifications(int $limit = 50): int
    {
        $sent = 0;

        WhatsAppNotification::due()
            ->oldest('scheduled_for')
            ->oldest('id')
            ->limit($limit)
            ->get()
            ->each(function (WhatsAppNotification $notification) use (&$sent) {
                $result = $this->whatsApp->send($notification);

                if ($result->status === WhatsAppNotification::STATUS_SENT) {
                    $sent++;
                }
            });

        return $sent;
    }

    public function queueDueQuorumCriticalAlerts(): int
    {
        $now = Carbon::now();

        $claims = RoomClaim::with(['room', 'schedule', 'claimerGroup.users'])
            ->where('claim_date', $now->toDateString())
            ->where('status', 'pending_quorum')
            ->whereTime('start_time', '<=', $now->copy()->subMinutes(10)->format('H:i:s'))
            ->whereTime('start_time', '>', $now->copy()->subMinutes(15)->format('H:i:s'))
            ->get();

        return $claims->sum(fn (RoomClaim $claim) => $this->queueQuorumCriticalForClaim($claim));
    }

    private function queueForClassReps(
        RoomClaim $claim,
        string $eventType,
        string $keySuffix,
        callable $messageBuilder,
        Carbon $scheduledFor
    ): int {
        $recipients = $claim->claimerGroup?->users
            ->where('role', 'class_rep')
            ->filter(fn (User $user) => filled($user->phone_number))
            ->values() ?? collect();

        $queued = 0;

        foreach ($recipients as $recipient) {
            $notification = $this->createNotification(
                recipient: $recipient,
                eventType: $eventType,
                notifiable: $claim,
                dedupeKey: "{$eventType}:claim:{$claim->id}:{$keySuffix}:recipient:{$recipient->id}",
                message: $messageBuilder(),
                scheduledFor: $scheduledFor
            );

            if ($notification->wasRecentlyCreated) {
                $queued++;
            }
        }

        return $queued;
    }

    private function createNotification(
        User $recipient,
        string $eventType,
        Model $notifiable,
        string $dedupeKey,
        string $message,
        Carbon $scheduledFor
    ): WhatsAppNotification {
        return WhatsAppNotification::firstOrCreate(
            ['dedupe_key' => $dedupeKey],
            [
                'class_group_id' => $recipient->class_group_id,
                'recipient_user_id' => $recipient->id,
                'event_type' => $eventType,
                'notifiable_type' => $notifiable::class,
                'notifiable_id' => $notifiable->getKey(),
                'target' => (string) $recipient->phone_number,
                'message' => $message,
                'scheduled_for' => $scheduledFor,
                'status' => WhatsAppNotification::STATUS_PENDING,
            ]
        );
    }

    private function findActiveScheduleConflict(int $classGroupId, Schedule $sourceSchedule, string $date): ?Schedule
    {
        $targetDate = Carbon::parse($date);

        $conflictingSchedules = Schedule::where('class_group_id', $classGroupId)
            ->where('day_of_week', $targetDate->dayOfWeek)
            ->where('start_time', '<', $sourceSchedule->end_time)
            ->where('end_time', '>', $sourceSchedule->start_time)
            ->orderBy('start_time')
            ->get();

        if ($conflictingSchedules->isEmpty()) {
            return null;
        }

        $cancelledScheduleIds = ScheduleCancellation::whereIn('schedule_id', $conflictingSchedules->pluck('id'))
            ->where('cancellation_date', $date)
            ->pluck('schedule_id');

        return $conflictingSchedules->first(
            fn (Schedule $schedule) => ! $cancelledScheduleIds->contains($schedule->id)
        );
    }
}
