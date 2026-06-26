# Dokumentasi Fungsi Admin

Berikut adalah rincian fungsi dari semua komponen yang berkaitan dengan panel admin di proyek ini:

## 1. File Class / Komponen Livewire (Logic Backend)
Berada di dalam direktori `app/Livewire/Admin/`

### Dashboard.php
- **`render()`**: Berfungsi untuk mengambil data statistik (total pesanan, total pendapatan dari pesanan yang selesai/diproses, total produk, total pengguna selain admin, total lelang aktif, dan 5 pesanan terbaru). Data ini kemudian dikirimkan ke file view (`dashboard.blade.php`) untuk ditampilkan.

### Users.php
- **`updatingSearch()`**: Mereset halaman pagination ke awal setiap kali admin mengetik kata kunci pencarian.
- **`updatingRoleFilter()`**: Mereset halaman pagination ke awal ketika filter peran (role) pengguna diubah.
- **`updateRole($userId, $role)`**: Mengubah peran (role) dari pengguna tertentu berdasarkan ID-nya (misal dari user menjadi admin) dan menampilkan notifikasi sukses.
- **`delete($id)`**: Menghapus data pengguna dari database berdasarkan ID dan menampilkan notifikasi sukses.
- **`render()`**: Mengambil data pengguna dari database dengan menerapkan filter pencarian (berdasarkan nama/email) dan filter role. Hasilnya dipaginasi sebanyak 10 data per halaman lalu dikirim ke view.

### Products.php
- **`render()`**: Menampilkan daftar produk beserta kategori (genre), diurutkan dari yang terbaru dengan paginasi 10 per halaman, dan mendukung pencarian berdasarkan judul.
- **`create()`**: Membuka modal (popup) form tambah produk baru dan mengosongkan semua inputan di form.
- **`edit($id)`**: Mengambil data produk berdasarkan ID, mengisi data tersebut ke dalam properti form, dan membuka modal untuk mengubah data.
- **`save(FileUploadService $fileService)`**: Memvalidasi data inputan (seperti judul, harga, dll). Jika ada gambar baru yang diunggah, file gambar lama dihapus dan yang baru disimpan. Setelah itu melakukan proses pembuatan produk baru (`create`) atau pembaruan produk (`update`) berdasarkan apakah ada `productId` atau tidak. Terakhir, kategori disinkronisasi, dan modal ditutup.
- **`delete($id)`**: Menghapus produk dari database berdasarkan ID dan mengirim notifikasi.
- **`resetForm()`**: Mengosongkan seluruh isi variabel/field pada form setelah modal ditutup.

### Orders.php
- **`updatingSearch()`**: Mereset paginasi saat ada pencarian nomor order.
- **`updatingStatusFilter()`**: Mereset paginasi saat status pesanan di-filter (misal: pending, delivered).
- **`updateStatus($orderId, $status)`**: Memperbarui status pemesanan tertentu langsung dari tabel data dan memunculkan notifikasi sukses.
- **`render()`**: Menampilkan daftar pesanan dengan relasi data pembelinya (user). Mendukung filter pencarian nomor pesanan dan filter status, lalu membagi tampilannya menjadi 15 data per halaman.

### Games.php
- **`updatingSearch()`**: Mereset paginasi ketika ada pencarian.
- **`create()`**: Mengosongkan form dan membuka modal tambah game baru.
- **`edit($id)`**: Memuat data game lama ke dalam form modal untuk diedit.
- **`store()`**: Memvalidasi data inputan game (nama, poin dibutuhkan, gambar thumbnail). Jika ada gambar thumbnail baru, gambar yang lama akan dihapus dari server lalu diganti yang baru. Kemudian membuat atau memperbarui record game di database lalu menutup modal.
- **`delete($id)`**: Menghapus record game dari database sekaligus menghapus file gambar (thumbnail) fisiknya dari storage server.
- **`closeModal()`**: Menutup tampilan modal form dan mengosongkan inputan.
- **`resetInputFields()`**: Fungsi pembantu untuk mengosongkan variabel-variabel form game.
- **`render()`**: Mengambil daftar game beserta fitur pencarian (nama atau deskripsi) dan paginasi 10 per halaman.

