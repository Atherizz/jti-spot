<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Room;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class RoomQrPdfController extends Controller
{
    public function printAll(): Response
    {
        try {
            $rooms = Room::all()->map(function ($room) {
                // Determine label and name
                $roomLabel = $room->room_code ?? ('ROOM-' . $room->id);
                $className = $room->class_name ?? $room->name ?? $roomLabel;
                $scanUrl = route('scan.initial', $room->qr_token);
                // Reduce size internally before generating to ensure fast and low-memory creation
                $qrImageUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&margin=8&data=' . urlencode($scanUrl);

                return (object)[
                    'roomLabel' => $roomLabel,
                    'className' => $className,
                    'scanUrl' => $scanUrl,
                    'qrImageUrl' => $qrImageUrl,
                ];
            });

            return response()->view('admin.room.qr-print-all', [
                'rooms' => $rooms,
            ]);
        } catch (Throwable $exception) {
            report($exception);
            abort(500, 'Gagal memuat halaman Print QR.');
        }
    }
}