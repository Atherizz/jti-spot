# Laporan Praktikum Jobsheet 03: Migration, Seeder, DB Facade, Query Builder, dan Eloquent ORM

**Mata Kuliah:** Pemrograman Web Lanjut (PWL)
**Nama:** [Masukkan Nama Anda]
**NIM:** [Masukkan NIM Anda]
**Kelas:** [Masukkan Kelas Anda]

---

## A. Pengaturan Database

**Praktikum 1 - Pengaturan Database**
* **Hasil/Screenshot:**
    [Sertakan Screenshot database `jti_spot` di pgAdmin atau phpMyAdmin]
    [Sertakan Screenshot file `.env` bagian DB connection di sini]
* **Pengamatan:**
    Pada langkah ini, database bernama `jti_spot` berhasil dibuat di PostgreSQL. File `.env` pada project Laravel juga telah disesuaikan dengan kredensial database lokal (DB_CONNECTION=pgsql, DB_DATABASE=jti_spot, DB_USERNAME=postgres, DB_PASSWORD=Katasandi56) sehingga aplikasi Laravel dapat terhubung dan melakukan operasi ke database tersebut.

---

## B. Migration

### Praktikum 2.1 - Pembuatan file migrasi tanpa relasi
* **Kode `create_class_groups_table`, `create_rooms_table`:**
    ```php
    // create_class_groups_table
    Schema::create('class_groups', function (Blueprint $table) {
        $table->id();
        $table->string('name', 50);
        $table->string('major', 50);
        $table->timestamps();
    });

    // create_rooms_table
    Schema::create('rooms', function (Blueprint $table) {
        $table->smallIncrements('id');
        $table->string('name', 100);
        $table->enum('current_status', ['available', 'waiting', 'occupied'])->default('available');
        $table->string('qr_token', 32)->unique();
        $table->timestamps();
    });
    ```
* **Hasil/Screenshot:**
    [Sertakan Screenshot struktur tabel di pgAdmin untuk `class_groups`, `rooms`]
* **Pengamatan:**
    Tabel-tabel master yang tidak memiliki foreign key dibuat lebih awal. File migration ini menggunakan berbagai method dari Blueprint seperti `id()` untuk primary key, `string()` untuk VARCHAR, `enum()` untuk tipe enum, dan `unique()` untuk mencegah duplikasi data. Perintah `php artisan migrate` mengeksekusi method `up()` pada file tersebut untuk meng-generate tabel fisik di database.
    ```php
    // Contoh untuk m_level
    Schema::create('m_level', function (Blueprint $table) {
        $table->id('level_id');
        $table->string('level_kode', 10)->unique();
        $table->string('level_nama', 100);
        $table->timestamps();
    });
    ```
* **Hasil/Screenshot:**
    [Sertakan Screenshot struktur tabel di phpMyAdmin untuk `m_level`, `m_kategori`, dan `m_supplier` di sini]
* **Pengamatan:**
    Tabel-tabel master yang tidak memiliki *foreign key* dibuat lebih awal. File migration ini menggunakan berbagai method dari Blueprint seperti `id()` untuk *primary key*, `string()` untuk VARCHAR, dan `unique()` untuk mencegah duplikasi data. Perintah `php artisan migrate` mengeksekusi method `up()` pada file tersebut untuk meng-generate tabel fisik di database.

### Praktikum 2.2 - Pembuatan file migrasi dengan relasi
* **Kode `create_schedules_table`, `add_class_group_id_to_users_table`:**
    ```php
    // create_schedules_table
    Schema::create('schedules', function (Blueprint $table) {
        $table->id();
        $table->unsignedSmallInteger('room_id');
        $table->foreignId('class_group_id')->constrained()->onDelete('cascade');
        $table->smallInteger('day_of_week');
        $table->time('start_time');
        $table->time('end_time');
        $table->string('course_name', 255);
        $table->timestamps();

        $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
    });

    // add_class_group_id_to_users_table
    Schema::table('users', function (Blueprint $table) {
        $table->enum('role', ['student', 'class_rep', 'admin'])->default('student');
        $table->foreignId('class_group_id')->nullable()->constrained('class_groups')->nullOnDelete();
    });
    ```
