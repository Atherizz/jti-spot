# Laporan Praktikum Jobsheet 02: Routing, Controller, dan View

## Praktikum 1: Routing

### Basic Routing
**Langkah 3: Pemanggilan route `/login`**
* **Kode `web.php`:**
    ```php
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AuthController;

    Route::get('/login', [AuthController::class, 'showLogin'])->middleware('guest')->name('login');
    ```
* **Hasil/Screenshot:**
    [Sertakan Screenshot browser di sini]
* **Pengamatan:**
    Halaman web menampilkan halaman login di browser. Route ini menggunakan controller AuthController dengan method showLogin, dan dilengkapi dengan middleware 'guest' untuk memastikan hanya user yang belum login yang bisa mengakses.

**Langkah 5: Pemanggilan route `/student/dashboard`**
* **Kode `web.php`:**
    ```php
    Route::get('/student/dashboard', function () {
        return view('student.dashboard.home');
    })->name('student.dashboard.home');
    ```
* **Hasil/Screenshot:**
    [Sertakan Screenshot browser di sini]
* **Pengamatan:**
    Halaman web menampilkan dashboard student. Route ini menggunakan closure untuk mengembalikan view 'student.dashboard.home' dan diberi nama route 'student.dashboard.home'.

**Langkah 6 & 7: Pembuatan route `/` dan `/admin/dashboard`**
* **Kode `web.php`:**
    ```php
    Route::get('/', function () {
        return view('guest');
    });

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard.home');
    })->name('admin.dashboard.home');
    ```
* **Hasil/Screenshot:**
    [Sertakan Screenshot browser di sini]

### Route Parameters
**Langkah 9: Route `/scan/{qr_token}` dengan parameter**
* **Kode `web.php`:**
    ```php
    use App\Http\Controllers\RoomActionController;

    Route::get('/scan/{qr_token}', [RoomActionController::class, 'scanInitial'])
         ->name('scan.initial');
    ```
* **Hasil/Screenshot:**
    [Sertakan Screenshot browser di sini]
* **Pengamatan:**
    Saat mengakses URL `/scan/abc123`, halaman menampilkan halaman scan untuk ruangan dengan QR token abc123. Route ini menggunakan controller RoomActionController dengan method scanInitial.

**Langkah 10: Route `/user/` tanpa parameter**
* **Hasil/Screenshot:**
    [Sertakan Screenshot Error 404 di sini]
* **Pengamatan:**
    Terjadi *error* (umumnya 404 Not Found)[cite: 177]. Hal ini terjadi karena pada file routing, parameter `{name}` disetel sebagai parameter wajib. Karena tidak ada nilai parameter yang diberikan pada URL, URL tidak cocok dengan definisi route mana pun[cite: 159, 172].

**Langkah 12: Route dengan lebih dari 1 parameter**
* **Kode `web.php`:**
    ```php
    Route::get('/posts/{post}/comments/{comment}', function ($postId, $commentId) {
        return 'Pos ke-'.$postId." Komentar ke-: ".$commentId;
    });
    ```
* **Hasil/Screenshot:**
    [Sertakan Screenshot browser di sini]
* **Pengamatan:**
    Halaman menampilkan "Pos ke-1 Komentar ke-: 5"[cite: 182, 183]. Ini membuktikan bahwa sebuah route di Laravel dapat menerima lebih dari satu parameter secara berurutan dan mengopernya ke dalam argumen pada *callback function*[cite: 178].

**Langkah 13: Route `/articles/{id}`**
* **Kode `web.php`:**
    ```php
    Route::get('/articles/{id}', function ($id) {
        return "Halaman Artikel dengan ID {$id}";
    });
    ```
* **Hasil/Screenshot:**
    [Sertakan Screenshot browser di sini]

### Optional Parameters
**Langkah 15 & 16: Route optional parameter**
* **Kode `web.php`:**
    ```php
    Route::get('/user/{name?}', function ($name=null) {
        return 'Nama saya '.$name;
    });
    ```
