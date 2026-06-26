# Jawaban Presentasi Backend Web: Khusus Fitur ADMIN

Dokumen ini disusun khusus sebagai "contekan" Anda apabila dosen penguji menggali lebih dalam mengenai **Admin Panel**, sistem CRUD (Create, Read, Update, Delete), Manajemen *Role*, dan Upload File di proyek Sigmaven VPS Anda.

---

## BAGIAN I: 4 TOPIK UTAMA ADMIN (PENJELASAN MENDALAM)

### 1. Sistem Proteksi Rute (Role Middleware)
**Tanya:** *Bagaimana cara kamu membatasi agar halaman Admin tidak bisa diakses sembarang orang?*
**Jawab:** "Saya melindungi seluruh rute admin menggunakan `RoleMiddleware:admin`. Saat ada request masuk ke URL `/admin/...`, Middleware ini akan memeriksa hak akses (role) dari user yang sedang login menggunakan `Auth::user()->role`. Jika *value*-nya bukan `'admin'`, sistem otomatis menendang (*redirect*) user tersebut ke halaman utama atau memunculkan halaman error 403 (Unauthorized). Middleware ini dibungkus dalam *Route Group* agar efisien."

### 2. Arsitektur CRUD dengan Livewire Modals
**Tanya:** *Jelaskan alur Create/Update data (misal Produk) di panel admin Anda!*
**Jawab:** "Di MVC biasa, Create dan Update butuh rute `GET` untuk form dan `POST` untuk simpan data, lalu *page reload*. Karena saya pakai Livewire, seluruh proses CRUD terjadi di 1 file komponen (misal `Admin\Products.php`).
Saat tombol 'Tambah' diklik, komponen mengubah state `$showModal = true`, yang seketika memunculkan *Form Modal* di layar tanpa reload. Saat di-*submit*, method `save()` dieksekusi via AJAX. Data tersimpan di database, modal tertutup, dan tabel otomatis merender data terbaru."

### 3. File Upload Service & Storage
**Tanya:** *Bagaimana kamu menangani upload foto produk/cover buku?*
**Jawab:** "Saya menggunakan Trait `Livewire\WithFileUploads`. Saat gambar dipilih, file tersebut disimpan sementara (*temporary directory*) oleh Livewire. Saat form disubmit, saya menyerahkannya ke **Service Class** (`FileUploadService::uploadImage()`). Service ini bertugas menyimpan file fisik ke direktori `storage/app/public` dan me-return path/nama filenya. Nama file inilah yang saya simpan ke kolom `cover_image` di tabel database, BUKAN menyimpan file utuhnya (BLOB)."

### 4. Relasi Many-to-Many (`sync`)
**Tanya:** *Satu produk bisa punya banyak genre, dan genre bisa punya banyak produk. Bagaimana kamu menyimpannya?*
**Jawab:** "Ini disebut relasi *Many-to-Many*. Saya menyimpannya di tabel *pivot* (misalnya `genre_product`). Saat fitur Edit atau Create Produk dijalankan, setelah tabel `products` tersimpan, saya memanggil fungsi Eloquent `$product->genres()->sync($this->genre_ids);`. Fungsi `sync()` ini sangat cerdas; ia otomatis mengecek array ID genre yang diinputkan, lalu menambah/menghapus *record* di tabel pivot tanpa perlu kita menulis query IF-ELSE yang rumit."

---

## BAGIAN II: BANK 30 PERTANYAAN KHUSUS ADMIN PANEL

Berikut adalah daftar pertanyaan menjebak dari dosen seputar Panel Admin beserta kunci jawabannya:

### A. Middleware & Keamanan Panel Admin
1. **Bagaimana cara kerja autentikasi ganda di Admin Panel kamu?** (Jawab: Lapisan pertama adalah `auth` middleware (harus login), lapisan kedua adalah `RoleMiddleware` (harus admin). Keduanya digabungkan di `Route::middleware()`).
2. **Apa yang terjadi jika saya mengganti value 'role' di database langsung jadi 'admin'?** (Jawab: Begitu Anda login ulang, sesi akan mendeteksi role baru tersebut dan Middleware akan otomatis memberikan Anda akses ke panel Admin tanpa error).
3. **Bagaimana cara kamu mencegah serangan CSRF saat submit form tambah barang?** (Jawab: Karena ini Livewire, setiap request AJAX ke server sudah otomatis disisipkan CSRF token yang dienkripsi di *header* HTTP-nya).
4. **Apa bedanya *Authorization* dan *Authentication* di proyekmu?** (Jawab: *Authentication* (auth) itu mengecek "Apakah kamu punya akun?". *Authorization* (role) mengecek "Apakah kamu punya hak untuk mengedit produk?").