* **Hasil/Screenshot:**
    [Sertakan Screenshot menu Designer di pgAdmin yang menunjukkan relasi antar tabel]
* **Pengamatan:**
    Pembuatan tabel berelasi dilakukan setelah tabel masternya (tabel rujukan) dibuat. Kolom foreign key (seperti `room_id` pada `schedules`) didefinisikan dengan tipe `unsignedSmallInteger` agar identik dengan tipe data rujukan dari tabel rooms. Penggunaan `foreign()->references()->on()` menciptakan rujukan constraint relasional secara fisik di database.

---

## C. Seeder

### Praktikum 3 - Membuat file seeder
* **Kode `ClassGroupSeeder`, `RoomSeeder`:**
    ```php
    // ClassGroupSeeder
    $classGroups = [];
    for ($level = 1; $level <= 4; $level++) {
        for ($i = 0; $i < 7; $i++) {
            $className = $level . chr(65 + $i);
            $classGroups[] = [
                'name' => $className,
                'major' => 'SIB',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        // Tambahkan untuk TI juga
    }
    DB::table('class_groups')->insert($classGroups);

    // RoomSeeder
    $rooms = [
        ['name' => 'Ruang Teori 1', 'current_status' => 'available', 'qr_token' => Str::random(32)],
        ['name' => 'Ruang Teori 2', 'current_status' => 'available', 'qr_token' => Str::random(32)],
        // ...
    ];
    DB::table('rooms')->insert($rooms);
    ```
* **Hasil/Screenshot:**
    [Sertakan Screenshot isi data tabel di pgAdmin setelah Seeder dijalankan]
* **Pengamatan:**
    Seeder sangat berguna untuk mengisi data awal (dummy) ke dalam tabel, terutama data vital seperti Class Groups dan Rooms yang dibutuhkan saat aplikasi pertama kali berjalan. Proses `php artisan db:seed` mengeksekusi array data ke dalam query insert ke database. Penggunaan `Str::random(32)` untuk generate QR token unik.

---

## D. DB Facade

### Praktikum 4 - Implementasi DB Facade
* **Langkah 4 (Insert):**
    * **Hasil:** [Sertakan Screenshot browser hasil eksekusi dan isi tabel `rooms`]
    * **Pengamatan:** Data "Ruang Teori 10" berhasil ditambahkan menggunakan fungsi `DB::insert` dengan penulisan raw SQL dan parameter binding `(?, ?, ?)`.
* **Langkah 6 (Update):**
    * **Hasil:** [Sertakan Screenshot browser hasil eksekusi dan isi tabel `rooms`]
    * **Pengamatan:** Fungsi `DB::update` berhasil merubah status ruangan dari "available" menjadi "occupied". *Return value* dari method ini adalah jumlah baris yang berhasil diubah.
* **Langkah 7 (Delete):**
    * **Hasil:** [Sertakan Screenshot browser hasil eksekusi dan isi tabel `rooms`]
    * **Pengamatan:** Fungsi `DB::delete` menghapus data dengan rujukan parameter `where name = ?`.
* **Langkah 10 (Menampilkan View):**
    * **Hasil:** [Sertakan Screenshot halaman website yang menampilkan tabel Rooms]
    * **Pengamatan:** Fungsi `DB::select` mengambil seluruh isi tabel `rooms` menjadi bentuk objek rilisan (array of objects), kemudian dilempar melalui *Controller* ke file *View* `rooms.blade.php` dan di-loop menggunakan `@foreach`.

---

## E. Query Builder

### Praktikum 5 - Implementasi Query Builder
* **Langkah 4 (Insert):**
    * **Hasil:** [Sertakan Screenshot tabel `class_groups` pgAdmin]
    * **Pengamatan:** Berbeda dengan DB Facade, *Query Builder* menggunakan pola OOP *chaining* seperti `DB::table('class_groups')->insert($data)`. Hal ini membuat kode jauh lebih bersih tanpa harus menuliskan *raw query* SQL secara manual.
