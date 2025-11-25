# Panduan Setup AgroWaste Academy

## Persiapan Awal

### 1. Install Dependencies
Buka terminal di folder project dan jalankan:

```bash
cd "d:\ketapang\Agro Waste"
composer install
npm install
```

### 2. Setup Environment
File `.env` sudah tersedia. Pastikan konfigurasi database sudah benar:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=agrowaste_academy
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Buat Database
Buat database baru di MySQL/phpMyAdmin dengan nama `agrowaste_academy`

Atau via command line:
```sql
CREATE DATABASE agrowaste_academy CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Jalankan Migrasi Database
```bash
php artisan migrate
```

### 6. Jalankan Seeder (Data Dummy)
```bash
php artisan db:seed
```

Seeder akan membuat:
- 2 Role (Admin & User)
- 4 User (1 admin + 3 user biasa)
- 3 Modul pembelajaran
- 9 Video (3 per modul)
- 3 Quiz dengan 5 soal per quiz

### 7. Buat Storage Link (Untuk upload file)
```bash
php artisan storage:link
```

## Menjalankan Aplikasi

### 1. Start Laravel Development Server
```bash
php artisan serve
```
Aplikasi akan berjalan di: http://localhost:8000

### 2. Start Vite Development Server (di terminal baru)
```bash
npm run dev
```

## Akun Login Default

### Admin:
- Email: admin@agrowaste.com
- Password: password

### User Biasa:
- Email: budi@agrowaste.com
- Password: password

atau

- Email: siti@agrowaste.com
- Password: password

## Struktur Project

### Database Tables:
1. `roles` - Role user (Admin/User)
2. `users` - Data pengguna
3. `modules` - Modul pembelajaran
4. `videos` - Video tutorial
5. `quizzes` - Kuis
6. `quiz_questions` - Pertanyaan kuis
7. `quiz_options` - Opsi jawaban
8. `quiz_attempts` - Riwayat percobaan kuis
9. `user_module_progress` - Progress belajar user

### Routes:
- `/` - Landing page
- `/login` - Halaman login
- `/register` - Halaman registrasi
- `/home` - Dashboard user
- `/modules` - Daftar modul
- `/modules/{slug}` - Detail modul
- `/videos/{id}` - Halaman video
- `/quizzes/{id}` - Halaman kuis
- `/quizzes/{id}/start` - Mulai kuis
- `/quizzes/result/{attemptId}` - Hasil kuis

## Fitur-Fitur

### 1. Sistem Autentikasi
- Login & Register
- Session management
- Role-based access (Admin/User)

### 2. Modul Pembelajaran
- Membaca materi (HTML content)
- Progress tracking per user
- Navigasi antar section (Modul → Video → Quiz)

### 3. Video Pembelajaran
- Daftar video per modul
- Navigation (previous/next)
- Mark as complete

### 4. Sistem Kuis
- Multiple choice questions
- Automatic scoring
- Pass/Fail status (minimum 70)
- Unlimited retakes
- Best score tracking
- Detailed results

### 5. Progress Tracking
- Per module progress (Module, Video, Quiz)
- Completion percentage
- Module completion certificate message

## Customization

### Menambah Modul Baru
Edit file: `database/seeders/ModuleSeeder.php`

### Menambah Video
Edit file: `database/seeders/VideoSeeder.php`

### Menambah Quiz & Soal
Edit file: `database/seeders/QuizSeeder.php`

Setelah edit seeder, jalankan:
```bash
php artisan migrate:fresh --seed
```

**WARNING**: Perintah di atas akan menghapus semua data dan mengisi ulang!

### Styling
File CSS utama: `resources/css/app.css`
Tailwind config: `tailwind.config.js`

## Troubleshooting

### Error "No application encryption key"
```bash
php artisan key:generate
```

### Error "Class not found"
```bash
composer dump-autoload
```

### Error CSS tidak muncul
Pastikan Vite running:
```bash
npm run dev
```

Untuk production:
```bash
npm run build
```

### Error Database Connection
- Cek MySQL sudah running
- Cek kredensial database di file `.env`
- Pastikan database sudah dibuat

### Error Permission (Storage)
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## Production Deployment

### 1. Build Assets
```bash
npm run build
```

### 2. Optimize Laravel
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. Set Environment
Ubah `.env`:
```env
APP_ENV=production
APP_DEBUG=false
```

## Teknologi yang Digunakan

- **Backend**: Laravel 11
- **Frontend**: Blade Templates, Tailwind CSS
- **Database**: MySQL
- **Build Tool**: Vite
- **Authentication**: Laravel Session-based Auth

## Kontak & Support

Untuk pertanyaan atau issue, silakan buat issue di repository atau hubungi developer.

---

**Selamat menggunakan AgroWaste Academy!** 🌾
