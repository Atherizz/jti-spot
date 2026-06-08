<?php

use App\Models\ClassGroup;
use App\Models\Room;
use App\Models\RoomClaim;
use App\Models\Schedule;
use App\Models\ScheduleCancellation;
use App\Models\User;
use App\Services\RoomScanService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function () {
    Carbon::setTestNow(Carbon::parse('2026-06-08 10:20:00'));
    Event::fake();
});

afterEach(function () {
    Carbon::setTestNow();
});

function createClassRepWithScheduleFixture(): array
{
    $claimerGroup = ClassGroup::create([
        'name' => '2F',
        'major' => 'TI',
    ]);

    $targetGroup = ClassGroup::create([
        'name' => '2B',
        'major' => 'TI',
    ]);

    $claimer = User::create([
        'name' => 'Class Rep',
        'email' => 'rep@example.test',
        'password' => Hash::make('password'),
        'role' => 'class_rep',
        'class_group_id' => $claimerGroup->id,
    ]);

    $targetRoom = Room::create([
        'name' => 'Lab 1',
        'current_status' => 'available',
        'qr_token' => 'target-room-token',
    ]);

    $conflictRoom = Room::create([
        'name' => 'Lab 2',
        'current_status' => 'available',
        'qr_token' => 'conflict-room-token',
    ]);

    $claimedSchedule = Schedule::create([
        'room_id' => $targetRoom->id,
        'class_group_id' => $targetGroup->id,
        'day_of_week' => 1,
        'start_time' => '10:00:00',
        'end_time' => '12:00:00',
        'course_name' => 'Basis Data',
    ]);

    $conflictSchedule = Schedule::create([
        'room_id' => $conflictRoom->id,
        'class_group_id' => $claimerGroup->id,
        'day_of_week' => 1,
        'start_time' => '10:15:00',
        'end_time' => '11:00:00',
        'course_name' => 'Pemrograman Web',
    ]);

    return [
        'claimer' => $claimer,
        'claimerGroup' => $claimerGroup,
        'targetGroup' => $targetGroup,
        'targetRoom' => $targetRoom,
        'claimedSchedule' => $claimedSchedule,
        'conflictSchedule' => $conflictSchedule,
    ];
}

function cancelFixtureConflictSchedule(array $fixture): void
{
    ScheduleCancellation::create([
        'schedule_id' => $fixture['conflictSchedule']->id,
        'cancelled_by' => $fixture['claimer']->id,
        'cancellation_date' => Carbon::now()->toDateString(),
        'cancellation_type' => 'lainnya',
        'reason' => 'Kelas dibatalkan untuk kebutuhan penggantian ruangan.',
    ]);
}

function createOtherClassRoomClaim(array $fixture, array $overrides = []): RoomClaim
{
    $emailPrefix = $overrides['email'] ?? 'other-rep';
    unset($overrides['email']);

    $otherClaimer = User::create([
        'name' => 'Other Class Rep',
        'email' => $emailPrefix . '@example.test',
        'password' => Hash::make('password'),
        'role' => 'class_rep',
        'class_group_id' => $fixture['targetGroup']->id,
    ]);

    return RoomClaim::create(array_merge([
        'room_id' => $fixture['targetRoom']->id,
        'schedule_id' => $fixture['claimedSchedule']->id,
        'claimer_group_id' => $fixture['targetGroup']->id,
        'claimed_by_user_id' => $otherClaimer->id,
        'claim_date' => Carbon::now()->toDateString(),
        'start_time' => '10:00:00',
        'end_time' => '12:00:00',
        'status' => 'pending_quorum',
    ], $overrides));
}

it('blocks claim prompt when class has an active schedule conflict', function () {
    $fixture = createClassRepWithScheduleFixture();

    $result = app(RoomScanService::class)->confirmScan(
        $fixture['claimer'],
        $fixture['targetRoom']->qr_token
    );

    expect($result['status'])->toBe('error')
        ->and($result['message'])->toContain('Kelas Anda memiliki jadwal asli yang bentrok')
        ->and($result['message'])->toContain('Pemrograman Web');
});

it('allows claim prompt when conflicting class schedule has been cancelled today', function () {
    $fixture = createClassRepWithScheduleFixture();

    cancelFixtureConflictSchedule($fixture);

    $result = app(RoomScanService::class)->confirmScan(
        $fixture['claimer'],
        $fixture['targetRoom']->qr_token
    );

    expect($result['status'])->toBe('claim_prompt')
        ->and($result['room_id'])->toBe($fixture['targetRoom']->id);
});

