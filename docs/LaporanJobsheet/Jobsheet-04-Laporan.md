# Laporan Praktikum Jobsheet 04: Eloquent ORM

**Mata Kuliah:** Pemrograman Web Lanjut (PWL)
**Nama:** [Masukkan Nama Anda]
**NIM:** [Masukkan NIM Anda]
**Kelas:** [Masukkan Kelas Anda]

---

## Praktikum 1: Setup Model & Controller

**Langkah-langkah & Pengamatan:**
* **Kode `User.php` dan `UserController.php`:**
    ```php
    // app/Models/User.php
    class User extends Authenticatable {
        protected $fillable = ['name', 'email', 'reg_number', 'role', 'class_group_id', 'password'];
        // [Tambahkan relasi jika ada di instruksi awal]
    }

    // app/Http/Controllers/UserController.php
    public function index() {
        $user = User::all();
        return view('user', ['data' => $user]);
    }
    ```
* **Hasil/Screenshot:**
    [Sertakan Screenshot browser halaman Data User dari Praktikum 1 di sini]
* **Pengamatan:**
    Pada tahap awal ini, kita memastikan `User` model sudah menggunakan properti `$fillable` untuk mass assignment. Controller mengambil semua data (`User::all()`) dan melemparnya ke file view `user.blade.php` untuk ditampilkan.

---

## Praktikum 2: Eloquent Basic CRUD

### 2.1 Menambah & Mengubah Data (Mass Assignment)
* **Kode Tambah/Update Data (`UserController.php`):**
    ```php
    // Penambahan $fillable pada User.php
    protected $fillable = ['name', 'email', 'reg_number', 'role', 'class_group_id', 'password'];

    // Method index pada UserController.php (Create)
    $data = [
        'name' => 'Student Baru',
        'email' => 'student@example.com',
        'reg_number' => '12345678',
        'role' => 'student',
        'class_group_id' => 1,
        'password' => Hash::make('12345')
    ];
    User::create($data);
    ```
* **Hasil/Screenshot:**
    [Sertakan Screenshot hasil penambahan/perubahan data di browser atau phpMyAdmin]
* **Pengamatan:**
    Fungsi `User::create()` akan gagal jika properti `$fillable` pada Model belum didefinisikan. `$fillable` berfungsi sebagai *whitelist* untuk mengizinkan kolom mana saja yang boleh diisi secara massal (*Mass Assignment*). 

### 2.2 Retrieving Single Models (`find`, `first`, `firstWhere`)
* **Kode & Hasil:**
    ```php
    $user = User::find(1); // Mencari user dengan ID 1
    // Atau
    $user = User::firstWhere('role', 'student');
    ```
    [Sertakan Screenshot hasil output `dd($user)` atau view di sini]
* **Pengamatan:**
    `find($id)` akan mencari *record* berdasarkan primary key, sedangkan `firstWhere()` akan mencari *record* pertama yang memenuhi kondisi *where* yang diberikan.

### 2.3 Not Found Exceptions (`findOrFail`, `firstOrFail`)
* **Kode & Hasil:**
    ```php
    $user = User::findOrFail(20); // Contoh mencari ID yang tidak ada
    ```
    [Sertakan Screenshot halaman Error 404 Not Found di sini]
* **Pengamatan:**
    Ketika menggunakan `findOrFail()` atau `firstOrFail()`, jika data tidak ditemukan di database, Laravel secara otomatis akan melemparkan `ModelNotFoundException` yang biasanya di-render sebagai halaman HTTP 404 (Not Found), sehingga mencegah aplikasi *crash*.

### 2.4 Retrieving Aggregates (`count`, `max`, `min`, `avg`)
* **Kode & Hasil:**
    ```php
    $jumlahPengguna = User::where('role', 'student')->count();
    ```
    [Sertakan Screenshot hasil aggregate di sini]
* **Pengamatan:**
    Fungsi agregat dari query builder dapat dipanggil langsung dari Eloquent. `count()` mengembalikan nilai *integer* berupa jumlah baris yang cocok dengan kriteria.

### 2.5 Retreiving or Creating Models (`firstOrCreate`, `firstOrNew`)
* **Kode & Hasil:**
    ```php
    $user = User::firstOrCreate(
        ['reg_number' => '87654321'],
        ['name' => 'Student Baru', 'email' => 'baru@example.com', 'role' => 'student', 'password' => Hash::make('12345')]
    );
    ```
    [Sertakan Screenshot hasil firstOrCreate / firstOrNew di sini]
