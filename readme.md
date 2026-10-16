# Digital Agtech Indonesia

Platform ekosistem AgTech: event (webinar/workshop), speaker, berita, galeri, partner, program Business Incubation, Self-Learning Program (toolkit), dan Startup Assessment.

Dibangun dengan Laravel 13, MySQL 8, dan Blade + CSS biasa (tanpa build step).

## Instalasi

Kebutuhan: PHP 8.3+, Composer, MySQL 8.

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Buat database kosong (mis. `digitalagtech`, charset `utf8mb4`), lalu isi koneksinya di `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=digitalagtech
DB_USERNAME=...
DB_PASSWORD=...
```

```bash
php artisan migrate --seed    # skema + konten contoh dari desain
php artisan serve             # http://localhost:8000
```

Di server produksi, set juga `APP_ENV=production`, `APP_DEBUG=false`, dan `APP_URL`, lalu jalankan `php artisan migrate --force` (tambahkan `--seed` hanya saat pertama kali jika ingin konten contoh).

Akun admin hasil seeder: `admin@digitalagtech.id` / `password` (khusus lokal).

Test memakai SQLite in-memory, jadi tidak perlu MySQL:

```bash
php artisan test
```

## Struktur

| Bagian | Lokasi |
| --- | --- |
| Halaman publik | `routes/web.php`, `app/Http/Controllers`, `resources/views` |
| Layout & komponen | `resources/views/layouts`, `resources/views/partials`, `resources/views/components/icon.blade.php` |
| CSS & JS | `public/css/{app,components,home,pages,auth}.css`, `public/js/app.js` |
| Gambar bawaan | `public/images/*` (upload admin nantinya ke disk `public`) |
| Konten statis (statistik, kontak, sosmed) | `config/site.php` |
| Desain referensi (HTML statis) | `design-references/` |

## Skema database

- `users`: peserta & admin (`role`, `whatsapp`)
- `events`, `event_sessions` (rundown), `event_speaker`, `event_registrations`
- `speakers`, `posts` (berita), `gallery_photos`, `partners`, `newsletter_subscribers`
- `incubation_programs`, `incubation_program_photos`, `toolkits`
- `assessment_dimensions`, `assessment_questions`, `assessment_options`, `assessment_attempts`, `assessment_answers`

## Belum dikerjakan

- Panel admin untuk mengelola konten
- Alur Startup Assessment (skema dan contoh pertanyaan sudah ada)
- Halaman Courses, Terms, Privacy
- Notifikasi email/WhatsApp setelah pendaftaran event