### Genres.php
- **`updatingSearch()`**: Mereset paginasi saat mencari nama genre.
- **`create()`** & **`edit($id)`**: Serupa dengan fitur produk/game; berfungsi membuka modal untuk tambah data baru atau edit data yang sudah ada.
- **`save()`**: Memvalidasi inputan (hanya butuh nama). Membuat *slug* URL (misal nama "Buku Fiksi" menjadi `buku-fiksi`). Jika tidak ada gambar yang diupload, sistem akan secara otomatis membuat gambar inisial dari nama menggunakan layanan `ui-avatars.com`. Data kemudian disimpan/diperbarui di database.
- **`delete($id)`**: Menghapus data genre.
- **`closeModal()`** & **`resetInputFields()`**: Berfungsi menutup popup form dan membersihkan sisa inputan.
- **`render()`**: Menampilkan list kategori (genre) berdasarkan pencarian nama dan paginasi 10 baris.

### Auctions.php
- **`updatingSearch()`** & **`updatingStatusFilter()`**: Fungsi reset paginasi saat pencarian atau filter status (aktif/selesai/dibatalkan) berubah.
- **`create()`** & **`edit($id)`**: Menangani aksi buka form untuk tambah atau edit acara lelang. Waktu mulai dan berakhirnya di-format ulang agar pas dengan input waktu HTML.
- **`store()`**: Memvalidasi jadwal, status, harga awal, dan produk yang akan dilelang. Khusus harga `current_price` (harga lelang saat ini) tidak akan direset jika ini merupakan mode edit. Menyimpan data dan menutup form modal.
- **`delete($id)`**: Menghapus data lelang beserta semua riwayat penawaran (melalui efek *cascade* database, biasanya) dan memberikan notifikasi sukses.
- **`closeModal()`** & **`resetInputFields()`**: Menutup form modal lelang dan membersihkan variabel.
- **`render()`**: Mengambil data list lelang beserta relasi data produk aslinya, lalu dipaginasi. Juga mengirimkan seluruh list Produk ke view untuk dipakai sebagai opsi *dropdown* di form modal tambah lelang.

### Coupons.php
- **`updatingSearch()`**: Mereset halaman saat pencarian kode/nama kupon.
- **`create()`** & **`edit($id)`**: Fungsi wajib untuk menampilkan form modal tambah diskon atau mengisi data kupon yang mau diedit.
- **`save()`**: Memvalidasi kriteria ketat untuk kupon (kode harus unik, batas pakai, nilai nominal/persen, batas waktu aktif/kadaluarsa). Kode kupon otomatis dibuat menjadi HURUF BESAR (uppercase) menggunakan fungsi `strtoupper`. Lalu menyimpan kupon ke sistem.
- **`delete($id)`**: Menghapus kupon secara spesifik.
- **`resetForm()`**: Mengosongkan data form (seperti kode, nama, tipe diskon, tanggal aktif).
- **`render()`**: Menyediakan daftar kupon untuk dilihat di tabel dengan fitur pencarian kode/nama dan paginasi.

---

## 2. File View / Blade Livewire (Tampilan UI)
Berada di direktori `resources/views/livewire/admin/`

- **`dashboard.blade.php`**: Berfungsi menampilkan rangkuman statistik utama. Biasanya berisi "Card" atau kotak-kotak yang menampilkan angka (Total Pendapatan, Jumlah Produk, Jumlah Pesanan). Menampilkan tabel kecil berisi Pesanan Terbaru (Recent Orders) agar admin bisa langsung melihat transaksi yang baru masuk tanpa harus ke halaman Orders.
- **`users.blade.php`**: Menampilkan tabel daftar Pengguna (Users). Menyediakan kotak input pencarian dan dropdown filter peran (User biasa / Admin). Memiliki tombol aksi di setiap baris tabel untuk mengubah role seseorang atau menghapus akun mereka secara langsung.
- **`products.blade.php`**: Menampilkan tabel Katalog Produk/Buku. Memiliki tombol "Tambah Produk" yang, jika diklik, akan memunculkan sebuah jendela Popup / Modal. Di dalam modal tersebut terdapat form input untuk mengisi rincian produk (judul, harga, deskripsi, stok, diskon) dan fitur unggah (upload) sampul/cover gambar.
- **`orders.blade.php`**: Menampilkan tabel Daftar Pesanan (Transaksi). Menampilkan informasi nomor resi/order, nama pemesan, dan total harga. Menyediakan dropdown atau tombol di setiap baris tabel agar admin bisa dengan cepat mengubah status pesanan (misal: dari "Sedang Diproses" menjadi "Sedang Dikirim").
- **`games.blade.php`**: Mirip seperti produk, file ini menampilkan daftar mini-game/sistem reward. Berisi modal form untuk memasukkan judul game, syarat poin, dan mengunggah gambar thumbnail dari game tersebut.
- **`genres.blade.php`**: Menampilkan daftar nama-nama Kategori / Genre. Terdapat tombol Edit dan Hapus, serta modal sederhana untuk menambah nama genre baru.
- **`auctions.blade.php`**: Menampilkan tabel daftar Barang Lelang. Memiliki form modal yang dikhususkan untuk memasukkan tanggal dan waktu lelang (`starts_at` dan `ends_at`), serta harga awal (starting price). Ada fitur dropdown untuk memilih produk mana yang akan dilelang.

