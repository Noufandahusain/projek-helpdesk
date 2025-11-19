<h1 align="center">Campus Helpdesk</h1>

Helpdesk kampus berbasis Laravel 12 + Tailwind + Alpine. Mahasiswa bisa login memakai email `*.pens.ac.id`, membuat tiket fasilitas kampus, menambahkan komentar, mengunggah lampiran, serta mengunduh laporan tiket dalam bentuk PDF.

## Fitur

- Registrasi/login khusus domain `.pens.ac.id`
- Dashboard ringkasan tiket (total, open, in progress, resolved)
- CRUD tiket (buat, edit, hapus) + upload lampiran
- Thread komentar per tiket
- Laporan tiket dalam format PDF (`barryvdh/laravel-dompdf`)
- Tampilan responsive memakai Tailwind dan Alpine.js

## Tech Stack

- Laravel 12, PHP 8.4
- Tailwind v4, Alpine.js
- SQLite (bisa ganti DB lain)
- Herd sebagai webserver lokal (rekomendasi)

## Prasyarat

1. **Herd** (https://herd.laravel.com) – otomatis memasang PHP, Composer, Valet untuk Windows/macOS.
2. Node.js + npm (sudah disertakan Herd, atau pasang manual).
3. Git untuk clone repo.

## Cara Menjalankan dengan Herd

1. Install Herd dan pastikan sudah aktif. Secara default proyek Laravel bisa ditempatkan di folder `Herd\www`.
2. Clone repo:
   ```bash
   cd ~/Herd/www  # sesuaikan path Herd kamu
   git clone https://github.com/Noufandahusain/projek-helpdesk.git
   cd projek-helpdesk
   ```
3. Pasang dependency backend & frontend:
   ```bash
   composer install
   npm install
   ```
4. Salin file env dan konfigurasi:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   - Set `APP_URL=http://projek-helpdesk.test` (atau domain Herd kamu).
   - Pakai SQLite (default): pastikan `DB_DATABASE` menunjuk ke file `database/database.sqlite`. Buat file kosong jika belum ada.
   - Set `APP_TIMEZONE=Asia/Jakarta` bila perlu.
5. Migrasi dan link storage:
   ```bash
   php artisan migrate
   php artisan storage:link
   ```
6. Jalankan asset build:
   ```bash
   npm run dev   # atau npm run build untuk produksi
   ```
7. Herd akan otomatis membuat domain `http://projek-helpdesk.test`. Buka di browser untuk mengakses aplikasi.
8. Buat akun pertama dengan email `.pens.ac.id` melalui halaman register atau via Tinker:
   ```bash
   php artisan tinker
   >>> App\Models\User::create([
   ... 'name' => 'Admin',
   ... 'email' => 'admin@student.pens.ac.id',
   ... 'password' => bcrypt('passwordku'),
   ... ]);
   ```

## Skrip Penting

- `php artisan serve` (opsional kalau tidak pakai Herd)
- `npm run dev` / `npm run build`
- `php artisan migrate:fresh --seed` (jika menambahkan data dummy)

## Catatan

- Semua file yang diunggah tersimpan di `storage/app/public/ticket-attachments`. Pastikan `storage:link` berhasil agar bisa diakses publik.
- Fitur PDF memakai DOMPDF; jika terjadi error, jalankan `composer install` atau `composer dump-autoload`.
- Saat menjalankan di server production, gunakan `php artisan config:cache`, `php artisan route:cache`, dan `npm run build`.

Happy running
