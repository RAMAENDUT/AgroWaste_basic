# AgroWaste Academy

Platform edukasi untuk membantu petani belajar cara mengolah limbah pertanian menjadi produk yang berguna seperti pupuk, pakan ternak, atau bahan lain.

## Fitur Utama

- **Sistem Autentikasi**: Login dan Register untuk petani
- **Modul Pembelajaran**: Materi pembelajaran dalam bentuk halaman
- **Video Edukasi**: Video tutorial mengolah limbah pertanian
- **Kuis Interaktif**: Evaluasi pemahaman dengan skor otomatis
- **Progress Tracking**: Pencatatan kemajuan belajar pengguna
- **Panel Admin**: Kelola konten pembelajaran

## Instalasi

1. Clone repository
2. Copy `.env.example` menjadi `.env`
3. Jalankan `composer install`
4. Jalankan `npm install`
5. Generate key: `php artisan key:generate`
6. Setup database di `.env`
7. Jalankan migrasi: `php artisan migrate`
8. Jalankan seeder: `php artisan db:seed`
9. Jalankan server: `php artisan serve`
10. Jalankan vite: `npm run dev`

## Akun Default

**Admin:**
- Email: admin@agrowaste.com
- Password: password

**User:**
- Email: user@agrowaste.com
- Password: password

## Teknologi

- Laravel 11
- MySQL
- Tailwind CSS
- Blade Templates
