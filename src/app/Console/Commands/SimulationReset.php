<?php

namespace App\Console\Commands;

use App\Models\QuorumScan;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SimulationReset extends Command
{
    protected $signature   = 'simulation:reset {--force : Skip confirmation prompt}';
    protected $description = 'Reset today\'s simulation: delete sim-user QuorumScans and set all rooms back to available';

    public function handle(): void
    {
        $today = Carbon::today()->toDateString();

        if (!$this->option('force')) {
            $this->warn("This will:");
            $this->line("  1. Delete all sim-user QuorumScans for today ({$today})");
            $this->line("  2. Reset every room with status [waiting] or [occupied] → [available]");

            if (!$this->confirm('Continue?')) {
                $this->info('Reset cancelled.');
                return;
            }
        }

        // Delete scans belonging to sim users only (identified by email pattern)
        $simUserIds = DB::table('users')
            ->where('email', 'like', 'sim.%@example.com')
            ->pluck('id');

        $deletedScans = QuorumScan::where('scanned_date', $today)
            ->whereIn('user_id', $simUserIds)
            ->delete();

        // Reset room statuses
        $resetRooms = Room::whereIn('current_status', ['waiting', 'occupied'])
            ->update(['current_status' => 'available']);

        $this->info('Simulation reset complete:');
        $this->line("  · Deleted {$deletedScans} QuorumScan records for {$today}");
        $this->line("  · Reset {$resetRooms} room(s) → available");
    }
}