* **Pengamatan:**
    `firstOrCreate` akan mencari data berdasarkan array parameter pertama. Jika tidak ada, ia akan memasukkan data gabungan array pertama dan kedua ke database. `firstOrNew` memiliki logika yang sama, namun ia **tidak langsung menyimpannya ke database** (hanya membuat *instance* objek di memori) sampai kita memanggil method `$user->save()`.

### 2.6 Attribute Changes (`isDirty`, `isClean`, `wasChanged`)
* **Kode & Hasil:**
    ```php
    $user = User::create([...]);
    $user->name = 'Nama Berubah';
    $user->isDirty(); // true
    $user->isClean(); // false
    $user->save();
    $user->wasChanged(); // true
    ```
    [Sertakan Screenshot hasil *dump* atau teks pengamatan dari atribut changes di sini]
* **Pengamatan:**
    Fungsi `isDirty()` mengecek apakah ada atribut yang diubah namun belum di-`save()` ke database. `isClean()` adalah kebalikannya. `wasChanged()` mengecek apakah ada atribut yang telah berhasil diubah *setelah* operasi `save()` terakhir pada siklus *request* tersebut.

---

## Praktikum 2.6: Create, Read, Update, Delete (CRUD) Interface

**Langkah-langkah Implementasi CRUD:**
* **Routing (`web.php`):**
    ```php
    Route::get('/user/tambah', [UserController::class, 'tambah']);
    Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
    Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
    Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
    Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);
    ```
* **Hasil Tampil Data (Read):**
    [Sertakan Screenshot halaman Tabel User]
* **Hasil Tambah Data (Create):**
    [Sertakan Screenshot Form Tambah dan hasil setelah penambahan]
* **Hasil Ubah Data (Update):**
    [Sertakan Screenshot Form Ubah dan hasil setelah diubah]
* **Hasil Hapus Data (Delete):**
    [Sertakan Screenshot Tabel User setelah satu data dihapus]

---

## Praktikum 2.7: Relationships

**Langkah-langkah:**
* **Kode Relasi di `User.php`:**
    ```php
    public function classGroup() {
        return $this->belongsTo(ClassGroup::class, 'class_group_id', 'id');
    }
    ```
* **Modifikasi di `user.blade.php`:**
    ```html
    <td>{{ $d->classGroup->name }}</td>
    <td>{{ $d->classGroup->major }}</td>
    ```
* **Hasil/Screenshot:**
    [Sertakan Screenshot halaman Tabel User yang sudah menampilkan Nama Level, bukan lagi ID Level]
* **Pengamatan:**
    Dengan mendefinisikan `belongsTo` pada `User`, kita memberitahu Eloquent bahwa tabel `users` terhubung ke `class_groups` (Relasi *Many-to-One*). Hal ini memungkinkan kita memanggil atribut relasi langsung di *view* (contoh: `$d->classGroup->name`) tanpa perlu melakukan query *JOIN* secara manual di Controller.

---

## G. Penutup

**1. Apa perbedaan antara properti `$fillable` dan `$guarded` dalam model Eloquent?**
**Jawab:** `$fillable` bertindak sebagai *whitelist* yang mendaftar kolom mana saja yang diizinkan untuk diisi massal (*mass assignment*). Sebaliknya, `$guarded` bertindak sebagai *blacklist* yang mendaftar kolom mana saja yang *tidak* boleh diisi massal (kolom selain di `$guarded` boleh diisi). Keduanya tidak boleh digunakan secara bersamaan pada satu Model.

**2. Apa fungsi dari method `find()` dan bagaimana jika kita memberikan parameter yang berbeda?**
**Jawab:** `find($id)` berfungsi untuk mencari dan mengambil satu buah *record* dari database berdasarkan *Primary Key*. Jika diberi argumen `1` (`find(1)`), ia akan mencari baris dengan ID 1. Jika diberi *array* (`find([1, 2, 3])`), ia akan mengembalikan *Collection* berisi *record* dengan ID 1, 2, dan 3. Jika data tidak ada, ia mereturn `null`.

**3. Jelaskan kegunaan dari method `firstWhere()`!**
**Jawab:** Berfungsi untuk mencari *record* pertama yang memenuhi kriteria *where* tertentu. Format singkat ini setara dengan melakukan `where('kolom', 'nilai')->first()`.