* **Langkah 6 (Update):**
    * **Hasil:** [Sertakan Screenshot tabel `class_groups` pgAdmin]
    * **Pengamatan:** Pengubahan data dilakukan dengan `->where()->update()`. Proses ini sangat rapi karena kita hanya perlu memasukkan array *key-value* data yang mau diperbarui.
* **Langkah 7 (Delete):**
    * **Hasil:** [Sertakan Screenshot browser saat penghapusan berhasil]
    * **Pengamatan:** Penggunaan method `->where('name', '1A')->delete()` secara otomatis akan mem-build query *delete* SQL dan mengeksekusinya di database dengan aman.
* **Langkah 10 (Menampilkan View):**
    * **Hasil:** [Sertakan Screenshot halaman Data Class Groups di browser]
    * **Pengamatan:** Fungsi `DB::table('class_groups')->get()` memanggil seluruh baris di tabel `class_groups`. Sintaks ini independen dari jenis *driver* database yang digunakan.

---

## F. Eloquent ORM

### Praktikum 6 - Implementasi Eloquent ORM
* **Langkah 7 (Menampilkan View awal):**
    * **Hasil:** [Sertakan Screenshot halaman browser Data Users]
    * **Pengamatan:** Model `User` berhasil disiapkan. Properti `$fillable` disetel untuk mass assignment. Pengambilan data hanya dengan memanggil `User::all()`.
* **Langkah 9 (Insert Eloquent):**
    * **Hasil:** [Sertakan Screenshot browser Data Users dengan user baru]
    * **Pengamatan:** Memasukkan data dengan Eloquent ORM terasa sangat rapi. Variabel dikumpulkan dalam array dan di-*insert* ke dalam model menggunakan `User::insert($data)`. Laravel otomatis melakukan *mapping* ke struktur tabelnya.
* **Langkah 11 (Update Eloquent):**
    * **Hasil:** [Sertakan Screenshot browser Data Users yang sudah di-update]
    * **Pengamatan:** Pengubahan nama pengguna dari "Student" menjadi "Student Updated" berhasil dieksekusi menggunakan `User::where()->update()`. Setiap record diperlakukan layaknya objek, membuat proses CRUD jauh lebih terstruktur dibandingkan query mentah.

---

## G. Penutup

**1. Pada Praktikum 1 - Tahap 5, apakah fungsi dari `APP_KEY` pada file setting `.env` Laravel?**
**Jawab:** `APP_KEY` adalah kunci enkripsi rahasia yang digunakan oleh Laravel untuk mengamankan *sessions*, *cookies*, data yang di-hash, dan informasi sensitif lainnya di dalam aplikasi. Jika kunci ini diubah, semua session dan *password hash* yang sudah ada berpotensi tidak bisa lagi dikenali.

**2. Pada Praktikum 1, bagaimana kita men-generate nilai untuk `APP_KEY`?**
**Jawab:** Dengan menjalankan perintah terminal: `php artisan key:generate`.

**3. Pada Praktikum 2.1 - Tahap 1, secara default Laravel memiliki berapa file migrasi? dan untuk apa saja file migrasi tersebut?**
**Jawab:** Secara default Laravel menyertakan 4 buah file migrasi:
* `create_users_table`: Untuk tabel *users* default sistem autentikasi Laravel.
* `create_password_reset_tokens_table`: Untuk menyimpan token *reset password* pengguna.
* `create_failed_jobs_table`: Untuk menyimpan daftar tugas-tugas antrean (queue jobs) yang gagal dieksekusi.
* `create_personal_access_tokens_table`: Untuk manajemen otentikasi API/token akses pengguna.

**4. Secara default, file migrasi terdapat kode `$table->timestamps();`, apa tujuan/output dari fungsi tersebut?**
**Jawab:** Tujuan fungsi tersebut adalah secara otomatis men-generate/menciptakan dua buah kolom di database, yaitu `created_at` dan `updated_at` dengan tipe data *timestamp*. Laravel akan mengisi kolom ini secara otomatis ketika ada *record* yang ditambah atau diperbarui.

