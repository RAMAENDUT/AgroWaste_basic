<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\CourseContent;
use App\Models\CourseQuizQuestion;
use App\Models\CourseQuizOption;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // Course 1: Pengenalan Komposting
        $course1 = Course::create([
            'title' => 'Pengenalan Komposting dari Limbah Pertanian',
            'description' => 'Pelajari dasar-dasar pembuatan kompos dari limbah pertanian untuk meningkatkan kesuburan tanah secara organik.',
            'thumbnail' => 'https://images.unsplash.com/photo-1530836369250-ef72a3f5cda8?w=800',
            'level' => 'pemula',
            'duration_hours' => 3,
            'order' => 1,
            'is_active' => true,
        ]);

        // Module 1
        CourseContent::create([
            'course_id' => $course1->id,
            'type' => 'module',
            'title' => 'Apa itu Komposting?',
            'description' => 'Memahami konsep dasar komposting dan manfaatnya',
            'content' => '<h2>Pengertian Komposting</h2><p>Komposting adalah proses penguraian bahan organik secara alami oleh mikroorganisme dalam kondisi terkontrol. Proses ini mengubah limbah organik menjadi kompos yang kaya nutrisi.</p><h3>Manfaat Komposting:</h3><ul><li>Mengurangi volume sampah organik</li><li>Menghasilkan pupuk organik berkualitas</li><li>Meningkatkan struktur tanah</li><li>Ramah lingkungan dan hemat biaya</li></ul><p>Kompos yang baik memiliki warna gelap, tekstur gembur, dan aroma tanah segar.</p>',
            'duration_seconds' => 600,
            'order' => 1,
            'is_active' => true,
        ]);

        // Video 1
        CourseContent::create([
            'course_id' => $course1->id,
            'type' => 'video',
            'title' => 'Tutorial Membuat Kompos Sederhana',
            'description' => 'Panduan praktis membuat kompos dari limbah pertanian',
            'video_url' => 'https://example.com/video-kompos-1.mp4',
            'duration_seconds' => 720,
            'order' => 2,
            'is_active' => true,
        ]);

        // Module 2
        CourseContent::create([
            'course_id' => $course1->id,
            'type' => 'module',
            'title' => 'Bahan-bahan untuk Komposting',
            'description' => 'Mengenal jenis-jenis bahan yang cocok untuk komposting',
            'content' => '<h2>Bahan Hijau dan Bahan Coklat</h2><p>Komposting yang sukses membutuhkan keseimbangan antara bahan hijau (nitrogen) dan bahan coklat (karbon).</p><h3>Bahan Hijau (Nitrogen):</h3><ul><li>Sisa sayuran dan buah</li><li>Rumput segar</li><li>Daun hijau</li><li>Kotoran hewan herbivora</li></ul><h3>Bahan Coklat (Karbon):</h3><ul><li>Daun kering</li><li>Jerami dan sekam padi</li><li>Serbuk gergaji</li><li>Kertas dan kardus</li></ul><p>Rasio ideal adalah 1:3 (hijau:coklat) untuk hasil terbaik.</p>',
            'duration_seconds' => 480,
            'order' => 3,
            'is_active' => true,
        ]);

        // Quiz 1
        $quiz1 = CourseContent::create([
            'course_id' => $course1->id,
            'type' => 'quiz',
            'title' => 'Kuis: Dasar-dasar Komposting',
            'description' => 'Uji pemahaman Anda tentang komposting',
            'duration_seconds' => 600,
            'order' => 4,
            'is_active' => true,
        ]);

        $q1 = CourseQuizQuestion::create([
            'course_content_id' => $quiz1->id,
            'question' => 'Apa yang dimaksud dengan komposting?',
            'order' => 1,
        ]);
        CourseQuizOption::create(['course_quiz_question_id' => $q1->id, 'option_text' => 'Proses penguraian bahan organik secara alami', 'is_correct' => true, 'order' => 1]);
        CourseQuizOption::create(['course_quiz_question_id' => $q1->id, 'option_text' => 'Proses membakar sampah', 'is_correct' => false, 'order' => 2]);
        CourseQuizOption::create(['course_quiz_question_id' => $q1->id, 'option_text' => 'Proses daur ulang plastik', 'is_correct' => false, 'order' => 3]);

        $q2 = CourseQuizQuestion::create([
            'course_content_id' => $quiz1->id,
            'question' => 'Apa rasio ideal bahan hijau dan coklat untuk komposting?',
            'order' => 2,
        ]);
        CourseQuizOption::create(['course_quiz_question_id' => $q2->id, 'option_text' => '1:1', 'is_correct' => false, 'order' => 1]);
        CourseQuizOption::create(['course_quiz_question_id' => $q2->id, 'option_text' => '1:3', 'is_correct' => true, 'order' => 2]);
        CourseQuizOption::create(['course_quiz_question_id' => $q2->id, 'option_text' => '2:1', 'is_correct' => false, 'order' => 3]);

        // Course 2: Biogas dari Limbah Organik
        $course2 = Course::create([
            'title' => 'Produksi Biogas dari Limbah Organik',
            'description' => 'Manfaatkan limbah organik untuk menghasilkan energi alternatif melalui biogas.',
            'thumbnail' => 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?w=800',
            'level' => 'menengah',
            'duration_hours' => 5,
            'order' => 2,
            'is_active' => true,
        ]);

        CourseContent::create([
            'course_id' => $course2->id,
            'type' => 'module',
            'title' => 'Pengenalan Biogas',
            'description' => 'Memahami proses pembentukan biogas',
            'content' => '<h2>Apa itu Biogas?</h2><p>Biogas adalah gas yang dihasilkan dari proses fermentasi bahan organik oleh bakteri anaerob (tanpa oksigen). Gas ini terutama terdiri dari metana (CH4) dan karbon dioksida (CO2).</p><h3>Komponen Biogas:</h3><ul><li>Metana (CH4): 50-70%</li><li>Karbon Dioksida (CO2): 30-40%</li><li>Gas lain: H2S, N2, dll</li></ul><p>Biogas dapat digunakan sebagai sumber energi untuk memasak, pemanas, dan pembangkit listrik.</p>',
            'duration_seconds' => 900,
            'order' => 1,
            'is_active' => true,
        ]);

        CourseContent::create([
            'course_id' => $course2->id,
            'type' => 'video',
            'title' => 'Cara Membuat Digester Biogas Sederhana',
            'description' => 'Tutorial praktis membuat reaktor biogas skala rumah tangga',
            'video_url' => 'https://example.com/video-biogas-1.mp4',
            'duration_seconds' => 1200,
            'order' => 2,
            'is_active' => true,
        ]);

        $quiz2 = CourseContent::create([
            'course_id' => $course2->id,
            'type' => 'quiz',
            'title' => 'Kuis: Biogas Dasar',
            'description' => 'Uji pemahaman tentang biogas',
            'duration_seconds' => 600,
            'order' => 3,
            'is_active' => true,
        ]);

        $q3 = CourseQuizQuestion::create([
            'course_content_id' => $quiz2->id,
            'question' => 'Berapa persentase metana dalam biogas?',
            'order' => 1,
        ]);
        CourseQuizOption::create(['course_quiz_question_id' => $q3->id, 'option_text' => '20-30%', 'is_correct' => false, 'order' => 1]);
        CourseQuizOption::create(['course_quiz_question_id' => $q3->id, 'option_text' => '50-70%', 'is_correct' => true, 'order' => 2]);
        CourseQuizOption::create(['course_quiz_question_id' => $q3->id, 'option_text' => '80-90%', 'is_correct' => false, 'order' => 3]);

        // Course 3: Vermikompos Lanjutan
        $course3 = Course::create([
            'title' => 'Teknik Vermikompos Lanjutan',
            'description' => 'Pelajari teknik pembuatan kompos menggunakan cacing tanah untuk hasil optimal.',
            'thumbnail' => 'https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=800',
            'level' => 'lanjutan',
            'duration_hours' => 6,
            'order' => 3,
            'is_active' => true,
        ]);

        CourseContent::create([
            'course_id' => $course3->id,
            'type' => 'module',
            'title' => 'Biologi Cacing Kompos',
            'description' => 'Memahami peran cacing dalam proses pengomposan',
            'content' => '<h2>Cacing Kompos (Eisenia fetida)</h2><p>Cacing tanah jenis Eisenia fetida adalah spesies terbaik untuk vermikompos karena kemampuannya mengonsumsi bahan organik dan menghasilkan kascing (vermicast) berkualitas tinggi.</p><h3>Karakteristik Cacing Kompos:</h3><ul><li>Dapat mengonsumsi setengah berat tubuhnya per hari</li><li>Berkembang biak dengan cepat</li><li>Tahan terhadap kondisi lingkungan yang bervariasi</li><li>Menghasilkan kascing kaya nutrisi</li></ul><p>Kascing mengandung NPK yang lebih tinggi dibanding kompos biasa dan memiliki mikroorganisme bermanfaat.</p>',
            'duration_seconds' => 1080,
            'order' => 1,
            'is_active' => true,
        ]);

        CourseContent::create([
            'course_id' => $course3->id,
            'type' => 'video',
            'title' => 'Setup Sistem Vermikompos Skala Komersial',
            'description' => 'Panduan lengkap membangun sistem vermikompos untuk bisnis',
            'video_url' => 'https://example.com/video-vermi-1.mp4',
            'duration_seconds' => 1500,
            'order' => 2,
            'is_active' => true,
        ]);

        CourseContent::create([
            'course_id' => $course3->id,
            'type' => 'module',
            'title' => 'Troubleshooting Vermikompos',
            'description' => 'Mengatasi masalah umum dalam vermikomposting',
            'content' => '<h2>Masalah Umum dan Solusinya</h2><h3>1. Bau Tidak Sedap</h3><p><strong>Penyebab:</strong> Terlalu banyak bahan basah, aerasi kurang<br><strong>Solusi:</strong> Tambahkan bahan kering, aduk secara berkala</p><h3>2. Cacing Mati atau Meninggalkan Wadah</h3><p><strong>Penyebab:</strong> pH tidak sesuai, terlalu panas/dingin, makanan tidak cocok<br><strong>Solusi:</strong> Sesuaikan kondisi, hindari bahan asam/pedas berlebihan</p><h3>3. Lalat Buah</h3><p><strong>Penyebab:</strong> Sisa makanan terekspos<br><strong>Solusi:</strong> Tutupi makanan dengan bedding, gunakan perangkap lalat</p>',
            'duration_seconds' => 720,
            'order' => 3,
            'is_active' => true,
        ]);

        $quiz3 = CourseContent::create([
            'course_id' => $course3->id,
            'type' => 'quiz',
            'title' => 'Kuis: Vermikompos Master',
            'description' => 'Ujian komprehensif tentang vermikomposting',
            'duration_seconds' => 900,
            'order' => 4,
            'is_active' => true,
        ]);

        $q4 = CourseQuizQuestion::create([
            'course_content_id' => $quiz3->id,
            'question' => 'Apa nama ilmiah cacing kompos yang paling umum digunakan?',
            'order' => 1,
        ]);
        CourseQuizOption::create(['course_quiz_question_id' => $q4->id, 'option_text' => 'Lumbricus terrestris', 'is_correct' => false, 'order' => 1]);
        CourseQuizOption::create(['course_quiz_question_id' => $q4->id, 'option_text' => 'Eisenia fetida', 'is_correct' => true, 'order' => 2]);
        CourseQuizOption::create(['course_quiz_question_id' => $q4->id, 'option_text' => 'Eudrilus eugeniae', 'is_correct' => false, 'order' => 3]);

        $q5 = CourseQuizQuestion::create([
            'course_content_id' => $quiz3->id,
            'question' => 'Apa yang harus dilakukan jika timbul bau tidak sedap pada wadah vermikompos?',
            'order' => 2,
        ]);
        CourseQuizOption::create(['course_quiz_question_id' => $q5->id, 'option_text' => 'Tambahkan lebih banyak air', 'is_correct' => false, 'order' => 1]);
        CourseQuizOption::create(['course_quiz_question_id' => $q5->id, 'option_text' => 'Tambahkan bahan kering dan tingkatkan aerasi', 'is_correct' => true, 'order' => 2]);
        CourseQuizOption::create(['course_quiz_question_id' => $q5->id, 'option_text' => 'Tutup rapat wadah', 'is_correct' => false, 'order' => 3]);
    }
}
