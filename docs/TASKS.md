
---

# Pembagian Tugas JTISpot

Dokumen ini memuat spesifikasi teknis pengerjaan JTISpot. Pendekatan yang digunakan adalah *Feature-Based/Domain-Driven*. Setiap anggota bertanggung jawab atas satu siklus MVC (Model-View-Controller) penuh untuk fiturnya masing-masing.

---

## ⚠️ SOP Wajib Sebelum Mulai Ngoding (BACA INI!)

Urutan perintah di bawah ini wajib dijalankan setiap kali memulai sesi pengerjaan untuk memastikan sinkronisasi kode dan *dependencies*:

1. **Pastikan berada di branch masing-masing**, dilarang melakukan *commit* langsung ke `main`.
```bash
git checkout [nama-anggota]

```


2. **Sinkronisasi kode terbaru dari main.**
```bash
git pull origin main

```


3. **Setup Database & Data Dummy.** (Lakukan jika ada perubahan database atau saat pertama kali setup).
```bash
php artisan migrate:fresh --seed

```


4. **Setup Dependencies Frontend & Tailwind.**
```bash
npm install
npm run dev

```


5. **Jalankan Server Laravel.** (Gunakan terminal terpisah dari npm).
```bash
php artisan serve

```



---

## 1. Savero (Tech Lead & Core Security)

**Fokus:** Validasi keamanan, otorisasi, dan *business logic* utama sistem.

* **Action Services:** Implementasi `RoomActionService` (PHP *class*) untuk logika Klaim dan Batal Ruangan. Mencakup algoritma validasi koordinat GPS, pengecekan IP WiFi kampus, dan verifikasi kuorum.
* **QR Security Logic:** Fitur `Rotate Token` untuk regenerasi token QR Code ruangan agar data lama kedaluwarsa (*expired*).
* **Auth Middleware:** Konfigurasi *middleware* untuk pemisahan hak akses: `admin`, `student`, dan `class_rep`.

**Target Routes (`routes/web.php`):**

```php
Route::middleware('auth')->group(function () {
    Route::post('/token/verify', [TokenController::class, 'verify']);

    Route::middleware('class_rep')->group(function () {
        Route::post('/room/{room}/claim', [RoomActionController::class, 'claim']);
        Route::post('/room/{room}/cancel', [RoomActionController::class, 'cancel']);
    });
});

```

## 2. Fikar (Student Hub & Class Rep Actions)

**Fokus:** Integrasi UI Dashboard Mahasiswa dan formulir aksi Ketua Kelas.

* **Claim Reservation Form:** Implementasi `ReservationController`. Menyediakan data dinamis untuk *dropdown* "Room Selection" (filter ruang tersedia) dan "Original Schedule" berdasarkan ID kelas user.
* **Cancel Action Trigger:** Menghubungkan tombol "Batalkan Jadwal" pada UI ke *service* yang tersedia.
* **Live Quorum Tracker:** *Query* data dari tabel `scans` untuk menampilkan status kuorum secara *real-time* pada dashboard mahasiswa saat proses klaim berlangsung.

**Target Routes (`routes/web.php`):**

```php
Route::middleware('auth')->group(function () {
    Route::prefix('student')->middleware('student')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard']);
    });

    Route::prefix('reservation')->middleware('class_rep')->group(function () {
        Route::get('/create', [ReservationController::class, 'create']);
        Route::post('/', [ReservationController::class, 'store']);
    });
});

```

## 3. Zuhdi (Admin Room Operations & Data Logistics)

**Fokus:** Monitoring ruangan, log aktivitas scan, dan manajemen jadwal massal.

* **Room Monitoring List:** Implementasi `AdminRoomController@index`. Menampilkan tabel manajemen ruangan beserta *Live Status* dan fitur *Search*.
* **Room Detail & Live Scan Log:** Implementasi `AdminRoomController@show` untuk menampilkan histori *scan* mahasiswa beserta status validasi (WIFI/GPS/Mismatch).
* **Schedule Import Engine:** Implementasi fitur *import* Excel jadwal menggunakan `Laravel-Excel` untuk *bulk insert* ke tabel `schedules`.

**Target Routes (`routes/web.php`):**

```php
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/rooms', [AdminRoomController::class, 'index']);
    Route::get('/rooms/{room}', [AdminRoomController::class, 'show']);
    Route::post('/schedules/import', [ScheduleController::class, 'import']);
});

```

## 4. Adi (Public Facing & Live Map)

**Fokus:** Penyediaan data metrik publik dan ketersediaan ruangan secara visual.

* **Guest Controller:** Mengelola tampilan data sebelum user melakukan *login*.
* **Live Status Fetching:** Mengirimkan data ketersediaan ruang ke Blade untuk memperbarui warna pada Peta Interaktif secara dinamis.
* **Landing Page Metrics:** Agregasi data untuk menampilkan angka "Tersedia Sekarang", "Terpakai", dan "Kosong < 15 menit" pada halaman depan.

**Target Routes (`routes/web.php`):**

```php
Route::get('/', [GuestController::class, 'index']);
Route::get('/map', [GuestController::class, 'map']);
Route::get('/rooms/live-status', [GuestController::class, 'liveStatus']); 

```

## 5. Arsy (Feedback Loop & User Administration)

**Fokus:** Penanganan laporan pengguna dan manajemen data akun.

* **Report System:** Implementasi `ReportController` untuk menangani aksi "Lapor Ruang Kosong" dan menampilkan daftar laporan di panel Admin.
* **User Management:** Implementasi `UserController` untuk manajemen daftar mahasiswa, *reset password*, dan pemutakhiran *role* user.

**Target Routes (`routes/web.php`):**

```php
Route::middleware('auth')->group(function () {
    Route::post('/reports', [ReportController::class, 'store']);

    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/reports', [ReportController::class, 'index']);
        Route::get('/users', [UserController::class, 'index']);
        Route::put('/users/{user}/role', [UserController::class, 'updateRole']);
    });
});

```