it('blocks submitted claim when class has an active schedule conflict', function () {
    $fixture = createClassRepWithScheduleFixture();

    $result = app(RoomScanService::class)->initiateClaim(
        $fixture['claimer'],
        $fixture['targetRoom']->qr_token,
        $fixture['conflictSchedule']->id,
        $fixture['claimedSchedule']->id
    );

    expect($result['status'])->toBe('error')
        ->and($result['message'])->toContain('Kelas Anda memiliki jadwal asli yang bentrok');

    expect(RoomClaim::count())->toBe(0);
});

it('creates submitted claim when conflicting class schedule has been cancelled today', function () {
    $fixture = createClassRepWithScheduleFixture();

    cancelFixtureConflictSchedule($fixture);

    $result = app(RoomScanService::class)->initiateClaim(
        $fixture['claimer'],
        $fixture['targetRoom']->qr_token,
        $fixture['conflictSchedule']->id,
        $fixture['claimedSchedule']->id
    );

    expect($result['status'])->toBe('success')
        ->and(RoomClaim::count())->toBe(1);

    expect($fixture['targetRoom']->fresh()->current_status)->toBe('waiting');
});

it('blocks submitted claim when original schedule belongs to another class', function () {
    $fixture = createClassRepWithScheduleFixture();

    $result = app(RoomScanService::class)->initiateClaim(
        $fixture['claimer'],
        $fixture['targetRoom']->qr_token,
        $fixture['claimedSchedule']->id,
        $fixture['claimedSchedule']->id
    );

    expect($result['status'])->toBe('error')
        ->and($result['message'])->toBe('Jadwal asli tidak terdaftar untuk kelas Anda!');
});

it('blocks submitted claim when claimed schedule belongs to another scanned room', function () {
    $fixture = createClassRepWithScheduleFixture();

    cancelFixtureConflictSchedule($fixture);

    $otherRoom = Room::create([
        'name' => 'Lab 3',
        'current_status' => 'available',
        'qr_token' => 'other-room-token',
    ]);

    $result = app(RoomScanService::class)->initiateClaim(
        $fixture['claimer'],
        $otherRoom->qr_token,
        $fixture['conflictSchedule']->id,
        $fixture['claimedSchedule']->id
    );

    expect($result['status'])->toBe('error')
        ->and($result['message'])->toBe('Jadwal yang diklaim tidak sesuai dengan ruangan yang dipindai!');
});

it('blocks claim prompt when another class has an active room claim overlap', function () {
    $fixture = createClassRepWithScheduleFixture();
    cancelFixtureConflictSchedule($fixture);
    createOtherClassRoomClaim($fixture);

    $result = app(RoomScanService::class)->confirmScan(
        $fixture['claimer'],
        $fixture['targetRoom']->qr_token
    );

    expect($result['status'])->toBe('error')
        ->and($result['message'])->toBe('Ruangan sudah direservasi atau diklaim oleh kelas lain pada slot ini. Silakan cari ruangan lain.');
});

it('blocks submitted claim when another class has an active room claim overlap', function () {
    $fixture = createClassRepWithScheduleFixture();
    cancelFixtureConflictSchedule($fixture);
    createOtherClassRoomClaim($fixture);

    $result = app(RoomScanService::class)->initiateClaim(
        $fixture['claimer'],
        $fixture['targetRoom']->qr_token,
        $fixture['conflictSchedule']->id,
        $fixture['claimedSchedule']->id
    );

    expect($result['status'])->toBe('error')
        ->and($result['message'])->toBe('Ruangan sudah direservasi atau diklaim oleh kelas lain pada slot ini. Silakan cari ruangan lain.');
});

it('allows claim prompt when another class room claim is not active or not overlapping', function () {
    $fixture = createClassRepWithScheduleFixture();
    cancelFixtureConflictSchedule($fixture);
    createOtherClassRoomClaim($fixture, [
        'email' => 'completed-rep',
        'status' => 'completed',
    ]);
    createOtherClassRoomClaim($fixture, [
        'email' => 'past-rep',
        'start_time' => '08:00:00',
        'end_time' => '09:00:00',
    ]);

    $result = app(RoomScanService::class)->confirmScan(
        $fixture['claimer'],
        $fixture['targetRoom']->qr_token
    );

    expect($result['status'])->toBe('claim_prompt')
        ->and($result['room_id'])->toBe($fixture['targetRoom']->id);
});