### B. Livewire CRUD & Pagination
5. **Jelaskan siklus (alur) saat Admin menekan tombol "Edit" produk!** (Jawab: Tombol "Edit" memanggil fungsi `edit($id)` via *wire:click*. Backend mencari data via `Product::findOrFail($id)`, lalu mengisi *public properties* seperti `$title` dan `$price`. Terakhir, `$showModal` diset `true` agar form edit terbuka).
6. **Kenapa saat menghapus atau menambah produk, halamannya tidak loading?** (Jawab: Karena Livewire menggunakan AJAX. Backend hanya me-return potongan HTML tabel yang baru (berisi data baru), lalu JavaScript mengganti DOM HTML lama secara instan).
7. **Bagaimana fitur Search/Pencarian di tabel Admin bekerja?** (Jawab: Saya mem-binding input teks ke properti `$search` (`wire:model.live`). Tiap ketikan mengirim request. Method `render()` lalu melakukan query SQL `where('title', 'like', '%' . $this->search . '%')`).
8. **Apa bedanya `wire:model` dan `wire:model.live` di fitur pencarian?** (Jawab: `wire:model` biasa baru mengirim data ke server saat di-*submit* atau hilang fokus. `wire:model.live` mengirim data setiap detik (*debounce*) saat user mengetik).
9. **Jelaskan bagaimana fitur Pagination di tabel Admin kamu bekerja!** (Jawab: Saya menggunakan trait `WithPagination`. Di query saya panggil `->paginate(10)`. Livewire akan menghitung otomatis limit dan offset SQL-nya, serta me-render tombol Next/Prev HTML-nya).
10. **Kenapa kita butuh Pagination, tidak di-`get()` semua saja?** (Jawab: Jika produk sudah mencapai 10.000 data, melakukan `get()` semua akan menghabiskan memori RAM server (*Out of Memory*) dan membuat browser klien *hang/freeze*).
11. **Bagaimana cara kamu me-reset isi form setelah berhasil tambah produk?** (Jawab: Saya memanggil method pendukung `$this->resetForm()` yang akan mengosongkan/mereset kembali array maupun variabel judul, harga, dan ID ke nilai *null* atau awal).

### C. Validasi Data & File Uploads
12. **Jelaskan proses validasi data saat Admin menambah Produk baru.** (Jawab: Di awal method `save()`, saya memanggil `$this->validate([...])`. Laravel mencocokkan input dengan *rules* (seperti `required`, `numeric`). Jika gagal, proses berhenti dan error dikembalikan ke view).
13. **Jika Admin memasukkan "ABC" di kolom harga, apa yang terjadi?** (Jawab: Validasi backend dengan rule `numeric` akan menolak request tersebut. Database tetap aman karena insert tidak dieksekusi).
14. **Bagaimana Livewire menangani File Upload sementara?** (Jawab: Sebelum form disubmit utuh, saat file dipilih, Livewire men-generate URL *signed* dan mengupload file ke folder *temporary* secara terpisah di background untuk dicek ekstensinya).
15. **Jelaskan alasan penggunaan Class `FileUploadService`!** (Jawab: Ini adalah pola desain *Service Pattern*. Mengupload file, mengganti nama file agar unik, dan menghapus file lama adalah tugas yang sering berulang. Ditaruh di *Service* agar *Controller/Livewire* tetap bersih dan mudah dibaca).
16. **Jika Admin mengubah gambar cover produk (Edit), apa yang terjadi dengan gambar lamanya?** (Jawab: Sistem mengecek apakah ada gambar baru. Jika ada, sistem akan menghapus file gambar lama secara fisik menggunakan `Storage::delete()` agar hardisk server tidak penuh oleh sampah).
17. **Dimanakah sebenarnya lokasi folder tempat gambar produk disimpan di server?** (Jawab: Gambar tersimpan di `storage/app/public`. Agar bisa diakses oleh browser dari luar, saya menjalankan perintah `php artisan storage:link` yang membuat *shortcut/symlink* ke folder `public/storage`).

