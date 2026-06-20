# Desain Sistem v2 — Sigmaven (Backup)

Folder ini menyimpan **backup desain sistem baru (v2)** Sigmaven.

## Tanggal Dibuat
20 Juni 2026

## File yang Tersimpan

| File | Keterangan |
|------|-----------|
| `app.blade.php` | Layout utama user/public |
| `admin.blade.php` | Layout admin panel |
| `guest.blade.php` | Layout halaman tamu (login/register) |
| `partials/header.blade.php` | Header partial (navbar) |
| `partials/footer.blade.php` | Footer partial |
| `partials/toast.blade.php` | Toast notification partial |
| `partials/admin-mobile-menu.blade.php` | Mobile menu admin partial |

## CSS & Config Backup
- `resources/css/app.v2.css` — CSS v2
- `tailwind.config.v2.js` — Tailwind config v2

## Tema v2
- **Primary**: Navy Blue `#2D3B6D`
- **Secondary**: Steel Blue `#517BA8`
- **Accent**: Light Blue `#8ABDCE`
- **Highlight**: Teal Green `#639487`
- **Background**: Off White `#EFEDEA`
- **Admin Sidebar**: Dark Navy `#1A243F`
- **Font**: Playfair Display (serif) + Inter (sans)
- **Gaya**: Clean, profesional, intelektual, elegan biru-teal

## Cara Restore ke v2
Kalau mau pakai desain v2 lagi, copy file-file dari folder ini ke `resources/views/layouts/`
dan rename:
- `app.v2.css` → `app.css`
- `tailwind.config.v2.js` → `tailwind.config.js`
