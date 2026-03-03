# JTISpot - Real-Time Room Management System
JTISpot adalah sistem manajemen ruang kelas transaksional yang mencegah *idle time* ruangan dan *ghost booking* melalui mekanisme kuorum fisik (QR Scan) dan validasi lokasi.

## 🎯 Scope MVP (Minimum Viable Product)

1. **Master Data Management:** Fitur CRUD (Create, Read, Update, Delete) Ruangan, Jadwal, User, dan fungsionalitas *Import* Excel untuk jadwal awal semester (Khusus Admin).

2. **Dynamic Room Dashboard:** Visualisasi UI *Dashboard* ruangan (Merah: Penuh, Kuning: Menunggu Kuorum, Hijau: Kosong) yang datanya ditarik langsung dari status *database*.

3. **Reservasi Terjadwal (H-1):** Pemesanan ruang terencana yang **wajib** melalui *Approval* (Persetujuan) dari Dosen pengampu.

4. **Validasi Kuorum Kelas Reguler**: Mekanisme check-in menggunakan Scan QR Pintu + Validasi Jaringan *(IP/GPS)* bagi mahasiswa yang memiliki jadwal resmi saat itu. Jika dalam 15 menit kuorum (5 orang) tidak terpenuhi, sistem otomatis membatalkan jadwal hari itu dan merilis ruangan menjadi tersedia (Hijau).

5. **Klaim Instan (Hari-H):** Perebutan ruangan kosong secara *real-time* menggunakan Scan QR Pintu + Validasi Jaringan (IP JTI/GPS) + Syarat Kuorum (5 orang) dalam 15 menit. Tanpa *Approval* dosen.

6. **Pembatalan Jadwal/Kelas:** Fitur bagi Ketua Kelas untuk membatalkan jadwal resmi. Jika dilakukan H-1, slot masuk ke ketersediaan Reservasi Terjadwal. Jika dilakukan pada Hari-H, slot langsung masuk ke ketersediaan Klaim Instan (Scan QR).

## 📅 The 14-Week Battle Plan

**Phase 1: Foundation & Architecture (Pekan 1 - 3)**
- [ ] **Pekan 1:** Finalisasi ERD, *Setup Repository*, dan pembagian tugas di Trello.
- [ ] **Pekan 2:** *Setup* Proyek Laravel, pembuatan *Database Migration* (Urutan wajib: Tabel Master dulu, baru Transaksi).
- [ ] **Pekan 3:** Eksekusi Autentikasi (Login/SSO), *Role Middleware* (Admin, Dosen, Ketua Kelas, Mahasiswa), dan *Setup Master Layout Blade* (Sidebar & Navbar).

**Phase 2: Master Data & Bureaucracy (Pekan 4 - 6)**
- [ ] **Pekan 4:** Pembuatan *Controller* & *Blade Views* untuk CRUD Ruangan dan Data User.
- [ ] **Pekan 5:** Integrasi *Library* `maatwebsite/excel` untuk eksekusi unggah Jadwal SIAKAD (Admin).
- [ ] **Pekan 6:** Pembuatan *Form* Reservasi H-1 (untuk Ketua Kelas) beserta halaman *Approval/Reject* khusus Aktor Dosen.

**Phase 3: The Core Engine (Pekan 7 - 10) 
- [ ] **Pekan 7:** Pembuatan *Controller* Klaim Instan (Hari-H) menggunakan QR Token. Penanganan *Race Condition* saat eksekusi `INSERT` ke tabel `room_claims`.
- [ ] **Pekan 8:** Pembuatan *Logic Quorum Scan* dengan validasi *Middleware* untuk GPS Radius & IP Address JTI.
- [ ] **Pekan 9:** Implementasi *Cron Job / Task Scheduling* di Laravel untuk mendeteksi status `pending_quorum` yang melewati 15 menit dan membatalkannya secara otomatis.
- [ ] **Pekan 10:** Penyempurnaan *User Experience* (UX) pada halaman Scan QR agar eksekusi *submit* berjalan di bawah 5 detik tanpa beban aset visual yang berat.

**Phase 4: Integration & Quality Assurance (Pekan 11 - 13)**
- [ ] **Pekan 11:** Integrasi total fitur Hari-H. Memastikan perubahan status di *database* tertampil akurat pada *Dashboard* Peta 3 Warna.
- [ ] **Pekan 12:** *System Testing & Bug Hunting*. Simulasi skenario gagal kuorum, *double booking*, dan bentrok jadwal.
- [ ] **Pekan 13:** Perbaikan *Bug* (*Refactoring*) dan finalisasi kerapian UI *Blade Views* agar layak dipresentasikan.

**Phase 5: Finalization & Handover (Pekan 14)**
- [ ] **Pekan 14:** *Deployment* ke *Server/Hosting* kampus dan penyusunan draf Bab akhir Laporan PBL.
