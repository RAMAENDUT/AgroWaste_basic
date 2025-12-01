<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\CourseModule;
use App\Models\Exercise;
use App\Models\ExerciseQuestion;
use App\Models\ExerciseOption;

class CoursesSeeder extends Seeder
{
    public function run(): void
    {
        // Course 1: Pengenalan Limbah Pertanian
        $course1 = Course::create([
            'title' => 'Pengenalan Limbah Pertanian',
            'slug' => 'pengenalan-limbah-pertanian',
            'description' => 'Pelajari dasar-dasar limbah pertanian, jenis-jenisnya, dan dampaknya terhadap lingkungan.',
            'thumbnail' => '/images/courses/course1.jpg',
            'duration_minutes' => 120,
            'level' => 'pemula',
            'display_order' => 1,
            'is_published' => true,
        ]);

        // Module 1.1 - Content
        $module1_1 = CourseModule::create([
            'course_id' => $course1->id,
            'title' => 'Apa itu Limbah Pertanian?',
            'description' => 'Memahami definisi dan klasifikasi limbah pertanian',
            'type' => 'content',
            'content_text' => '<h2>Definisi Limbah Pertanian</h2><p>Limbah pertanian adalah sisa atau hasil sampingan dari kegiatan pertanian yang tidak digunakan lagi. Limbah ini dapat berasal dari tanaman, hewan, atau proses pengolahan hasil pertanian.</p><h3>Jenis-jenis Limbah Pertanian:</h3><ul><li><strong>Limbah Organik:</strong> Jerami, sekam padi, tongkol jagung, kulit buah</li><li><strong>Limbah Anorganik:</strong> Plastik mulsa, kantong pupuk bekas</li><li><strong>Limbah Cair:</strong> Air cucian hasil panen, sisa pestisida</li></ul><p>Pengelolaan limbah pertanian yang baik dapat mengurangi dampak negatif terhadap lingkungan dan bahkan menghasilkan nilai ekonomi tambahan.</p>',
            'duration_seconds' => 600,
            'display_order' => 1,
        ]);

        // Module 1.2 - Video
        CourseModule::create([
            'course_id' => $course1->id,
            'title' => 'Dampak Limbah Pertanian terhadap Lingkungan',
            'description' => 'Video penjelasan tentang dampak limbah pertanian',
            'type' => 'video',
            'video_path' => '/videos/dampak-limbah.mp4',
            'duration_seconds' => 900,
            'display_order' => 2,
        ]);

        // Module 1.3 - Exercise
        $module1_3 = CourseModule::create([
            'course_id' => $course1->id,
            'title' => 'Kuis: Pengenalan Limbah Pertanian',
            'description' => 'Uji pemahaman Anda tentang limbah pertanian',
            'type' => 'exercise',
            'duration_seconds' => 600,
            'display_order' => 3,
        ]);

        $exercise1 = Exercise::create([
            'course_module_id' => $module1_3->id,
            'title' => 'Kuis Pengenalan Limbah Pertanian',
            'passing_score' => 70,
        ]);

        $question1 = ExerciseQuestion::create([
            'exercise_id' => $exercise1->id,
            'question_text' => 'Apa yang dimaksud dengan limbah pertanian?',
            'explanation' => 'Limbah pertanian adalah sisa atau hasil sampingan dari kegiatan pertanian yang tidak digunakan lagi.',
            'display_order' => 1,
        ]);

        ExerciseOption::create(['question_id' => $question1->id, 'option_text' => 'Hasil panen yang berkualitas baik', 'is_correct' => false]);
        ExerciseOption::create(['question_id' => $question1->id, 'option_text' => 'Sisa atau hasil sampingan dari kegiatan pertanian', 'is_correct' => true]);
        ExerciseOption::create(['question_id' => $question1->id, 'option_text' => 'Pupuk organik untuk tanaman', 'is_correct' => false]);
        ExerciseOption::create(['question_id' => $question1->id, 'option_text' => 'Alat pertanian yang rusak', 'is_correct' => false]);

        $question2 = ExerciseQuestion::create([
            'exercise_id' => $exercise1->id,
            'question_text' => 'Manakah yang termasuk limbah organik pertanian?',
            'explanation' => 'Jerami, sekam padi, dan tongkol jagung adalah contoh limbah organik pertanian.',
            'display_order' => 2,
        ]);

        ExerciseOption::create(['question_id' => $question2->id, 'option_text' => 'Plastik mulsa', 'is_correct' => false]);
        ExerciseOption::create(['question_id' => $question2->id, 'option_text' => 'Jerami dan sekam padi', 'is_correct' => true]);
        ExerciseOption::create(['question_id' => $question2->id, 'option_text' => 'Kantong pupuk bekas', 'is_correct' => false]);
        ExerciseOption::create(['question_id' => $question2->id, 'option_text' => 'Botol pestisida', 'is_correct' => false]);

        // Course 2: Pengolahan Limbah Organik
        $course2 = Course::create([
            'title' => 'Pengolahan Limbah Organik',
            'slug' => 'pengolahan-limbah-organik',
            'description' => 'Teknik dan metode pengolahan limbah organik pertanian menjadi produk bernilai ekonomi.',
            'thumbnail' => '/images/courses/course2.jpg',
            'duration_minutes' => 180,
            'level' => 'menengah',
            'display_order' => 2,
            'is_published' => true,
        ]);

        // Module 2.1 - Content
        CourseModule::create([
            'course_id' => $course2->id,
            'title' => 'Metode Komposting',
            'description' => 'Cara membuat kompos dari limbah organik',
            'type' => 'content',
            'content_text' => '<h2>Komposting: Mengubah Limbah Menjadi Pupuk</h2><p>Komposting adalah proses penguraian bahan organik menjadi kompos yang kaya nutrisi. Proses ini melibatkan mikroorganisme yang menguraikan bahan organik dalam kondisi aerobik.</p><h3>Langkah-langkah Komposting:</h3><ol><li>Kumpulkan limbah organik (jerami, dedaunan, sisa sayuran)</li><li>Cacah bahan menjadi potongan kecil</li><li>Campur dengan starter mikroba</li><li>Atur kelembaban (50-60%)</li><li>Balik kompos setiap 3-4 hari</li><li>Tunggu 3-4 minggu hingga matang</li></ol><p>Kompos yang baik berwarna coklat kehitaman, berbau tanah, dan memiliki tekstur gembur.</p>',
            'duration_seconds' => 900,
            'display_order' => 1,
        ]);

        // Module 2.2 - Video
        CourseModule::create([
            'course_id' => $course2->id,
            'title' => 'Tutorial Membuat Kompos',
            'description' => 'Video praktik pembuatan kompos dari limbah jerami',
            'type' => 'video',
            'video_path' => '/videos/tutorial-kompos.mp4',
            'duration_seconds' => 1200,
            'display_order' => 2,
        ]);

        // Course 3: Biogas dari Limbah Ternak
        $course3 = Course::create([
            'title' => 'Biogas dari Limbah Ternak',
            'slug' => 'biogas-dari-limbah-ternak',
            'description' => 'Teknologi pembuatan biogas dari kotoran ternak sebagai energi alternatif.',
            'thumbnail' => '/images/courses/course3.jpg',
            'duration_minutes' => 240,
            'level' => 'lanjutan',
            'display_order' => 3,
            'is_published' => true,
        ]);

        // Module 3.1 - Content
        CourseModule::create([
            'course_id' => $course3->id,
            'title' => 'Prinsip Kerja Biogas',
            'description' => 'Memahami proses anaerobik dalam produksi biogas',
            'type' => 'content',
            'content_text' => '<h2>Biogas: Energi dari Limbah Ternak</h2><p>Biogas adalah gas yang dihasilkan dari proses penguraian bahan organik oleh bakteri dalam kondisi anaerobik (tanpa oksigen). Gas ini terutama terdiri dari metana (CH4) dan karbon dioksida (CO2).</p><h3>Keuntungan Biogas:</h3><ul><li>Sumber energi terbarukan</li><li>Mengurangi emisi gas rumah kaca</li><li>Menghasilkan pupuk organik (slurry)</li><li>Mengatasi masalah limbah ternak</li></ul><h3>Komponen Instalasi Biogas:</h3><ol><li>Digester (reaktor utama)</li><li>Inlet (tempat masuk bahan)</li><li>Outlet (tempat keluar slurry)</li><li>Gas holder (penampung gas)</li><li>Pipa distribusi gas</li></ol>',
            'duration_seconds' => 1200,
            'display_order' => 1,
        ]);

        // Module 3.2 - Video
        CourseModule::create([
            'course_id' => $course3->id,
            'title' => 'Instalasi Biogas Sederhana',
            'description' => 'Panduan membangun instalasi biogas skala rumah tangga',
            'type' => 'video',
            'video_path' => '/videos/instalasi-biogas.mp4',
            'duration_seconds' => 1800,
            'display_order' => 2,
        ]);

        // Module 3.3 - Exercise
        $module3_3 = CourseModule::create([
            'course_id' => $course3->id,
            'title' => 'Evaluasi: Teknologi Biogas',
            'description' => 'Uji pemahaman tentang proses dan instalasi biogas',
            'type' => 'exercise',
            'duration_seconds' => 900,
            'display_order' => 3,
        ]);

        $exercise3 = Exercise::create([
            'course_module_id' => $module3_3->id,
            'title' => 'Evaluasi Teknologi Biogas',
            'passing_score' => 75,
        ]);

        $question3_1 = ExerciseQuestion::create([
            'exercise_id' => $exercise3->id,
            'question_text' => 'Apa gas utama yang dihasilkan dalam proses biogas?',
            'explanation' => 'Metana (CH4) adalah komponen utama biogas yang dapat digunakan sebagai bahan bakar.',
            'display_order' => 1,
        ]);

        ExerciseOption::create(['question_id' => $question3_1->id, 'option_text' => 'Oksigen (O2)', 'is_correct' => false]);
        ExerciseOption::create(['question_id' => $question3_1->id, 'option_text' => 'Metana (CH4)', 'is_correct' => true]);
        ExerciseOption::create(['question_id' => $question3_1->id, 'option_text' => 'Nitrogen (N2)', 'is_correct' => false]);
        ExerciseOption::create(['question_id' => $question3_1->id, 'option_text' => 'Hidrogen (H2)', 'is_correct' => false]);
    }
}
