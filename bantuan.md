# Jawaban Presentasi Backend Web & Dosen Tanya Jawab

Dokumen ini disusun khusus berdasarkan kode proyek Laravel (Livewire) Anda. Bagian pertama berisi **Top 6 Penjelasan Mendalam**, dan bagian kedua berisi **Bank 75 Pertanyaan Dosen & Kunci Jawaban** untuk persiapan mental yang maksimal.

---

## BAGIAN I: 6 TOPIK UTAMA (PENJELASAN MENDALAM)

### 1. Alur Aplikasi (MVC) & Modifikasi Livewire
**Tanya:** *Bagaimana request mengalir dari Route -> Controller -> Model -> View?*
**Jawab:** "Karena saya pakai Livewire, MVC termodifikasi. *Request* masuk dari Route ke Komponen Livewire. Livewire lalu memanggil Model, memproses data, dan me-render View pertama. Saat user klik tombol, Livewire TIDAK me-reload halaman, melainkan mengirim request **AJAX** ke backend. Backend mengupdate *state* (variabel), dan merender ulang sebagian kecil HTML (*Partial DOM Update*). Proses bolak-balik JSON-HTML ini disebut *Hydration* & *Dehydration*."

### 2. Routing & Middleware
**Tanya:** *Jelaskan route grouping dan middleware.*
**Jawab:** "Saya memakai `Route::middleware('auth')->group(...)` untuk efisiensi agar tidak menulis fungsi proteksi berulang kali. Middleware beraksi sebagai pos penjaga *sebelum* request sampai ke Controller. Contoh di `PremiumMiddleware`, jika role bukan premium, middleware langsung memblokir dan melakukan `redirect` ke halaman upgrade. Saya juga pakai *Route Model Binding* (`/product/{slug}`) agar Laravel otomatis melakukan query database pencarian produk tanpa sintaks `where` manual."

### 3. Relasi `belongsTo` vs SQL JOIN
**Tanya:** *Kenapa menggunakan `belongsTo`?*
**Jawab:** "Untuk relasi Inverse One-to-Many. Contoh: OrderItem `belongsTo` Order. Alasan saya tidak pakai SQL JOIN biasa:
1. Kode lebih elegan bergaya OOP (`$orderItem->order->status`).
2. Mencegah **N+1 Query Problem** menggunakan *Eager Loading* (`->with('order')`). Laravel hanya mengeksekusi 2 query untuk merelasikan ratusan data, bukan mengeksekusi ratusan query berulang kali.
3. Otomatisasi pembacaan *foreign key* `order_id`."

### 4. Logika Perhitungan (Matematika Transaksi)
**Tanya:** *Di mana Anda menaruh perhitungan harga/diskon dan kenapa?*
**Jawab:** "Saya menaruhnya di Livewire Component (pengganti Controller). Alurnya: menghitung subtotal (harga * jumlah), menghitung ongkir dinamis dari kota, lalu dipotong diskon kupon.
*Kenapa tidak di View/Blade?* Karena Blade hanya untuk templating. Menaruh logika di Blade melanggar prinsip *Separation of Concerns* dan mustahil merespons hitungan secara real-time tanpa refresh. 
Ke depannya, logika berat ini bisa dipindah ke **Service Layer** (misal `CheckoutService`) agar komponen Livewire murni mengurus antarmuka saja."

### 5. Sistem Notifikasi Event Dispatcher (`toast()`)
**Tanya:** *Bagaimana notifikasi aplikasi ini bekerja?*
**Jawab:** "Aplikasi ini pakai notifikasi Asinkronus *Event-Driven*. Saat aksi sukses, Livewire mengeksekusi fungsi backend `$this->dispatch('notify')`. Instruksi ini mengalir lewat WebSocket/AJAX ke browser, di mana JavaScript *listener* menangkap event tersebut dan memunculkan *toast* popup. Keuntungannya: menghemat *bandwith*, mempercepat respons, dan tidak ada formulir/state yang hilang karena tidak ada *page refresh*."

---

## BAGIAN II: BANK 75 PERTANYAAN DOSEN & KUNCI JAWABAN

