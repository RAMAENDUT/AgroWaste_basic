# AgroWaste Academy - Course System

## Struktur Database Course

Sistem course yang baru ini berbeda dengan sistem module/video/quiz yang terpisah. Dalam sistem course:

### Tables:
1. **courses** - Kursus utama (seperti "Pengenalan Komposting")
2. **course_contents** - Konten dalam kursus (module/video/quiz dalam satu tabel)
3. **course_enrollments** - Enrollment user ke course
4. **course_content_progress** - Progress user untuk setiap konten
5. **course_quiz_questions** - Pertanyaan quiz untuk konten tipe quiz
6. **course_quiz_options** - Pilihan jawaban quiz
7. **course_quiz_attempts** - Percobaan user mengerjakan quiz

## Cara Menjalankan

### 1. Migrasi Database
```bash
php artisan migrate
```

### 2. Seed Data Sample
```bash
php artisan db:seed --class=CourseSeeder
```

Ini akan membuat 3 course:
- **Pengenalan Komposting** (Pemula, 3 jam) - 4 konten: 2 module, 1 video, 1 quiz
- **Produksi Biogas** (Menengah, 5 jam) - 3 konten: 1 module, 1 video, 1 quiz  
- **Vermikompos Lanjutan** (Lanjutan, 6 jam) - 4 konten: 2 module, 1 video, 1 quiz

### 3. Akses Pages

**Halaman Courses:**
- `/courses` - List semua courses
- `/courses/{id}` - Course player (otomatis menampilkan konten pertama)
- `/courses/{courseId}/content/{contentId}` - Menampilkan konten spesifik

**Fitur:**
- Filter by level (Pemula, Menengah, Lanjutan)
- Search courses
- Enroll ke course
- Progress tracking otomatis
- Quiz dengan auto-grading (passing score 70%)

## Perbedaan dengan Sistem Lama

### Sistem Lama (Module/Video/Quiz Terpisah):
```
modules (table)
  ├── videos (table, FK: module_id)
  └── quizzes (table, FK: module_id)

user_module_progress (table)
  ├── module_completed
  ├── video_completed  
  └── quiz_completed
```

### Sistem Baru (Course System):
```
courses (table)
  └── course_contents (table, FK: course_id)
      ├── type: 'module' | 'video' | 'quiz'
      ├── content (text untuk module)
      ├── video_url (untuk video)
      └── questions (relasi untuk quiz)

course_enrollments (table)
  └── progress_percentage (otomatis dihitung)

course_content_progress (table)
  └── is_completed (per konten)
```

## Keuntungan Sistem Course:

1. **Unified Structure**: Semua konten (module/video/quiz) dalam satu course
2. **Flexible Order**: Konten bisa diatur urutan bebas dengan field `order`
3. **Better Progress**: Progress dihitung otomatis dari semua konten
4. **Enrollment Based**: User harus enroll dulu sebelum bisa akses
5. **Dynamic Content**: Sidebar playlist menampilkan semua konten dengan icon berbeda
6. **Quiz Integration**: Quiz langsung terintegrasi dengan skor dan hasil

## Flow User:

1. User lihat list courses di `/courses`
2. Klik "Daftar Sekarang" → enroll ke course
3. Auto redirect ke course player dengan konten pertama
4. User belajar: baca module, tonton video, kerjakan quiz
5. Tandai selesai untuk module/video, quiz auto-complete jika skor >= 70%
6. Progress percentage update otomatis
7. Saat 100% selesai → dapat certificate (future feature)

## Navigasi Course Player:

- **Sidebar**: Daftar semua konten dengan icon berbeda:
  - 📄 Module (hijau)
  - ▶️ Video (orange)  
  - 📝 Quiz (biru)
- **Main Content**: Dynamic based on type:
  - Module: Rich text content
  - Video: Video player placeholder
  - Quiz: Question list dengan radio buttons
- **Navigation**: Previous/Next buttons
- **Actions**: Mark Complete, Submit Quiz

## Route Names:

```php
courses.index          // GET /courses
courses.enroll         // POST /courses/{id}/enroll
courses.show           // GET /courses/{id}
course-contents.show   // GET /courses/{courseId}/content/{contentId}
course-contents.complete       // POST /courses/{courseId}/content/{contentId}/complete
course-contents.submit-quiz    // POST /courses/{courseId}/content/{contentId}/submit-quiz
```

## Models & Relationships:

```php
Course
  - hasMany(CourseContent)
  - hasMany(CourseEnrollment)
  
CourseContent
  - belongsTo(Course)
  - hasMany(CourseContentProgress)
  - hasMany(CourseQuizQuestion) // jika type = 'quiz'
  
CourseEnrollment
  - belongsTo(User)
  - belongsTo(Course)
  - method: updateProgress() // auto calculate dari completed contents
  
CourseContentProgress
  - belongsTo(User)
  - belongsTo(CourseContent)
```

## Tips Development:

1. Untuk add course baru, gunakan seeder atau buat manual di database
2. Content type harus: 'module', 'video', atau 'quiz'
3. Order field penting untuk urutan konten di sidebar
4. Quiz auto-pass jika score >= 70%
5. Progress dihitung dari: (completed_contents / total_contents) * 100

