
# 📍 JTISpot

**JTISpot** adalah platform pemantauan ketersediaan ruang kelas secara *real-time* di Jurusan Teknologi Informasi (JTI) Politeknik Negeri Malang. Sistem ini dirancang untuk mempermudah koordinasi jadwal kelas pengganti melalui validasi lokasi (GPS/WiFi) dan fitur *crowdsourcing*.

---

## 👥 Tim Pengembang

Berikut adalah anggota tim pengembang proyek JTISpot:
* **Savero Athallah H. P.** / 244107020116 
* **Adi Luhung** / 244107020088 
* **Fikar Bahrul Santoso** / 244107020160 
* **Marsyalia Fernanda** / 244107020133 
* **Muhammad Zuhdi Y** / 244107020017 

---

## 📑 Dokumentasi Proyek

Untuk memahami detail teknis, rencana pengembangan, dan pembagian tugas, silakan merujuk pada dokumen berikut:

* 📘 **[Project Plan & Roadmap](docs/PROJECT_PLAN.md)** - Penjelasan mengenai MVP, *timeline* mingguan, dan batasan fitur.
* 📋 **[Task Assignments](docs/TASKS.md)** - Detail pengerjaan teknis, SOP Git, *Controller*, dan *Routing* per anggota.
* 📐 **[System Design](docs/DESIGN.md)** - (Opsional) Berisi diagram Use Case, ERD, dan arsitektur sistem.

---

## 🚀 Quick Start (Local Development)

Pastikan laptop Anda sudah terinstal **PHP 8.3**, **Composer**, **Node.js**, dan sistem *database* PostgreSQL. Ikuti langkah-langkah instalasi ini secara berurutan:

**1. Clone Repositori & Masuk ke Direktori**
```bash
git clone [https://github.com/Atherizz/jtispot.git](https://github.com/Atherizz/jtispot.git)
cd jtispot/src

```

**2. Install Dependencies (Backend & Frontend)**

```bash
composer install
```

**3. Setup Environment Variables**
Salin *template* konfigurasi *environment* dan *generate application key* Laravel.

```bash
cp .env.example .env
php artisan key:generate

```

**4. Konfigurasi Database (PENTING!)**
Buka file `.env` yang baru saja dibuat. Sesuaikan kredensial *database* dengan yang ada di laptop Anda masing-masing (XAMPP/Laragon/Docker).

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jti_spot
DB_USERNAME=postgres
DB_PASSWORD={password}

```

**5. Migrasi, Seeding, dan Storage Link**
Setelah *database* siap, jalankan migrasi tabel beserta data *dummy*, lalu tautkan folder *storage* (penting untuk fitur QR Code/Upload).

```bash
php artisan migrate --seed
php artisan storage:link

```

**6. Jalankan Server Lokal**
Buka **dua terminal terpisah** di dalam folder `jtispot/src`.

**Terminal 1 (Untuk kompilasi aset Tailwind/Vite):**

```bash
npm install
npm run dev

```

**Terminal 2 (Untuk server Laravel):**

```bash
php artisan serve

```

Aplikasi sekarang bisa diakses di `http://localhost:8000`.

```


```