* **Hasil/Screenshot:**
    [Sertakan Screenshot browser di sini]
* **Pengamatan:**
    Penambahan tanda tanya (`?`) pada `{name?}` membuat parameter ini bersifat opsional[cite: 187]. Saat mengakses `/user/` tanpa parameter, tidak terjadi error seperti sebelumnya; halaman hanya menampilkan "Nama saya " (kosong setelahnya) karena *default value* argumen `$name` disetel ke `null`[cite: 191, 201]. Jika diisi `/user/Budi`, akan muncul "Nama saya Budi"[cite: 201, 203].

**Langkah 18: Route optional parameter dengan default value**
* **Kode `web.php`:**
    ```php
    Route::get('/user/{name?}', function ($name='John') {
        return 'Nama saya '.$name;
    });
    ```
* **Hasil/Screenshot:**
    [Sertakan Screenshot browser di sini]
* **Pengamatan:**
    Ketika URL diakses tanpa memberikan parameter nama (yakni `/user/`), halaman web menampilkan "Nama saya John"[cite: 205, 209]. Jika parameter kosong, variabel `$name` akan otomatis menggunakan nilai *default* yang telah ditetapkan di *function*, yaitu 'John'[cite: 187, 205].

---

## Praktikum 2: Controller

### Membuat Controller
**Langkah 5: Route `/login` menggunakan `AuthController`**
* **Kode `AuthController.php` & `web.php`:**
    ```php
    // app/Http/Controllers/AuthController.php
    public function showLogin() {
        return view('auth.login');
    }

    // routes/web.php
    Route::get('/login', [AuthController::class, 'showLogin'])->middleware('guest')->name('login');
    ```
* **Hasil/Screenshot:**
    [Sertakan Screenshot browser di sini]
* **Pengamatan:**
    Halaman web tetap menampilkan halaman login seperti sebelumnya, namun logika pemrosesan kini rapi. Request dari route `/login` sekarang diarahkan ke method `showLogin` di dalam `AuthController`.

**Langkah 6: Modifikasi menggunakan `RoomActionController`**
* **Kode `RoomActionController.php`:**
    ```php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Models\Room;

    class RoomActionController extends Controller
    {
        public function scanInitial($qrToken) {
            $room = Room::where('qr_token', $qrToken)->first();
            
            if (!$room) {
                return redirect()->route('student.dashboard.home')
                    ->with('error', 'QR Code tidak valid atau ruangan tidak ditemukan');
            }

            return view('student.scan.initial', compact('room', 'qrToken'));
        }
    }
    ```
* **Kode `web.php`:**
    ```php
    use App\Http\Controllers\RoomActionController;

    Route::get('/scan/{qr_token}', [RoomActionController::class, 'scanInitial']);
    ```
* **Hasil/Screenshot:**
    [Sertakan Screenshot ketiga halaman browser di sini]

**Langkah 7: Modifikasi menggunakan Single Action Controller**
* **Kode Controllers:**
    *(Catatan: Controller single action umumnya menggunakan method ajaib `__invoke()`)*
    ```php
    // app/Http/Controllers/HomeController.php
    public function __invoke() {
        return 'Selamat Datang';
    }

    // app/Http/Controllers/AboutController.php
    public function __invoke() {
        return 'Nama: [Nama Anda], NIM: [NIM Anda]';
    }

    // app/Http/Controllers/ArticleController.php
    public function __invoke($id) {
        return 'Halaman Artikel dengan Id ' . $id;
    }
    ```
* **Kode `web.php`:**
    ```php
    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\AboutController;
    use App\Http\Controllers\ArticleController;

    Route::get('/', HomeController::class);
    Route::get('/about', AboutController::class);
    Route::get('/articles/{id}', ArticleController::class);
    ```
* **Hasil/Screenshot:**
    [Sertakan Screenshot browser di sini]

