Sudah saya sesuaikan. Semua penjelasan fitur sekarang menggunakan Bahasa Indonesia yang lugas agar tim langsung paham tanggung jawabnya, tanpa menghilangkan istilah teknis Laravel (seperti *Controller*, *Middleware*, atau *Service*) agar mereka tetap familiar dengan struktur kodenya.

---

# Pembagian Tugas JTISpot - Sprint 1

Dokumen ini memuat spesifikasi teknis pengerjaan JTISpot. Pendekatan yang digunakan adalah *Feature-Based/Domain-Driven*. Setiap anggota bertanggung jawab atas satu siklus MVC (Model-View-Controller) penuh untuk fiturnya masing-masing.

**Aturan Main:** Dilarang mengubah struktur file Blade/UI HTML yang sudah ada kecuali untuk kebutuhan integrasi variabel PHP (`{{ $variable }}`) dan *state* interaktif.

---

## ⚠️ SOP Wajib Sebelum Mulai Ngoding (BACA INI!)

Urutan perintah di bawah ini wajib dijalankan setiap kali memulai sesi pengerjaan untuk memastikan sinkronisasi kode dan data:

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

**Fokus:** Keamanan validasi, otorisasi, dan logika bisnis inti sistem.

* **Action Services:** Membuat `RoomActionService` (PHP *class*) untuk logika **Klaim dan Pembatalan Ruangan**. Di sini tempat algoritma validasi koordinat GPS, pengecekan IP WiFi kampus, dan verifikasi kuorum mahasiswa.
* **QR Security Logic:** Membuat fitur **Reset Token QR** untuk memperbarui token QR Code ruangan agar foto QR yang lama tidak bisa digunakan lagi (*expired*).
* **Auth Middleware:** Mengatur dan mendaftarkan *middleware* untuk membatasi hak akses antar peran: `admin`, `student`, dan `class_rep`.

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

## 2. Adi (Student Hub & Class Rep Actions)

**Fokus:** Integrasi Dashboard Mahasiswa dan formulir aksi Ketua Kelas.
* **Monitoring Jadwal Harian:** Menampilkan daftar jadwal kelas milik mahasiswa pada hari ini dan esok hari.
* **Formulir Reservasi:** Membuat `ReservationController`. Menampilkan data pilihan ruangan (hanya yang kosong) dan jadwal asli berdasarkan kelas mahasiswa yang sedang *login*.
* **Aksi Pembatalan Kelas:** Menyediakan daftar jadwal aktif milik Ketua Kelas, di mana user dapat memilih satu jadwal spesifik untuk dibatalkan melalui sistem.
* **Progress Kuorum:** Menampilkan jumlah mahasiswa yang sudah melakukan scan untuk jadwal aktif saat ini (menggunakan simple count query).

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

**Fokus:** Pemantauan ruangan, log aktivitas scan, dan manajemen jadwal massal.

* **Daftar Monitoring Ruangan:** Membuat `AdminRoomController@index`. Menampilkan tabel semua ruangan beserta **Status Langsung** (Tersedia/Terpakai) dan fitur pencarian.
* **Detail Ruang & Log Scan:** Membuat `AdminRoomController@show` untuk menampilkan siapa saja mahasiswa yang sudah *scan* di ruangan tersebut beserta status validasinya (Sukses WiFi/GPS atau Gagal Lokasi).
* **Fitur Impor Jadwal:** Membuat sistem unggah file Excel jadwal kuliah menggunakan `Laravel-Excel` untuk dimasukkan ke database secara massal.

**Target Routes (`routes/web.php`):**

```php
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/rooms', [AdminRoomController::class, 'index']);
    Route::get('/rooms/{room}', [AdminRoomController::class, 'show']);
    Route::post('/schedules/import', [ScheduleController::class, 'import']);
});

```

## 4. Fikar (Public Facing & Live Map)

**Fokus:** Penyediaan data angka publik dan peta ruangan interaktif.

* **Guest Controller:** Mengelola semua data yang muncul di halaman depan sebelum pengguna masuk (*login*).
* **Status pada LiveMap:** Mengirimkan data ketersediaan ruang terbaru agar warna ruangan pada peta berubah (Hijau/Merah) saat halaman di-refresh.
* **Statistik Landing Page:** Menghitung jumlah ruangan "Tersedia", "Terpakai", dan "Kosong sebentar lagi" untuk ditampilkan di kotak informasi halaman utama.

**Target Routes (`routes/web.php`):**

```php
Route::get('/', [GuestController::class, 'index']);
Route::get('/map', [GuestController::class, 'map']);
Route::get('/rooms/live-status', [GuestController::class, 'liveStatus']); 

```

## 5. Arsy (Feedback Loop & User Administration)

**Fokus:** Penanganan laporan pengguna dan manajemen data akun.

* **Sistem Laporan:** Membuat fitur bagi mahasiswa untuk melaporkan ruangan yang aslinya kosong tapi di sistem tertera penuh. Admin dapat melihat daftar laporan ini untuk validasi manual.
* **Manajemen User:** MMembuat tabel daftar mahasiswa dengan Pagination dan Filtering berdasarkan kelas. Admin dapat mengubah role user dari student menjadi class_rep secara manual.
* **Halaman Profil:** Membuat halaman profil user untuk menampilkan informasi dasar akun (Nama, NIM, Kelas, Role).

**Target Routes (`routes/web.php`):**

```php
Route::middleware('auth')->group(function () {
    Route::post('/reports', [ReportController::class, 'store']);

    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/reports', [ReportController::class, 'index']);
        Route::get('/users', [UserController::class, 'index']);
        Route::put('/users/{user}/role', [UserController::class, 'updateRole']);
        Route::get('/users/{user}/profile', [UserController::class, 'profile']);
    });
});

```
