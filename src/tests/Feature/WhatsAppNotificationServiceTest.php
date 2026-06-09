<?php

use App\Models\ClassGroup;
use App\Models\Room;
use App\Models\RoomClaim;
use App\Models\Schedule;
use App\Models\ScheduleCancellation;
use App\Models\User;
use App\Models\WhatsAppNotification;
use App\Services\WhatsAppNotificationService;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

uses(RefreshDatabase::class);

beforeEach(function () {
    Carbon::setTestNow(Carbon::parse('2026-06-09 09:00:00'));

    config([
        'services.fonnte.token' => 'testing-token',
        'services.fonnte.base_url' => 'https://api.fonnte.com',
        'services.fonnte.country_code' => '62',
        'services.fonnte.connect_only' => true,
    ]);
});

afterEach(function () {
    Carbon::setTestNow();
});

function createClassGroupFixture(string $name, bool $alertEnabled = false): ClassGroup
{
    return ClassGroup::create([
        'name' => $name,
        'major' => 'TI',
        'room_opportunity_alert_enabled' => $alertEnabled,
    ]);
}

function createClassRepFixture(ClassGroup $classGroup, array $overrides = []): User
{
    return User::create(array_merge([
        'name' => "Ketua {$classGroup->name}",
        'email' => strtolower($classGroup->name) . '@example.test',
        'password' => Hash::make('password'),
        'role' => 'class_rep',
        'class_group_id' => $classGroup->id,
        'phone_number' => '08123456789',
    ], $overrides));
}

function createRoomFixture(string $name = 'Lab 1'): Room
{
    return Room::create([
        'name' => $name,
        'current_status' => 'available',
        'qr_token' => strtolower(str_replace(' ', '-', $name)) . '-token',
    ]);
}

it('queues room opportunity alerts only for enabled class reps and labels schedule conflicts', function () {
    $cancelGroup = createClassGroupFixture('2A');
    $targetGroup = createClassGroupFixture('2B', true);
    $disabledGroup = createClassGroupFixture('2C', false);

    $canceller = createClassRepFixture($cancelGroup, ['email' => 'cancel@example.test']);
    $recipient = createClassRepFixture($targetGroup, ['email' => 'target@example.test', 'phone_number' => '0811111111']);
    createClassRepFixture($disabledGroup, ['email' => 'disabled@example.test', 'phone_number' => '0822222222']);

    $room = createRoomFixture('Lab Pembatalan');
    $conflictRoom = createRoomFixture('Lab Bentrok');

    $cancelledSchedule = Schedule::create([
        'room_id' => $room->id,
        'class_group_id' => $cancelGroup->id,
        'day_of_week' => 2,
        'start_time' => '13:00:00',
        'end_time' => '15:00:00',
        'course_name' => 'Basis Data',
    ]);

    Schedule::create([
        'room_id' => $conflictRoom->id,
        'class_group_id' => $targetGroup->id,
        'day_of_week' => 2,
        'start_time' => '14:00:00',
        'end_time' => '16:00:00',
        'course_name' => 'Pemrograman Web',
    ]);

    $cancellation = ScheduleCancellation::create([
        'schedule_id' => $cancelledSchedule->id,
        'cancelled_by' => $canceller->id,
        'cancellation_date' => '2026-06-09',
        'cancellation_type' => 'lainnya',
        'reason' => 'Dosen berhalangan hadir.',
    ]);

    $queued = app(WhatsAppNotificationService::class)->queueOpportunityAlert($cancellation);

    expect($queued)->toBe(1)
        ->and(WhatsAppNotification::count())->toBe(1);

    $notification = WhatsAppNotification::first();

    expect($notification->recipient_user_id)->toBe($recipient->id)
        ->and($notification->event_type)->toBe('room_opportunity')
        ->and($notification->message)->toContain('Bentrok jadwal: Pemrograman Web')
        ->and($notification->message)->toContain('Reservasi:');
});

it('deduplicates opportunity alerts for the same cancellation and recipient', function () {
    $cancelGroup = createClassGroupFixture('2A');
    $targetGroup = createClassGroupFixture('2B', true);
    $canceller = createClassRepFixture($cancelGroup, ['email' => 'cancel@example.test']);
    createClassRepFixture($targetGroup, ['email' => 'target@example.test']);
    $room = createRoomFixture();

    $schedule = Schedule::create([
        'room_id' => $room->id,
        'class_group_id' => $cancelGroup->id,
        'day_of_week' => 2,
        'start_time' => '13:00:00',
        'end_time' => '15:00:00',
        'course_name' => 'Basis Data',
    ]);

    $cancellation = ScheduleCancellation::create([
        'schedule_id' => $schedule->id,
        'cancelled_by' => $canceller->id,
        'cancellation_date' => '2026-06-09',
    ]);

    $service = app(WhatsAppNotificationService::class);

    expect($service->queueOpportunityAlert($cancellation))->toBe(1)
        ->and($service->queueOpportunityAlert($cancellation))->toBe(0)
        ->and(WhatsAppNotification::count())->toBe(1);
});