### Resource Controller
**Langkah 10: Hasil `route:list` untuk `PhotoController`**
* **Hasil/Screenshot Terminal:**
    [Sertakan Screenshot php artisan route:list di sini]

**Langkah 11: Modifikasi fungsi `only` dan `except` pada route resource**
* **Kode `web.php`:**
    ```php
    use App\Http\Controllers\PhotoController;

    // Menampilkan route index dan show saja
    Route::resource('photos', PhotoController::class)->only([
        'index', 'show'
    ]);

    // Menampilkan semua route KECUALI create, store, update, destroy
    Route::resource('photos', PhotoController::class)->except([
        'create', 'store', 'update', 'destroy'
    ]);
    ```

---

## Praktikum 3: View

### Membuat View
**Langkah 3: Menjalankan route `/login` yang memanggil view `auth.login.blade.php`**
* **Kode `auth.login.blade.php` & `web.php`:**
    ```html
    <!-- resources/views/auth/login.blade.php -->
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <title>JTISpot - Masuk</title>
        <!-- CSS and JS includes -->
    </head>
    <body>
        <div class="login-container">
            <h1>JTISpot Login</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="text" name="reg_number" placeholder="Nomor Registrasi" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Masuk</button>
            </form>
        </div>
    </body>
    </html>
    ```
    ```php
    // routes/web.php
    Route::get('/login', [AuthController::class, 'showLogin'])->middleware('guest')->name('login');
    ```
* **Hasil/Screenshot:**
    [Sertakan Screenshot browser di sini]
* **Pengamatan:**
    Halaman akan menampilkan form login untuk JTISpot. Route `/login` mereturn view 'auth.login' yang berisi form untuk nomor registrasi dan password.

### View dalam direktori
**Langkah 7: Menjalankan route `/student/dashboard` yang memanggil `student.dashboard.home`**
* **Kode `web.php`:**
    ```php
    Route::get('/student/dashboard', function () {
        return view('student.dashboard.home');
    })->name('student.dashboard.home');
    ```
* **Hasil/Screenshot:**
    [Sertakan Screenshot browser di sini]
* **Pengamatan:**
    Tampilan dashboard student. Struktur filenya menggunakan sub-direktori 'student/dashboard', diakses dengan dot notation 'student.dashboard.home'.

### Menampilkan View dari Controller
**Langkah 10: Pemanggilan View melalui `AuthController`**
* **Kode `AuthController.php` & `web.php`:**
    ```php
    // app/Http/Controllers/AuthController.php
    public function showLogin() {
        return view('auth.login');
    }

    // routes/web.php
    Route::get('/login', [AuthController::class, 'showLogin'])->middleware('guest')->name('login');
    ```
* **Hasil/Screenshot:**
    [Sertakan Screenshot browser di sini]
* **Pengamatan:**
    Halaman web tetap menampilkan form login, namun pola MVC diterapkan. Request ditangkap oleh route, lalu ke method showLogin di AuthController yang mengembalikan view.

### Meneruskan data ke view
**Langkah 13: Menampilkan view dengan parameter `room` dan `qrToken`**
* **Kode `RoomActionController.php` & `student.scan.initial.blade.php`:**
    ```php
    // app/Http/Controllers/RoomActionController.php
    public function scanInitial($qrToken) {
        $room = Room::where('qr_token', $qrToken)->first();
        return view('student.scan.initial')
            ->with('room', $room)
            ->with('qrToken', $qrToken);
    }
    ```
    ```html
    <!-- resources/views/student/scan/initial.blade.php -->
    <html>
        <body>
            <h1>Scan Ruangan: {{ $room->name }}</h1>
            <p>QR Token: {{ $qrToken }}</p>
        </body>
    </html>
    ```
* **Hasil/Screenshot:**
    [Sertakan Screenshot browser di sini]
* **Pengamatan:**
    Browser akan menampilkan nama ruangan dan QR token. Data dilempar menggunakan method `with()` untuk mengirim parameter room dan qrToken ke view.

---