**4. Kapan sebaiknya kita menggunakan method `findOrFail()` daripada `find()`?**
**Jawab:** Kita menggunakan `findOrFail()` ketika kita *sangat mengharapkan* bahwa data tersebut harus ada (misal: mengambil detail profil berdasarkan ID dari URL). Jika datanya tidak ada, `findOrFail()` otomatis membuang `ModelNotFoundException` (merender 404 Not Found), sehingga kita tidak perlu menulis pengkondisian `if (!$user)` secara manual untuk menangani error.

**5. Apa kegunaan dari method `count()` pada Eloquent?**
**Jawab:** Digunakan untuk menghitung total jumlah baris (*records*) pada sebuah tabel atau hasil dari spesifik *query conditions* (contoh: `UserModel::where('level_id', 1)->count()`).

**6. Jelaskan perbedaan antara method `firstOrCreate()` dan `firstOrNew()`!**
**Jawab:** * `firstOrCreate()`: Mencari data. Jika tidak ketemu, objek baru dibuat dan **langsung disimpan (di-insert)** ke dalam database.
* `firstOrNew()`: Mencari data. Jika tidak ketemu, hanya membuat *instance* / objek baru di dalam memori PHP, **belum tersimpan di database** sampai kita secara manual mengeksekusi method `->save()`.

**7. Kapan method `isDirty()` akan mengembalikan nilai `true`?**
**Jawab:** `isDirty()` akan bernilai `true` jika suatu *instance* Model telah diubah nilai atribut/kolomnya di dalam memori PHP, tetapi perubahan tersebut *belum* disimpan (di-`save()`) ke database.

**8. Apa bedanya method `wasChanged()` dengan `isDirty()`?**
**Jawab:** * `isDirty()` memeriksa keadaan *sebelum* data di-`save()` (apakah ada perubahan yang siap disimpan).
* `wasChanged()` memeriksa keadaan *setelah* data di-`save()` (apakah pada siklus *request* terakhir, operasi `save()` benar-benar merubah data di database).

**9. Jelaskan proses alur kerja Routing untuk menampilkan form Tambah Data (`/user/tambah`)!**
**Jawab:** Ketika user mengakses URL `/user/tambah` dengan *method* HTTP GET, *Route* di `web.php` akan menangkap URL tersebut dan mengarahkannya ke `UserController` pada method `tambah()`. Method `tambah()` kemudian mengembalikan/me-return sebuah *View* (`user_tambah.blade.php`) yang berisi kode HTML *form input*.

**10. Pada method `tambah_simpan`, fungsi apa yang digunakan untuk menyimpan data inputan form ke database?**
**Jawab:** Fungsi `User::create()` yang memanfaatkan konsep *Mass Assignment*. Data yang dikirimkan dari form (diakses melalui parameter `$request`) dikemas ke dalam sebuah *array* asosiatif untuk kemudian di-insert oleh fungsi `create()`.

**11. Jelaskan proses alur kerja Routing untuk menampilkan form Ubah Data (`/user/ubah/{id}`)!**
**Jawab:** User menekan tombol "Ubah" yang mengarah ke URL seperti `/user/ubah/1`. *Route* `Route::get('/user/ubah/{id}')` akan menangkap angka `1` sebagai parameter `$id` dan mengirimnya ke method `ubah($id)` pada Controller. Di Controller, data ditarik memakai `UserModel::find($id)` lalu dilempar ke *View* form ubah agar *field form* terisi (ter-*populate*) dengan data lama.

**12. Pada method `ubah_simpan`, jelaskan bagaimana Eloquent merubah data di database!**
**Jawab:** Eloquent terlebih dahulu mencari *record* berdasarkan ID menggunakan `User::find($id)`. Atribut dari model tersebut kemudian ditimpa (*overwrite*) dengan data baru dari form (seperti `$user->name = $request->name`). Setelah semua field ditimpa, method `$user->save()` dipanggil untuk menembakkan query `UPDATE` ke database. Alternatif lainnya adalah melempar array input langsung ke method `->update()`.

**13. Apa fungsi menambahkan method `with('classGroup')` pada saat melakukan pemanggilan data `User::with('classGroup')->get()`?**
**Jawab:** Fitur ini disebut ***Eager Loading***. Tujuannya adalah untuk menarik data tabel `users` sekaligus langsung menarik data tabel `class_groups` terkait dalam satu (atau dua) *query* di awal. Jika tidak menggunakan `with` (yang disebut *Lazy Loading*), Laravel akan mengeksekusi query database baru secara terus-menerus *setiap kali* kita memanggil `$user->classGroup` di *looping* View, yang dapat menyebabkan masalah performa berat yang dikenal sebagai *N+1 Query Problem*.