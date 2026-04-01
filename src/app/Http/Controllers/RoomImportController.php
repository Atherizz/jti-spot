<?php

namespace App\Http\Controllers;

use App\Models\ClassGroup;
use App\Models\Room;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Throwable;

class RoomImportController extends Controller
{
    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]);

        if (! class_exists('PhpOffice\\PhpSpreadsheet\\IOFactory')) {
            return back()->with('error', 'Library Excel belum terpasang. Jalankan: composer require phpoffice/phpspreadsheet');
        }

        $hasRoomCode = Schema::hasColumn('rooms', 'room_code');
        $hasFloor = Schema::hasColumn('rooms', 'floor');

        try {
            $rows = $this->loadRows($request->file('excel_file')->getRealPath());

            if (count($rows) < 2) {
                return back()->with('error', 'File Excel kosong atau tidak memiliki data baris.');
            }

            $headers = $this->normalizeHeaders($rows[0]);

            $roomInserted = 0;
            $roomUpdated = 0;
            $scheduleInserted = 0;
            $scheduleUpdated = 0;

            DB::transaction(function () use (
                $rows,
                $headers,
                $hasRoomCode,
                $hasFloor,
                &$roomInserted,
                &$roomUpdated,
                &$scheduleInserted,
                &$scheduleUpdated
            ) {
                foreach (array_slice($rows, 1) as $rowIndex => $rowValues) {
                    $lineNumber = $rowIndex + 2;
                    $row = $this->toAssocRow($headers, $rowValues);

                    if ($this->isRowEmpty($row)) {
                        continue;
                    }

                    $roomCode = strtoupper((string) ($row['room_code'] ?? $row['kode_ruang'] ?? ''));
                    $roomName = (string) ($row['room_name'] ?? $row['nama_ruang'] ?? $row['name'] ?? '');
                    $status = strtolower((string) ($row['status'] ?? $row['current_status'] ?? 'available'));
                    $floor = $this->toNullableInt($row['floor'] ?? $row['lantai'] ?? null);

                    if ($roomCode === '' && trim($roomName) === '') {
                        // Baris jadwal tanpa room yang valid dilewati.
                        continue;
                    }

                    $room = $this->resolveRoom($roomCode, $roomName, $hasRoomCode);
                    $isNewRoom = ! $room->exists;

                    $room->name = trim($roomName) !== '' ? trim($roomName) : ($room->name ?: ($roomCode ?: ('ROOM-' . $lineNumber)));

                    if ($hasRoomCode && $roomCode !== '') {
                        $room->room_code = $roomCode;
                    }

                    if ($hasFloor && $floor !== null) {
                        $room->floor = $floor;
                    }

                    $room->current_status = in_array($status, ['available', 'waiting', 'occupied'], true)
                        ? $status
                        : 'available';

                    if (! $room->qr_token) {
                        $room->qr_token = Str::random(32);
                    }

                    $room->save();

                    if ($isNewRoom) {
                        $roomInserted++;
                    } else {
                        $roomUpdated++;
                    }

                    $courseName = trim((string) ($row['course_name'] ?? $row['mata_kuliah'] ?? $row['course'] ?? ''));
                    $classGroupName = trim((string) ($row['class_group'] ?? $row['class_name'] ?? $row['kelas'] ?? ''));
                    $majorName = trim((string) ($row['major'] ?? $row['jurusan'] ?? 'Umum'));
                    $dayOfWeek = $this->parseDayOfWeek($row['day_of_week'] ?? $row['day'] ?? $row['hari'] ?? null);
                    $startTime = $this->parseTimeValue($row['start_time'] ?? $row['jam_mulai'] ?? null);
                    $endTime = $this->parseTimeValue($row['end_time'] ?? $row['jam_selesai'] ?? null);

                    if ($courseName === '' || $classGroupName === '' || $dayOfWeek === null || $startTime === null || $endTime === null) {
                        continue;
                    }

                    $classGroup = ClassGroup::firstOrCreate(
                        [
                            'name' => $classGroupName,
                            'major' => $majorName !== '' ? $majorName : 'Umum',
                        ]
                    );

                    $schedule = Schedule::where('room_id', $room->id)
                        ->where('class_group_id', $classGroup->id)
                        ->where('day_of_week', $dayOfWeek)
                        ->where('start_time', $startTime)
                        ->where('end_time', $endTime)
                        ->where('course_name', $courseName)
                        ->first();

                    if ($schedule) {
                        $scheduleUpdated++;
                    } else {
                        Schedule::create([
                            'room_id' => $room->id,
                            'class_group_id' => $classGroup->id,
                            'day_of_week' => $dayOfWeek,
                            'start_time' => $startTime,
                            'end_time' => $endTime,
                            'course_name' => $courseName,
                        ]);
                        $scheduleInserted++;
                    }
                }
            });

            $message = "Import selesai. Room baru: {$roomInserted}, room update: {$roomUpdated}, jadwal baru: {$scheduleInserted}, jadwal existing: {$scheduleUpdated}.";

            return back()->with('success', $message);
        } catch (Throwable $e) {
            return back()->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }

    private function loadRows(string $path): array
    {
        $ioFactoryClass = 'PhpOffice\\PhpSpreadsheet\\IOFactory';
        $spreadsheet = $ioFactoryClass::load($path);

        return $spreadsheet
            ->getActiveSheet()
            ->toArray(null, true, true, false);
    }

    private function normalizeHeaders(array $headerRow): array
    {
        $headers = [];

        foreach ($headerRow as $index => $value) {
            $key = strtolower(trim((string) $value));
            $key = preg_replace('/[^a-z0-9]+/', '_', $key ?? '');
            $key = trim((string) $key, '_');
            $headers[$index] = $key !== '' ? $key : ('col_' . $index);
        }

        return $headers;
    }

    private function toAssocRow(array $headers, array $values): array
    {
        $assoc = [];

        foreach ($headers as $index => $header) {
            $value = $values[$index] ?? null;
            $assoc[$header] = is_string($value) ? trim($value) : $value;
        }

        return $assoc;
    }

    private function isRowEmpty(array $row): bool
    {
        foreach ($row as $value) {
            if ($value !== null && trim((string) $value) !== '') {
                return false;
            }
        }

        return true;
    }

    private function resolveRoom(string $roomCode, string $roomName, bool $hasRoomCode): Room
    {
        if ($hasRoomCode && $roomCode !== '') {
            return Room::firstOrNew(['room_code' => $roomCode]);
        }

        return Room::firstOrNew(['name' => trim($roomName)]);
    }

    private function parseDayOfWeek(mixed $value): ?int
    {
        if ($value === null || trim((string) $value) === '') {
            return null;
        }

        if (is_numeric($value)) {
            $day = (int) $value;
            return ($day >= 0 && $day <= 6) ? $day : null;
        }

        $normalized = strtolower(trim((string) $value));

        $map = [
            'minggu' => 0,
            'ahad' => 0,
            'sunday' => 0,
            'senin' => 1,
            'monday' => 1,
            'selasa' => 2,
            'tuesday' => 2,
            'rabu' => 3,
            'wednesday' => 3,
            'kamis' => 4,
            'thursday' => 4,
            'jumat' => 5,
            'jum\'at' => 5,
            'friday' => 5,
            'sabtu' => 6,
            'saturday' => 6,
        ];

        return $map[$normalized] ?? null;
    }

    private function parseTimeValue(mixed $value): ?string
    {
        if ($value === null || trim((string) $value) === '') {
            return null;
        }

        $excelDateClass = 'PhpOffice\\PhpSpreadsheet\\Shared\\Date';

        if (is_numeric($value) && class_exists($excelDateClass)) {
            try {
                $dt = $excelDateClass::excelToDateTimeObject((float) $value);
                return $dt->format('H:i:s');
            } catch (Throwable) {
                return null;
            }
        }

        $text = str_replace('.', ':', trim((string) $value));

        try {
            if (preg_match('/^\d{1,2}:\d{2}$/', $text) === 1) {
                return Carbon::createFromFormat('H:i', $text)->format('H:i:s');
            }

            if (preg_match('/^\d{1,2}:\d{2}:\d{2}$/', $text) === 1) {
                return Carbon::createFromFormat('H:i:s', $text)->format('H:i:s');
            }

            return Carbon::parse($text)->format('H:i:s');
        } catch (Throwable) {
            return null;
        }
    }

    private function toNullableInt(mixed $value): ?int
    {
        if ($value === null || trim((string) $value) === '') {
            return null;
        }

        if (! is_numeric($value)) {
            return null;
        }

        return (int) $value;
    }
}