**7. Pada migration, Fungsi `->unique()` digunakan untuk apa?**
**Jawab:** Digunakan untuk menambahkan sebuah *constraint* unik (unique constraint) pada sebuah kolom. Ini memastikan bahwa tidak boleh ada dua baris data (*record*) yang memiliki nilai yang persis sama pada kolom tersebut (mencegah duplikasi nilai).

**6. Apa bedanya hasil migrasi pada table `m_level`, antara menggunakan `$table->id();` dengan menggunakan `$table->id('level_id');`?**
**Jawab:** * `$table->id();` akan membuat *Primary Key* dengan nama kolom default yaitu **`id`**.
* `$table->id('level_id');` akan membuat *Primary Key* dengan nama kolom kustom yaitu **`level_id`**.

**6. Pada migration, Fungsi `->smallIncrements('id')` digunakan untuk apa?**
**Jawab:** Digunakan untuk membuat primary key dengan tipe SMALLINT UNSIGNED AUTO_INCREMENT. Berbeda dengan `id()` yang menggunakan BIGINT, `smallIncrements` lebih efisien untuk tabel dengan ID kecil seperti tabel rooms.

**8. Pada Praktikum 2.2 Tahap 2, kenapa kolom `room_id` pada tabel `schedules` menggunakan `$table->unsignedSmallInteger('room_id')`, sedangkan kolom `id` pada tabel `rooms` menggunakan `$table->smallIncrements('id')`?**
**Jawab:** Karena `id` pada tabel `rooms` adalah *Primary Key* (menggunakan tipe SMALLINT UNSIGNED Auto Increment dari fungsi `smallIncrements()`). Sedangkan `room_id` pada tabel `schedules` berfungsi sebagai *Foreign Key*. Syarat utama untuk merelasikan *Foreign Key* adalah tipe data dan atribut parameternya harus sama persis dengan tabel asalnya. Oleh karena itu, *Foreign Key* harus berupa *integer* tak bernilai negatif (`unsignedSmallInteger`).

**9. Pada Praktikum 3 - Tahap 6, apa tujuan dari Class Hash? dan apa maksud dari kode program `Hash::make('1234');`?**
**Jawab:** Class `Hash` pada Laravel bertujuan untuk mengamankan data sensitif (khususnya *password*) melalui proses enkripsi (hashing) searah. Kode `Hash::make('1234')` berarti melakukan *hashing* pada *string* '1234' menggunakan algoritma hashing default Laravel (biasanya Bcrypt atau Argon2), sehingga teks asli tidak bisa dilihat atau di-_decode_ di database secara langsung.

**10. Pada Praktikum 4 - Tahap 3/5/7, pada query builder terdapat tanda tanya (?), apa kegunaan dari tanda tanya (?) tersebut?**
**Jawab:** Tanda tanya (`?`) pada DB Facade (*raw query*) adalah bentuk *Parameter Binding*. Fitur ini memisahkan struktur query SQL dan nilai data *input*, sehingga melindungi aplikasi dari ancaman keamanan serangan *SQL Injection*.

**11. Pada Praktikum 6 Tahap 3, apa tujuan penulisan kode `protected $fillable = ['name', 'email', 'reg_number', 'role', 'class_group_id', 'password'];`?**
**Jawab:** `$fillable` digunakan untuk menentukan atribut mana saja yang boleh diisi secara mass assignment. Ini penting untuk keamanan, mencegah pengisian atribut yang tidak diinginkan seperti `id` atau `created_at`.

**12. Menurut kalian, lebih mudah menggunakan mana dalam melakukan operasi CRUD ke database (DB Façade / Query Builder / Eloquent ORM)? jelaskan.**
**Jawab:** *Jawaban dapat disesuaikan dengan opini pribadimu. Berikut contoh argumen yang paling umum:*
Menurut saya, yang paling mudah dan efisien adalah **Eloquent ORM**. Hal ini dikarenakan pendekatannya yang berorientasi objek (OOP). Kita tidak perlu pusing menuliskan sintaks SQL secara manual. Kode program juga menjadi lebih rapi, terstruktur, intuitif, dan *maintainable*. Eloquent mempermudah dalam pengelolaan struktur relasi data antar tabel dibandingkan harus menulis query *JOIN* panjang dengan *Query Builder* atau *DB Facade*.