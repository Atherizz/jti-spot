<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Print QR Semua Ruangan</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; margin: 0; padding: 20px; color: #111827; background: #f9fafb; display: flex; justify-content: center; }
        .print-container { max-width: 1100px; width: 100%; margin: 0 auto; background: white; padding: 20px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
        
        .page { page-break-after: always; clear: both; width: 100%; display: flex; flex-wrap: wrap; justify-content: center; }
        
        .card { 
            width: calc(50% - 40px); margin: 20px; 
            border: 2px dashed #d1d5db; border-radius: 12px; 
            padding: 30px; box-sizing: border-box; text-align: center;
            height: 480px; page-break-inside: avoid;
        }

        .title { font-size: 26px; font-weight: bold; margin-bottom: 8px; color: #ea580c; text-transform: uppercase; }
        .subtitle { font-size: 18px; font-weight: bold; color: #1f2937; margin-bottom: 24px; }
        .qr { width: 260px; height: 260px; margin: 0 auto 20px auto; display: block; border: 1px solid #f3f4f6; border-radius: 8px; object-fit: contain; }
        .meta { font-size: 15px; font-weight: bold; color: #4b5563; text-transform: uppercase; }
        .url { font-size: 11px; color: #9ca3af; margin-top: 10px; }

        /* Khusus saat dicetak/print */
        @media print {
            @page { size: A4 landscape; margin: 10mm; }
            body { padding: 0; display: block; background: transparent; margin: 0; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .print-container { box-shadow: none; padding: 0; width: 100%; max-width: 100%; }
            .card { 
                width: 44%; margin: 2% 3%; border-color: #9ca3af; 
                height: 440px;
            }
        }
    </style>
</head>
<body>
    <div class="print-container">
        @foreach ($rooms->chunk(2) as $chunk)
            <div class="page">
                @foreach ($chunk as $room)
                    <div class="card">
                        <div class="title">{{ $room->roomLabel }}</div>
                        <div class="subtitle">{{ $room->className }}</div>
                        
                        <img class="qr" src="{{ $room->qrImageUrl }}" alt="QR {{ $room->roomLabel }}" loading="eager">
                        
                        <div class="meta">Scan untuk akses ruang</div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

    <!-- Script otomatis panggil print browser -->
    <script>
        window.addEventListener('load', function() {
            setTimeout(function() {
                window.print();
            }, 600);
        });
    </script>
</body>
</html>