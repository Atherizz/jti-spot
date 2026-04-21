<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ClassGroup;
use App\Models\Room;
use App\Models\Schedule;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Database\Eloquent\Collection;

class ScheduleImportService
{
    /**
     * Parse and import schedules from an Excel or CSV file.
     * Overwrites all existing schedules in the database.
     *
     * @param string $filePath
     * @return array<string, int> Array containing the count of successfully imported records
     * @throws Exception
     */
    public function import(string $filePath): array
    {
        try {
            return DB::transaction(function () use ($filePath) {
                // Delete all old schedule data to overwrite with the new import
                Schedule::query()->delete();

                $insertedCount = 0;
                
                // Pre-fetch rooms to prevent N+1 query problems within the loop
                $rooms = Room::pluck('id', 'name')->toArray();
                
                // Pre-fetch all class groups to resolve IDs locally
                $classGroups = ClassGroup::all();

                // Uses spatie/simple-excel to safely stream large excel/csv files
                $rows = SimpleExcelReader::create($filePath)->getRows();

                $schedulesToInsert = [];

                foreach ($rows as $row) {
                    $roomName = trim((string) ($row['Room'] ?? ''));
                    $className = trim((string) ($row['Class Name'] ?? ''));
                    $day = (int) ($row['Day'] ?? 0);
                    $startPeriod = (int) ($row['Start Period'] ?? 0);
                    $endPeriod = (int) ($row['End Period'] ?? 0);
                    $startTime = trim((string) ($row['Start Time'] ?? ''));
                    $endTime = trim((string) ($row['End Time'] ?? ''));
                    $courseCode = trim((string) ($row['Course Code'] ?? ''));

                    // Skip dynamically empty rows to prevent parsing errors
                    if (empty($roomName) && empty($className)) {
                        continue;
                    }

                    // Map Room ID using the pre-fetched array
                    $roomId = $rooms[$roomName] ?? null;
                    if (!$roomId) {
                        throw new Exception("Ruangan tidak ditemukan: {$roomName}");
                    }

                    // Resolve Class Group ID based on exact or concatenated match
                    $classGroupId = $this->resolveClassGroup($classGroups, $className);
                    if (!$classGroupId) {
                        throw new Exception("Kelas tidak ditemukan: {$className}");
                    }

                    // Assemble record to be batch-inserted
                    $schedulesToInsert[] = [
                        'room_id' => $roomId,
                        'class_group_id' => $classGroupId,
                        'day_of_week' => $day,
                        'start_period' => $startPeriod,
                        'end_period' => $endPeriod,
                        'start_time' => $this->formatTime($startTime),
                        'end_time' => $this->formatTime($endTime),
                        'course_name' => $courseCode,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                // Batch insert records for better performance
                foreach (array_chunk($schedulesToInsert, 100) as $chunk) {
                    Schedule::insert($chunk);
                    $insertedCount += count($chunk);
                }

                return ['imported_count' => $insertedCount];
            });
        } catch (Exception $e) {
            Log::error('Exception during schedule import: ' . $e->getMessage());
            throw new Exception('Gagal mengimpor jadwal. Pastikan struktur format file excel sesuai aturan sistem. (' . $e->getMessage() . ')');
        }
    }

    /**
     * Safely resolve the class group based on naming patterns from Excel matching DB records.
     * 
     * @param Collection<int, ClassGroup> $classGroups
     * @param string $className
     * @return int|null
     */
    private function resolveClassGroup(Collection $classGroups, string $className): ?int
    {
        // Default check: Exact match to name (e.g. if '1B', '3C')
        $exactMatch = $classGroups->firstWhere('name', $className);
        if ($exactMatch) {
            return $exactMatch->id;
        }
        
        // Fallback: Excel may combine major and class name (e.g., 'TI-1B', 'SIB 1B')
        // We strip non-alphanumeric chars and perform a direct comparison
        $normalizedClassName = strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', $className));
        
        /** @var ClassGroup|null $match */
        $match = $classGroups->first(function (ClassGroup $classGroup) use ($normalizedClassName) {
            $normalizedDbNameMajorFirst = strtoupper($classGroup->major . $classGroup->name);
            $normalizedDbNameNameFirst  = strtoupper($classGroup->name . $classGroup->major);
            
            return $normalizedClassName === $normalizedDbNameMajorFirst 
                || $normalizedClassName === $normalizedDbNameNameFirst;
        });

        return $match?->id;
    }

    /**
     * Ensure the time string strictly adheres to H:i:s format for database operations.
     * 
     * @param string $timeStr
     * @return string
     */
    private function formatTime(string $timeStr): string
    {
        $timeStr = trim($timeStr);

        // Native time from simple Excel could already be formatted like '07:00:00' or '07:00'
        if (preg_match('/^\d{1,2}:\d{2}(:\d{2})?$/', $timeStr)) {
            return substr_count($timeStr, ':') === 1 ? "{$timeStr}:00" : $timeStr;
        }
        
        // Attempt robust fallback parser for generic messy time types 
        return date('H:i:s', strtotime($timeStr) ?: time());
    }
}