---

## 3. Layout Khusus Admin (Template Utama)
Berada di direktori `resources/views/layouts/`

- **`admin.blade.php`**: Ini adalah Master Template. File ini berisi struktur dasar HTML (`<html>`, `<head>`, `<body>`). Di dalamnya terdapat pemanggilan file CSS dan Javascript bawaan sistem (seperti Tailwind CSS atau Alpine.js). File ini juga memuat struktur Sidebar Navigasi (Menu Kiri) dan Topbar (Header Atas) panel admin (seperti foto profil admin, tombol logout). Terdapat tag khusus bernama `{{ $slot }}` tempat komponen halaman dirender.
- **`partials/admin-mobile-menu.blade.php`**: File ini khusus menyimpan kodingan tampilan Menu Navigasi untuk layar HP/Mobile. Biasanya berisi kode untuk hamburger menu (tombol garis tiga) yang saat ditekan akan memunculkan daftar menu yang disesuaikan untuk layar sempit agar tidak menutupi tampilan tabel yang lebar.

**Variasi Layout Admin (v1 dan v2):**
Di dalam folder layout, ada folder versi (`v1` dan `v2`). Ini adalah versi desain dari panel admin:
- **`layouts/v1/admin.blade.php` & `layouts/v1/partials/admin-mobile-menu.blade.php`** (serta versi `v2`): Menandakan iterasi UI panel admin. Jika ada beberapa versi, biasanya yang satu merupakan desain lama (legacy) atau variasi desain lain yang dapat digunakan oleh sistem.

---

## 4. Keamanan Admin (Middleware)
Berada di `app/Http/Middleware/RoleMiddleware.php`

- **RoleMiddleware**: Berfungsi sebagai "satpam" (penjaga keamanan) pintu masuk untuk rute halaman admin. Tugas utamanya ada dua:
  1. Mengecek apakah pengguna tersebut sudah login atau belum (`!$request->user()`).
  2. Mengecek apakah status peran (`role`) dari pengguna yang login tersebut sama dengan peran yang disyaratkan oleh halaman yang ingin ia kunjungi (misal harus `admin`).
  Jika syaratnya tidak terpenuhi (pengguna biasa mencoba masuk halaman admin), sistem akan memblokir dengan error `403 Unauthorized Access`. Jika sesuai, barulah permintaan diizinkan lewat ke halaman yang dituju (`$next($request)`).

---

## 5. Pengaturan Styling / Desain (Tailwind CSS)
Panel admin di proyek ini dirancang antarmukanya menggunakan kerangka kerja (framework) **Tailwind CSS**. Terdapat file konfigurasi `tailwind.config.js` (serta versi pecahannya seperti `tailwind.config.v1.js` dan `tailwind.config.v2.js`) yang letaknya di folder utama proyek (root). 

Fungsi spesifik dari konfigurasi Tailwind CSS untuk admin panel ini adalah:
- **Kustomisasi Warna (Custom Colors)**: Mendaftarkan palet warna khusus. Misalnya, terdapat deklarasi warna `admin-blue`, warna `primary` bernuansa gelap (`#2D3B6D`), dan spesifik warna bagian admin seperti `admin: { sidebar: '#1A243F', header: '#2D3B6D', hover: '#639487' }`. Warna ini bisa langsung dipakai di file Blade dengan menuliskan class seperti `bg-admin-sidebar` atau `text-admin-header`.
- **Kustomisasi Tipografi & Efek**: Mendeklarasikan jenis font (`fontFamily` seperti *Inter* atau *Playfair Display*), penyesuaian sudut membulat komponen (`borderRadius`), serta pengaturan bayangan khusus (`boxShadow`) untuk efek melayang pada elemen "Card", "Dropdown", dan "Modal" yang banyak dipakai di halaman Livewire admin.
- **Plugin Tambahan**: Menggunakan plugin tambahan Tailwind seperti `@tailwindcss/forms` untuk merapikan desain bawaan (default) elemen inputan formulir seperti kotak teks, *checkbox*, dan *radio button* yang tersebar di form-form tambah produk/pengguna admin, dan `@tailwindcss/typography` untuk merapikan artikel/teks panjang.
- **Pemindaian File (Content Paths)**: Memberi tahu Tailwind untuk memindai penggunaan nama-nama *class* desain di dalam seluruh file `resources/**/*.blade.php` (termasuk folder view admin) dan `app/Livewire/**/*.php` (karena class PHP Livewire terkadang menghasilkan/mengembalikan *class* HTML secara dinamis).