## Future Enhancements:

- [ ] Certificate generation setelah course selesai
- [ ] Course rating & review
- [ ] Discussion forum per course
- [ ] Course preview video
- [ ] Downloadable resources
- [ ] Course bundle/package
- [ ] Instructor profile
- [ ] Live session integration

---

## Asset URLs Used in Project

### 📸 Unsplash Images (Course Thumbnails & Content)

**Landing Page:**
- Hero Image: `https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=1920&h=1080&fit=crop`
- About Section: `https://images.unsplash.com/photo-1530836369250-ef72a3f5cda8?w=800&h=600&fit=crop`
- Reason 1 (Education): `https://images.unsplash.com/photo-1509062522246-3755977927d7?w=400&h=300&fit=crop`
- Reason 2 (Expert): `https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&h=300&fit=crop`
- Reason 3 (Certificate): `https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=400&h=300&fit=crop`

**Course Thumbnails:**
- Composting Course: `https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=800&h=600&fit=crop`
- Biogas Production: `https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?w=800&h=600&fit=crop`
- Vermicompost: `https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=800&h=600&fit=crop`
- Advanced Waste: `https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=800&h=600&fit=crop`
- Bokashi Method: `https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=800&h=600&fit=crop`
- Urban Farming: `https://images.unsplash.com/photo-1523348837708-15d4a09cfac2?w=800&h=600&fit=crop`

**Module Images:**
- Module Intro 1: `https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=1200&h=800&fit=crop`
- Module Intro 2: `https://images.unsplash.com/photo-1530836369250-ef72a3f5cda8?w=1200&h=800&fit=crop`
- Module Advanced 1: `https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=1200&h=800&fit=crop`
- Module Advanced 2: `https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?w=1200&h=800&fit=crop`

**Video Thumbnails:**
- Video 1 (Composting): `https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=1920&h=1080&fit=crop`
- Video 2 (Biogas): `https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?w=1920&h=1080&fit=crop`
- Video 3 (Vermicompost): `https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=1920&h=1080&fit=crop`

**Quiz/Test Images:**
- Quiz Background: `https://images.unsplash.com/photo-1606326608606-aa0b62935f2b?w=1200&h=800&fit=crop`

**Profile/User Images:**
- Default Avatar: `https://ui-avatars.com/api/?name=[UserName]&background=random`
- Achievement Badge: `https://images.unsplash.com/photo-1567427017947-545c5f8d16ad?w=400&h=400&fit=crop`

### 🎨 Inline SVG Icons Used

**Navigation & UI:**
- Home Icon (House)
- Book Icon (Education/Course)
- Play Icon (Video)
- Quiz Icon (Clipboard with checkmark)
- User Icon (Profile)
- Bell Icon (Notifications)
- Search Icon (Magnifying glass)
- Menu Icon (Hamburger/Bars)
- Close Icon (X)
- Checkmark Icon (Success)
- Arrow Icons (Left/Right/Up/Down)
- Calendar Icon (Date)
- Clock Icon (Duration)
- Star Icon (Rating)
- Heart Icon (Favorite)
- Share Icon (Share)
- Download Icon (Download)
- Upload Icon (Upload)
- Edit Icon (Pencil)
- Delete Icon (Trash)
- Settings Icon (Gear)
- Logout Icon (Arrow exit)

**Status Icons:**
- Success (Check circle - green)
- Error (X circle - red)
- Warning (Exclamation triangle - yellow)
- Info (Info circle - blue)
- Loading (Spinner animation)

**Content Type Icons:**
- Module Icon (Document/File)
- Video Icon (Play button)
- Quiz Icon (Question mark/clipboard)
- Certificate Icon (Award badge)

### 🔤 Fonts

**Primary Font:**
- Inter (Google Fonts): `https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap`

**Fallback:**
- System fonts: `system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif`

### 📦 External Libraries (CDN/NPM)

**CSS Frameworks:**
- Tailwind CSS: Via PostCSS (configured in `tailwind.config.js`)

**JavaScript Libraries:**
- React 18: `^18.3.1` (NPM)
- React DOM: `^18.3.1` (NPM)
- Inertia.js: `^2.0.0` (NPM)
- Axios: `^1.7.7` (NPM)

**Bundler:**
- Vite: `^5.0.0` (NPM)
- Laravel Vite Plugin: `^1.0` (NPM)

**Development:**
- Tailwind CSS: `^3.4.1` (NPM)
- PostCSS: `^8.4.47` (NPM)
- Autoprefixer: `^10.4.20` (NPM)

### 🌐 Total External Assets:
- **48+** Unsplash image URLs
- **30+** Inline SVG icons
- **1** Google Font (Inter)
- **8+** NPM packages

### 📝 Notes:
- All Unsplash images are free to use (Unsplash License)
- SVG icons are inline (no external dependency)
- Fonts loaded from Google Fonts CDN
- All NPM packages installed via `package.json`
- For production: Download and host images locally in `storage/app/public/`