### D. Relasi & Operasi Database Admin
18. **Apa fungsi dari `Str::slug($this->title)` saat menambah produk?** (Jawab: Fungsi ini mengubah string seperti "Buku Belajar PHP" menjadi "buku-belajar-php" yang *URL-friendly*, dan disimpan ke database untuk keperluan rute detail produk).
19. **Jelaskan bedanya `sync()`, `attach()`, dan `detach()` pada relasi *Many-to-Many* (Genre)!** (Jawab: `attach` hanya menambah ID baru ke tabel pivot. `detach` hanya menghapus ID. `sync` melakukan keduanya sekaligus (menghapus yang tak dicentang, dan menambah yang dicentang)).
20. **Kenapa kamu tidak pakai `DB::table('products')->insert()` saja untuk menginput data?** (Jawab: Karena Eloquent `Product::create()` lebih canggih. Ia otomatis melindungi dari Mass Assignment, otomatis mengisi `created_at` dan `updated_at`, dan me-return *Object Model* yang saya butuhkan untuk fungsi relasi lanjutan).
21. **Bagaimana kamu meng-update data menggunakan Eloquent?** (Jawab: Mencari data berdasar primary key `Product::find($id)`, lalu memanggil method `update($dataArray)` yang berisi kolom-kolom baru).
22. **Apa yang terjadi pada database saat tombol Delete produk ditekan?** (Jawab: Memanggil `Product::find($id)->delete()`. Jika model menggunakan trait *SoftDeletes*, kolom `deleted_at` diisi timestamp hari ini, data tidak benar-benar lenyap dari tabel).
23. **Kenapa status pembayaran (Payment Status) di Order tidak ditaruh di tabel Order saja?** (Jawab: Karena Payment berpotensi memiliki strukturnya sendiri (seperti `payment_gateway_response`, `proof_of_transfer`, `settlement_time`). Dipisah ke tabel relasi `hasOne(Payment::class)` agar database lebih ter-Normalisasi).
24. **Bagaimana Admin membuat Kupon Diskon?** (Jawab: Admin mengisi form yang menginsert data ke tabel `Coupons`. Kupon menyimpan `code`, tipe diskon (persen/fix), nominal, dan batas waktu `expiry_date`).

### E. Fitur Spesifik (Lelang, User, Game)
25. **Apa wewenang Admin di fitur Lelang (Auctions)?** (Jawab: Admin memiliki CRUD untuk membuka event Lelang, menentukan barang, `starting_price` (harga pembuka), dan `end_time` (waktu tutup)).
26. **Bisakah Admin memanipulasi *Bid* (tawaran) lelang user?** (Jawab: Idealnya tidak bisa (di-*lock* dari UI), agar lelang tetap *fair/adil*. Admin hanya bertugas memantau relasi tabel `AuctionBid` dan menentukan status validasi pemenang).
27. **Bagaimana Admin melihat pesanan masuk (Orders)?** (Jawab: Admin me-load komponen Livewire `Orders` yang melakukan *Eager Loading* relasi: `Order::with(['user', 'items.product'])->latest()->paginate(10)`).
28. **Jika user nakal dan poin gamenya tidak wajar, bagaimana admin mengeceknya?** (Jawab: Admin bisa melihat tabel log `PointsTransaction`. Tabel ini menyimpan *audit trail* berisi catatan historis kapan dan dari *game* apa poin ditambahkan, bukan cuma nilai total akhirnya).
29. **Apa fungsi *Toggle* `is_active` atau `is_featured` di tabel produk?** (Jawab: Nilai *boolean* ini digunakan untuk menyembunyikan produk (jika stok kosong/rusak) tanpa menghapusnya, atau menampilkannya di *Carousel/Banner* halaman utama (Featured)).
30. **Secara keseluruhan, apa bagian tersulit membangun panel Admin ini?** (Jawab: "Mengelola *state* kerumitan Form Modal yang memuat operasi CRUD tabel Pivot (Many-to-Many Genre) sekaligus *upload* dan replikasi file fisik gambar, tanpa satupun aksi *reload* halaman menggunakan Livewire!").
