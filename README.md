
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

## 🚀 Quick Start

Jika Anda ingin menjalankan project ini secara lokal, pastikan telah melakukan instalasi PHP 8.x, Composer, dan Node.js, kemudian ikuti langkah di bawah ini:

```bash
git clone https://github.com/Atherizz/jtispot.git
cd jtispot/src
composer install
npm install
php artisan migrate --seed
php artisan serve

```