Berikut adalah 75 pertanyaan komprehensif yang mencakup arsitektur dasar hingga fitur spesifik di proyek Sigmaven VPS Anda.

### A. Arsitektur & Livewire (1-10)
1. **Apa beda MVC Laravel tradisional dengan implementasimu pakai Livewire?** (Jawab: MVC tradisional butuh *page reload* untuk setiap aksi. Livewire menahan *state* di server dan mengupdate DOM via AJAX).
2. **Apa fungsi method `render()` di Livewire?** (Jawab: Untuk memanggil file Blade yang akan dirender sebagai output ke browser).
3. **Kapan method `mount()` dipanggil?** (Jawab: Hanya satu kali saat pertama kali komponen diload. Fungsinya mirip `__construct` untuk inisialisasi awal variabel).
4. **Apa itu *Hydration* di Livewire?** (Jawab: Proses mengubah komponen backend dari PHP menjadi JSON untuk dikirim ke frontend).
5. **Kapan tepatnya komponen kamu mengirim request AJAX?** (Jawab: Saat user berinteraksi dengan elemen ber-atribut `wire:click`, `wire:model`, atau saat kita trigger `$dispatch`).
6. **Kenapa tidak bikin file controller terpisah dan murni pakai Blade?** (Jawab: Untuk mendapatkan reaktivitas *real-time* seperti *Single Page Application* tanpa harus setup Vue/React API terpisah).
7. **Bagaimana Livewire menjaga keamanan data public property?** (Jawab: Dengan *Checksum* *Hash* di setiap request untuk memastikan *payload* tidak dimanipulasi user dari Inspect Element).
8. **Apa itu `#[Layout('layouts.app')]`?** (Jawab: Ini adalah sintaks *PHP 8 Attributes* untuk menentukan file pembungkus utama/layout dari komponen tersebut).
9. **Jelaskan siklus (lifecycle) sebuah komponen di Laravel kamu.** (Jawab: `boot` -> `mount` -> `render` -> interaksi AJAX -> `hydrate` -> method action -> `dehydrate` -> partial DOM ter-update).
10. **Bisakah Livewire dipanggil di dalam Blade komponen biasa?** (Jawab: Bisa, dengan sintaks `<livewire:nama-komponen />` untuk menanam (embed) komponen reaktif di layout statis).