it('queues reservation reminders three hours before claim start', function () {
    $claimerGroup = createClassGroupFixture('2F');
    $ownerGroup = createClassGroupFixture('2A');
    $classRep = createClassRepFixture($claimerGroup);
    $room = createRoomFixture();

    $schedule = Schedule::create([
        'room_id' => $room->id,
        'class_group_id' => $ownerGroup->id,
        'day_of_week' => 2,
        'start_time' => '14:00:00',
        'end_time' => '16:00:00',
        'course_name' => 'Jaringan Komputer',
    ]);

    $claim = RoomClaim::create([
        'room_id' => $room->id,
        'schedule_id' => $schedule->id,
        'claimer_group_id' => $claimerGroup->id,
        'claimed_by_user_id' => $classRep->id,
        'claim_date' => '2026-06-09',
        'start_time' => '14:00:00',
        'end_time' => '16:00:00',
        'status' => 'pending_quorum',
    ]);

    expect(app(WhatsAppNotificationService::class)->queueReservationReminder($claim))->toBe(1);

    $notification = WhatsAppNotification::first();

    expect($notification->event_type)->toBe('reservation_reminder')
        ->and($notification->scheduled_for->format('Y-m-d H:i:s'))->toBe('2026-06-09 11:00:00')
        ->and($notification->message)->toContain('Reminder Reservasi')
        ->and($notification->recipient_user_id)->toBe($classRep->id);
});

it('updates outbox status from successful fonnte response', function () {
    Http::fake([
        'https://api.fonnte.com/send' => Http::response([
            'detail' => 'success! message in queue',
            'id' => ['80367170'],
            'requestid' => 2937124,
            'status' => true,
            'target' => ['628123456789'],
        ]),
    ]);

    $group = createClassGroupFixture('2F');
    $recipient = createClassRepFixture($group);

    $notification = WhatsAppNotification::create([
        'class_group_id' => $group->id,
        'recipient_user_id' => $recipient->id,
        'event_type' => 'test',
        'dedupe_key' => 'test:success',
        'target' => '08123456789',
        'message' => 'test message',
        'scheduled_for' => now(),
        'status' => WhatsAppNotification::STATUS_PENDING,
    ]);

    $result = app(WhatsAppService::class)->send($notification);

    expect($result->status)->toBe(WhatsAppNotification::STATUS_SENT)
        ->and($result->provider_request_id)->toBe('2937124')
        ->and($result->provider_message_ids)->toBe(['80367170']);

    Http::assertSent(fn ($request) => $request->hasHeader('Authorization', 'testing-token')
        && $request['target'] === '08123456789'
        && $request['countryCode'] === '62');
});

it('updates outbox status from failed fonnte response', function () {
    Http::fake([
        'https://api.fonnte.com/send' => Http::response([
            'reason' => 'target invalid',
            'status' => false,
            'requestid' => 2937124,
        ], 200),
    ]);

    $group = createClassGroupFixture('2F');
    $recipient = createClassRepFixture($group);

    $notification = WhatsAppNotification::create([
        'class_group_id' => $group->id,
        'recipient_user_id' => $recipient->id,
        'event_type' => 'test',
        'dedupe_key' => 'test:failed',
        'target' => 'not-a-number',
        'message' => 'test message',
        'scheduled_for' => now(),
        'status' => WhatsAppNotification::STATUS_PENDING,
    ]);

    $result = app(WhatsAppService::class)->send($notification);

    expect($result->status)->toBe(WhatsAppNotification::STATUS_FAILED)
        ->and($result->failure_reason)->toBe('target invalid');
});

it('allows class reps with phone number to toggle opportunity alert mode', function () {
    $group = createClassGroupFixture('2F');
    $user = createClassRepFixture($group, ['phone_number' => '08123456789']);

    $this->actingAs($user)
        ->post(route('student.action.opportunity-alert-mode'), ['enabled' => '1'])
        ->assertRedirect();

    expect($group->fresh()->room_opportunity_alert_enabled)->toBeTrue();
});

it('blocks enabling opportunity alert mode when class rep has no phone number', function () {
    $group = createClassGroupFixture('2F');
    $user = createClassRepFixture($group, ['phone_number' => null]);

    $this->actingAs($user)
        ->from(route('student.action.center'))
        ->post(route('student.action.opportunity-alert-mode'), ['enabled' => '1'])
        ->assertRedirect(route('student.action.center'));

    expect($group->fresh()->room_opportunity_alert_enabled)->toBeFalse();
});