### Penerapan Spesifik Tailwind di File View Admin (`resources/views/livewire/admin/*`)
Di dalam file-file antarmuka admin, Tailwind digunakan secara ekstensif dengan menuliskan utilitas *class* secara langsung pada tag HTML. Berdasarkan analisis langsung pada kodingan file `dashboard.blade.php` dan `users.blade.php`, berikut adalah rincian nyata pemakaiannya:

**1. Tata Letak Dasbor (Grid System) di `dashboard.blade.php`**
Untuk membuat kotak-kotak ringkasan statistik (Pendapatan, User, dll) agar bisa berjajar rapi ke samping di layar besar namun menumpuk ke bawah di layar HP, kode menggunakan *class*:
```html
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 border-l-4 border-l-blue-500">...</div>
</div>
```
- `grid-cols-1`: Secara default (di layar HP), elemen ditumpuk 1 kolom.
- `md:grid-cols-4`: Di layar berukuran sedang (tablet/PC), elemen langsung dijajarkan menjadi 4 kolom.
- `gap-6`: Memberi jarak antar kotak ringkasan.
- `border-l-4 border-l-blue-500`: Memberikan garis tebal warna biru di sebelah kiri kotak sebagai penanda visual.

**2. Desain Tabel dan Warna Kustom di `users.blade.php`**
Pada daftar pengguna, tabel dibungkus dengan kartu elegan dan avatar huruf inisial:
```html
<!-- Pembungkus Tabel -->
<div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">...</div>

<!-- Lingkaran Inisial Nama (Avatar) -->
<div class="w-8 h-8 bg-sigmaven-admin-blue/10 rounded-full flex items-center justify-center text-xs font-bold text-sigmaven-admin-blue">
```
- `bg-sigmaven-admin-blue/10`: Menggunakan warna khusus `sigmaven-admin-blue` (dari file config Tailwind) namun tingkat transparansi latar belakangnya dibuat 10%, dipadukan dengan teks warna penuh (`text-sigmaven-admin-blue`) agar terlihat kontras dan tidak mencolok (soft/pastel).
- `rounded-full flex items-center justify-center`: Membuat avatarnya bulat sempurna dan teks huruf berada persis di tengah.

**3. Interaksi dan Formulir (Input & Dropdown)**
Masih di `users.blade.php`, elemen kotak pencarian dan *dropdown* role memakai *class* yang memberikan efek fokus dan warna dinamis:
```html
<!-- Efek Interaktif (Hover/Focus) -->
<input class="border-gray-300 rounded-lg focus:ring-sigmaven-admin-blue focus:border-sigmaven-admin-blue ...">

<!-- Dropdown Warna Status Peran (Role) -->
<select class="{{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800' : ($user->role == 'premium' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-600') }}">
```
- `focus:ring-sigmaven-admin-blue`: Saat admin mengeklik kotak pencarian untuk mengetik, akan muncul cincin (garis luar menyala) berwarna biru khusus.
- **Logika Warna Kondisional**: Di bagian tag `<select>` status role, Tailwind dipadukan dengan logika PHP Blade. Jika rolenya **admin**, warna dropdown-nya ungu (`bg-purple-100`), jika **premium** berwarna kuning (`bg-yellow-100`), dan sisanya abu-abu standar. Ini sangat membantu mata admin membedakan peran setiap pengguna dengan cepat di tabel.

**4. Efek Arahkan Mouse (Hover State)**
Di hampir semua tabel (termasuk pesanan dan pengguna), terdapat tag `<tr class="hover:bg-gray-50 transition">`. Ini membuat setiap baris data di dalam tabel akan otomatis sedikit menggelap (abu-abu muda) dan terasa mulus (transition) ketika mouse admin digerakkan di atasnya, memudahkan admin membaca sebaris data dari kiri ke kanan agar tidak tertukar.