### B. Routing & Middleware (11-20)
11. **Apa fungsi `routes/web.php` dan kenapa tidak ditaruh di `api.php`?** (Jawab: `web.php` menggunakan middleware `web` yang mendukung session dan CSRF, cocok untuk browser. Sedangkan `api.php` bersifat *stateless* tanpa session).
12. **Jelaskan secara teknis alur Middleware yang kamu buat.** (Jawab: Request masuk -> router membaca middleware -> `handle($request, Closure $next)` dijalankan -> jika lulus `return $next($request)` ke controller, jika tidak `return redirect()`).
13. **Apa itu Route Grouping dan manfaatnya?** (Jawab: Mengelompokkan banyak route. Manfaatnya DRY (*Don't Repeat Yourself*), agar *prefix* atau *middleware* tidak ditulis berulang-ulang).
14. **Apa itu Route Model Binding?** (Jawab: Rute menerima parameter ID/slug, dan Laravel otomatis mengeksekusi `Model::findOrFail()` di belakang layar sebelum masuk controller).
15. **Mengapa URL Checkout memakai `Route::get` bukan `post`?** (Jawab: Karena url `/checkout` bertugas "menampilkan" halaman. Proses mem-posting datanya (menyimpan pesanan) dilakukan oleh fungsi bawaan Livewire tanpa butuh rute POST khusus).
16. **Kapan kita harus memakai nama route (`->name('...')`)?** (Jawab: Agar saat URL rute berubah di web.php, kita tidak perlu memodifikasi ribuan link di Blade, cukup memanggil nama rutenya lewat `route('nama')`).
17. **Apa itu CSRF Token dan perannya?** (Jawab: *Cross-Site Request Forgery*. String unik dari server untuk memvalidasi bahwa request submit form benar-benar berasal dari website kita sendiri, bukan web peretas).
18. **Apakah Livewire juga membutuhkan CSRF token?** (Jawab: Ya, dan sudah ditangani otomatis di header AJAX Livewire asalkan halaman utamanya dirender lewat Laravel web middleware).
19. **Dimana semua Middleware didaftarkan?** (Jawab: Di Laravel 11+, didaftarkan di `bootstrap/app.php` atau sebelumnya di `app/Http/Kernel.php`).
20. **Apa perbedaan antara `auth` dan `guest` middleware?** (Jawab: `auth` menolak user yang belum login. `guest` menolak user yang SUDAH login (misalnya halaman Login/Register tidak boleh diakses jika sudah login)).

### C. Database & Eloquent (21-30)
21. **Apa keuntungan pakai Eloquent dibanding DB::table (Query Builder)?** (Jawab: Eloquent merepresentasikan tabel sebagai Object (OOP), mendukung relasi model, *Accessor/Mutator*, dan *Model Events* otomatis).
22. **Apa beda `belongsTo` dan `hasOne`?** (Jawab: `belongsTo` artinya model tempat fungsi ini ditulis menyimpan *Foreign Key* dari model target. `hasOne` berarti model target yang menyimpan *Foreign Key*).
23. **Beri contoh riil `hasMany` di proyekmu.** (Jawab: Model `Order` `hasMany(OrderItem::class)`. Satu pesanan bisa punya banyak barang keranjang. Foreign key `order_id` ada di tabel `order_items`).
24. **Coba jelaskan detail apa itu N+1 Query Problem!** (Jawab: Saat kita me-looping 100 data Order, lalu mengambil relasi User-nya di dalam loop, akan ada 1 query ambil order, dan 100 query ambil user (1+100 query). Sangat berat).
25. **Bagaimana solusimu menyelesaikan masalah N+1 itu?** (Jawab: Pakai teknik *Eager Loading* dengan fungsi `->with('user')`. Laravel hanya butuh 2 query: satu ambil semua order, satu ambil user di mana `id IN (...)`).
26. **Apa fungsi Migration di Laravel?** (Jawab: Sebagai *version control* atau blueprint dari struktur tabel database. Membuat kita tidak bergantung pada *export/import sql* phpMyAdmin).
27. **Bedanya `->get()` dan `->first()`?** (Jawab: `get()` me-return *Collection* (array of objects), `first()` me-return *satu Object tunggal* atau null).
28. **Kenapa ada array `$fillable` di Model kamu?** (Jawab: Sebagai keamanan *Mass Assignment*. Untuk mencegah user menyuntikkan kolom ilegal (seperti `is_admin=1`) secara diam-diam).
29. **Kapan kamu perlu pakai `DB::beginTransaction()`?** (Jawab: Di fungsi `processCheckout()`. Jika saat insert `Order` sukses tapi insert `OrderItem` gagal/error, maka transaksi di-*rollback* (dibatalkan semua) agar data tidak korup/setengah-setengah).
30. **Apa beda *SoftDeletes* dan hapus biasa?** (Jawab: Hapus biasa pakai perintah `DELETE`. Soft deletes pakai `UPDATE deleted_at`, data masih ada di tabel tapi tidak dibaca oleh aplikasi).

### D. Logika Bisnis & Perhitungan (31-40)
31. **Kenapa kamu tidak langsung menulis kode perhitungan `+ - * /` di file Blade?** (Jawab: Melanggar aturan *Separation of Concerns*. Blade bertugas menampilkan UI. Controller/Livewire mengolah angka).
32. **Jika diskon kupon bernilai Rp50.000, tapi belanjaan cuma Rp40.000, apa yang terjadi?** (Jawab: Di kode, saya pakai `min($discount, $subtotal)`. Jadi sistem akan memotong maksimal sebesar subtotal (40.000), mencegah minus).
33. **Bagaimana kamu memastikan `Grand Total` tidak pernah minus?** (Jawab: Saya tambahkan fungsi logika PHP murni `max(0, $kalkulasi)` pada perhitungan akhir).
34. **Apa itu *Service Pattern/Service Layer*?** (Jawab: Memisahkan logika inti aplikasi ke class tersendiri (`App/Services/CartService.php`) agar bisa dipanggil kembali oleh controller lain atau API tanpa copas kode).
35. **Jelaskan logika penentuan ongkir di aplikasimu.** (Jawab: Saya mencocokkan string nama kota dari alamat dengan array *hardcode* nama kota (`str_contains`). Jika cocok, pakai harga tersebut. Jika tidak, jatuh ke tarif default `15000`).
36. **Kenapa subtotal keranjang dihitung pakai looping bukan pakai SUM database?** (Jawab: Karena saya mengakomodir adanya harga diskon *real-time* di model Product. Looping di collection lebih aman untuk mengambil harga aktif saat ini).
37. **Jika user mengubah harga produk via Inspect Element HTML, apakah harganya akan berubah di backend saat order?** (Jawab: Tidak. Karena harga yang saya masukkan ke database Order bukan dari form HTML, melainkan di-*query* ulang langsung dari `Product::price` di backend).
38. **Boleh tidak Model memuat logika bisnis?** (Jawab: Boleh untuk logika khusus terkait identitas data itu sendiri (*Fat Model, Skinny Controller*), misal *Accessor* diskon produk, tapi perhitungan antarentitas lebih baik di Service).
39. **Kapan menggunakan Helper Function `function.php` dibanding Class?** (Jawab: Helper untuk utility ringan global (misal format Rupiah). Class/Service untuk proses spesifik yang butuh akses *Dependency Injection* atau Database).
40. **Bagaimana cara kerja Dependency Injection di method Controller/Livewire?** (Jawab: Jika method diketik `public function mount(CartService $service)`, Laravel Service Container akan otomatis membuat objek tersebut secara instan tanpa kita harus menulis `new CartService()`).

### E. Keamanan, Security & Lain-lain (41-50)
41. **Bagaimana cara kamu mengamankan sistem ini dari SQL Injection?** (Jawab: Saya sudah pakai Eloquent ORM. Laravel memproses query memakai *PDO Parameterized Queries*, jadi karakter berbahaya dari user otomatis ditangkal).
42. **Bagaimana cara mengamankan serangan XSS di Blade?** (Jawab: Dengan menggunakan sintaks tag kurawal ganda `{{ $variabel }}`. Laravel otomatis memanggil fungsi `htmlspecialchars` PHP untuk memfilter tag `<script>`).
43. **Apakah password user di tabel tersimpan sebagai *plaintext*?** (Jawab: Tidak. Laravel otomatis mengenkripsi password menggunakan algoritma BCRYPT, yang tidak bisa di-decrypt tapi bisa di-verifikasi oleh fungsi `Hash::check()`).
44. **Apa itu fitur `.env`? Kenapa sangat penting?** (Jawab: *Environment Variables*. Tempat menyimpan konfigurasi rahasia spesifik untuk server tersebut (password DB, key API) yang tidak boleh disebar ke Github).
45. **Bagaimana cara kerja autentikasi Session Laravel?** (Jawab: Setelah password benar, Laravel membuat file session rahasia, lalu menitipkan ID session yang dienkripsi ke *cookies* browser user sebagai pass jalan).
46. **Bedanya Cookie dan Session secara backend?** (Jawab: Cookie tersimpan di browser klien dan bisa dimanipulasi (rawan). Session tersimpan secara aman di backend server, klien cuma bawa "kunci gembok"-nya).
47. **Jika aplikasi kamu mendadak diakses 1000 orang, apa bottleneck terbesarnya dari sisi kode?** (Jawab: Koneksi N+1 Database dan request kalkulasi di setiap reload. Bisa dioptimalkan dengan Laravel Caching (`Cache::remember`)).
48. **Apa keuntungan memisahkan komponen `Cart` dan `Checkout`?** (Jawab: *Single Responsibility Principle*. Kode lebih pendek, *bug* mudah dilacak, dan komponen keranjang bisa dipakai di halaman mana saja tanpa ganggu alur Checkout).
49. **Jelaskan apa bedanya *Validation* di Request dengan di Database!** (Jawab: Di backend, request pakai validator `$this->validate()` untuk cegah input masuk, tapi Database juga harus diberi *constraints* (seperti `NOT NULL` atau `UNIQUE`) sebagai pertahanan lapis kedua jika validator lolos).
50. **Dari semua kode backend di aplikasimu, mana yang kamu anggap paling menantang pengerjaannya?** *(Jawab dengan lantang:* "Proses di `Checkout.php`, Pak/Bu! Karena saya harus mengontrol state UI Livewire, menghitung subtotal dinamis, diskon kupon, lalu menjalankan DB Transaction dengan Rollback untuk menyatukan Order dan Order Item tanpa ada cacat di Database!").

### F. Fitur Spesifik (Lelang, Premium & Admin) (51-60)
51. **Bagaimana cara sistem membedakan user biasa dan user Premium?** (Jawab: Melalui pengecekan `PremiumMiddleware` atau mengecek kolom/relasi langganan `UserSubscription` di database sebelum mengizinkan akses ke rute `/sigame`).
52. **Jelaskan logika penentuan pemenang di sistem Lelang (LegacyBid).** (Jawab: Setiap tawaran disimpan di tabel `AuctionBid`. Pemenang ditentukan melalui query `orderBy('bid_amount', 'desc')->first()` saat waktu lelang berakhir).
53. **Bagaimana jika dua user melakukan bid/penawaran di waktu yang sama persis (Concurrency)?** (Jawab: Di backend, proses bid dibungkus dalam *DB Transaction* dengan metode penguncian tabel (*Pessimistic Locking* `lockForUpdate()`) agar bid divalidasi satu per satu).
54. **Bagaimana alur pemberian poin di fitur Sigame (`PointsTransaction`)?** (Jawab: Saat game selesai, frontend men-trigger aksi backend. Backend memvalidasi skor, menambahkan rekaman baru di `PointsTransaction`, lalu menjumlahkan poin tersebut ke total poin di tabel `User`).
55. **Kenapa data poin dipisah ke tabel transaksi dan tidak di-update saja di tabel User?** (Jawab: Untuk fungsi *Audit Trail*. Jika ada dugaan kecurangan, admin bisa memantau riwayat kapan saja poin itu didapatkan).
56. **Bagaimana cara kerja Kupon di sistem Anda?** (Jawab: Model `Coupon` menyimpan `code` dan `expiry_date`. Saat diaplikasikan, sistem akan mengecek apakah kupon valid dengan validasi `now() <= expiry_date`).
57. **Apa yang terjadi jika user biasa nekat membuka `/admin/dashboard`?** (Jawab: `RoleMiddleware` akan membaca peran user (`$user->role`). Jika bukan admin, Laravel akan membuang error 403 *Unauthorized* atau me-redirect mereka ke Homepage).
58. **Bagaimana Anda membatasi Riwayat Pesanan agar orang tidak bisa melihat pesanan orang lain?** (Jawab: Memfilter query di Controller/Livewire dengan `where('user_id', Auth::id())` sebagai parameter wajib).
59. **Apakah sistem lelang Anda menggunakan Cron Job/Scheduler?** (Jawab: Secara teori ya, fitur lelang idealnya menggunakan Laravel Scheduler (Task Scheduling) yang berjalan setiap menit untuk menutup lelang yang masa aktifnya habis).
60. **Jelaskan alur relasi pada fitur Wishlist!** (Jawab: Menggunakan tabel perantara (*pivot table*) `Wishlist` yang menghubungkan `user_id` dan `product_id`. Fungsionalitasnya bertipe *toggle* (jika ada dihapus, jika belum ada ditambah)).

### G. Validasi, File Upload & Konfigurasi (61-75)
61. **Bagaimana proses validasi form (misal saat Checkout) di Livewire?** (Jawab: Menggunakan array `$rules` di class, lalu memanggil method `$this->validate()`. Jika gagal, Livewire otomatis mengembalikan pesan ke variabel `$errors` di Blade).
62. **Kenapa harus validasi di Backend padahal di HTML sudah pakai atribut `required`?** (Jawab: Validasi HTML sangat mudah dimanipulasi dengan *Inspect Element*. Backend adalah pertahanan mutlak yang tidak bisa diakali oleh klien).
63. **Bagaimana alur upload gambar produk di Admin Panel?** (Jawab: Menggunakan sifat `Livewire\WithFileUploads`. File dipindah ke sistem *Storage* (`disk('public')`), lalu hanya *path/lokasi* direktorinya yang disimpan ke kolom tabel database).
64. **Kenapa tidak menyimpan gambar langsung ke dalam Database (tipe BLOB)?** (Jawab: Membuat database sangat bengkak, lambat di-query, dan membebani memori server database. Menyimpan *path* di DB adalah standar industri).
65. **Bagaimana cara Anda mem-format nominal uang menjadi Rupiah di backend?** (Jawab: Menggunakan fungsi PHP `number_format($price, 0, ',', '.')` atau meletakkannya di *Accessor* Model agar formatnya konsisten di seluruh web).
66. **Apa itu *SoftDeletes* pada Produk dan mengapa dipakai?** (Jawab: Saat Admin "menghapus" produk, produk aslinya cuma disembunyikan. Ini agar riwayat pesanan (*Order*) lama yang merujuk ke produk itu tidak *error* (*Referential Integrity*)).
67. **Jelaskan peran Facade `Auth::user()`!** (Jawab: *Facade* yang menyediakan akses global/statis ke *instance* user yang sedang login di sesi tersebut, mempermudah pemanggilan identitas user tanpa *passing variable* manual).
68. **Apa fungsi *Seeder* dan *Factory* di Laravel?** (Jawab: *Factory* adalah cetakan data fiktif (memakai library Faker). *Seeder* bertugas mengeksekusi factory untuk mengisi tabel dengan ratusan data percobaan).
69. **Apa arti `protected $guarded = []` di Model?** (Jawab: Kebalikan dari `$fillable`. Ini memberitahu Laravel bahwa SEMUA kolom tabel boleh disisipkan data, kecuali yang ditulis di array tersebut. Lebih praktis saat *coding* cepat).
70. **Jika Anda harus me-reset database sekarang juga, perintah apa yang dijalankan?** (Jawab: `php artisan migrate:fresh --seed`. Menghapus total seluruh tabel, membuat ulang dari nol, dan mengisinya dengan data sampel).
71. **Kenapa folder `vendor` di-ignore oleh `.gitignore`?** (Jawab: Folder `vendor` berisi puluhan ribu file library framework yang sangat berat (ratusan MB). Kita cuma butuh `composer.json` agar tim lain bisa men-downloadnya sendiri via `composer install`).
72. **Apa yang terjadi saat Anda menjalankan `npm run dev`?** (Jawab: Menjalankan *Vite* (*bundler*) lokal yang bertugas mengompilasi file Tailwind CSS dan JavaScript, lalu menginjeksinya langsung ke browser secara *real-time*).
73. **Jika muncul error SQL "Field doesn't have a default value", apa artinya?** (Jawab: Ada kolom wajib (*NOT NULL*) di database yang kelupaan dikirim/disisipkan datanya saat perintah `Model::create()` atau `save()` dijalankan di backend).
74. **Secara performa, lebih baik `count()` di Collection atau `count()` di Database Query?** (Jawab: Database Query (`Model::count()`) jauh lebih cepat. Database hanya me-return angka ke RAM. Jika pakai collection, puluhan ribu data di-load ke RAM dulu baru dihitung).
75. **Jelaskan bedanya `find(1)`, `findOrFail(1)`, dan `where()->first()`!** (Jawab: `find()` me-return *null* jika data ID 1 tidak ada. `findOrFail()` akan langsung melempar halaman error 404. `where()->first()` dipakai jika ingin mencari data berdasarkan kondisi selain *primary key*).
