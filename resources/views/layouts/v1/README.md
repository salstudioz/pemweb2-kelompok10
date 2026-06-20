# Desain Sistem v1 — Sigmaven (Backup)

Folder ini menyimpan **backup desain sistem lama (v1)** Sigmaven sebelum redesign.

## Tanggal Backup
20 Juni 2026

## File yang Tersimpan

| File | Keterangan |
|------|-----------|
| `app.blade.php` | Layout utama user/public |
| `admin.blade.php` | Layout admin panel |
| `guest.blade.php` | Layout halaman tamu (login/register) |
| `header.blade.php` | Layout header lama |
| `sidebar.blade.php` | Sidebar lama |
| `partials/header.blade.php` | Header partial (navbar) |
| `partials/footer.blade.php` | Footer partial |
| `partials/toast.blade.php` | Toast notification partial |
| `partials/admin-mobile-menu.blade.php` | Mobile menu admin partial |

## CSS & Config Backup
- `resources/css/app.v1.css` — CSS lama
- `tailwind.config.v1.js` — Tailwind config lama

## Tema v1
- **Warna utama**: Forest green `#1C3F35`, Gold `#C69C6D`, Cream `#FBFBF9`
- **Font**: Playfair Display (serif) + Inter (sans)
- **Gaya**: Literary / elegan, minimalis

## Cara Restore
Kalau mau balik ke desain lama, copy file-file dari folder ini ke `resources/views/layouts/`
dan rename `app.v1.css` → `app.css` dan `tailwind.config.v1.js` → `tailwind.config.js`.
