<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizOption;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        // Quiz 1: Pengenalan Limbah Pertanian
        $quiz1 = Quiz::create([
            'module_id' => 1,
            'title' => 'Kuis: Pengenalan Limbah Pertanian',
            'description' => 'Uji pemahaman Anda tentang limbah pertanian',
            'passing_score' => 70,
            'duration_minutes' => 15,
            'is_active' => true,
        ]);

        $q1 = QuizQuestion::create([
            'quiz_id' => $quiz1->id,
            'question' => 'Apa yang dimaksud dengan limbah pertanian?',
            'points' => 10,
            'order' => 1,
        ]);
        QuizOption::create(['question_id' => $q1->id, 'option_text' => 'Sisa hasil kegiatan pertanian yang tidak dimanfaatkan', 'is_correct' => true]);
        QuizOption::create(['question_id' => $q1->id, 'option_text' => 'Pupuk yang digunakan untuk pertanian', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q1->id, 'option_text' => 'Hasil panen yang berkualitas baik', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q1->id, 'option_text' => 'Alat-alat pertanian yang rusak', 'is_correct' => false]);

        $q2 = QuizQuestion::create([
            'quiz_id' => $quiz1->id,
            'question' => 'Manakah yang termasuk jenis limbah pertanian?',
            'points' => 10,
            'order' => 2,
        ]);
        QuizOption::create(['question_id' => $q2->id, 'option_text' => 'Jerami padi', 'is_correct' => true]);
        QuizOption::create(['question_id' => $q2->id, 'option_text' => 'Pupuk NPK', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q2->id, 'option_text' => 'Benih jagung', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q2->id, 'option_text' => 'Pestisida cair', 'is_correct' => false]);

        $q3 = QuizQuestion::create([
            'quiz_id' => $quiz1->id,
            'question' => 'Apa manfaat utama mengolah limbah pertanian?',
            'points' => 10,
            'order' => 3,
        ]);
        QuizOption::create(['question_id' => $q3->id, 'option_text' => 'Mengurangi pencemaran dan menghasilkan produk bernilai ekonomis', 'is_correct' => true]);
        QuizOption::create(['question_id' => $q3->id, 'option_text' => 'Menambah jumlah limbah', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q3->id, 'option_text' => 'Mengurangi hasil panen', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q3->id, 'option_text' => 'Mempercepat proses pembusukan', 'is_correct' => false]);

        $q4 = QuizQuestion::create([
            'quiz_id' => $quiz1->id,
            'question' => 'Produk apa yang dapat dihasilkan dari limbah tongkol jagung?',
            'points' => 10,
            'order' => 4,
        ]);
        QuizOption::create(['question_id' => $q4->id, 'option_text' => 'Media tanam jamur dan pakan ternak', 'is_correct' => true]);
        QuizOption::create(['question_id' => $q4->id, 'option_text' => 'Beras organik', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q4->id, 'option_text' => 'Minyak goreng', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q4->id, 'option_text' => 'Gula aren', 'is_correct' => false]);

        $q5 = QuizQuestion::create([
            'quiz_id' => $quiz1->id,
            'question' => 'Mengapa limbah pertanian perlu diolah dengan baik?',
            'points' => 10,
            'order' => 5,
        ]);
        QuizOption::create(['question_id' => $q5->id, 'option_text' => 'Untuk mengurangi pencemaran dan meningkatkan pendapatan petani', 'is_correct' => true]);
        QuizOption::create(['question_id' => $q5->id, 'option_text' => 'Agar tanah menjadi lebih keras', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q5->id, 'option_text' => 'Supaya musim hujan cepat datang', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q5->id, 'option_text' => 'Untuk menambah hama tanaman', 'is_correct' => false]);

        // Quiz 2: Pembuatan Pupuk Kompos
        $quiz2 = Quiz::create([
            'module_id' => 2,
            'title' => 'Kuis: Pembuatan Pupuk Kompos',
            'description' => 'Uji pemahaman Anda tentang pembuatan pupuk kompos',
            'passing_score' => 70,
            'duration_minutes' => 15,
            'is_active' => true,
        ]);

        $q6 = QuizQuestion::create([
            'quiz_id' => $quiz2->id,
            'question' => 'Apa fungsi EM4 dalam pembuatan kompos?',
            'points' => 10,
            'order' => 1,
        ]);
        QuizOption::create(['question_id' => $q6->id, 'option_text' => 'Sebagai aktivator untuk mempercepat penguraian', 'is_correct' => true]);
        QuizOption::create(['question_id' => $q6->id, 'option_text' => 'Sebagai pewarna kompos', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q6->id, 'option_text' => 'Sebagai penambah berat kompos', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q6->id, 'option_text' => 'Sebagai pengawet kompos', 'is_correct' => false]);

        $q7 = QuizQuestion::create([
            'quiz_id' => $quiz2->id,
            'question' => 'Berapa lama waktu yang diperlukan untuk proses pengomposan?',
            'points' => 10,
            'order' => 2,
        ]);
        QuizOption::create(['question_id' => $q7->id, 'option_text' => '3-4 minggu', 'is_correct' => true]);
        QuizOption::create(['question_id' => $q7->id, 'option_text' => '1-2 hari', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q7->id, 'option_text' => '6-12 bulan', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q7->id, 'option_text' => '1 tahun', 'is_correct' => false]);

        $q8 = QuizQuestion::create([
            'quiz_id' => $quiz2->id,
            'question' => 'Berapa persen kelembaban ideal untuk pembuatan kompos?',
            'points' => 10,
            'order' => 3,
        ]);
        QuizOption::create(['question_id' => $q8->id, 'option_text' => '50-60%', 'is_correct' => true]);
        QuizOption::create(['question_id' => $q8->id, 'option_text' => '10-20%', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q8->id, 'option_text' => '80-90%', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q8->id, 'option_text' => '100%', 'is_correct' => false]);

        $q9 = QuizQuestion::create([
            'quiz_id' => $quiz2->id,
            'question' => 'Apa ciri-ciri kompos yang sudah matang?',
            'points' => 10,
            'order' => 4,
        ]);
        QuizOption::create(['question_id' => $q9->id, 'option_text' => 'Berwarna coklat kehitaman dan berbau tanah', 'is_correct' => true]);
        QuizOption::create(['question_id' => $q9->id, 'option_text' => 'Berwarna putih dan berbau busuk', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q9->id, 'option_text' => 'Berwarna hijau dan berbau segar', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q9->id, 'option_text' => 'Masih terlihat seperti jerami utuh', 'is_correct' => false]);

        $q10 = QuizQuestion::create([
            'quiz_id' => $quiz2->id,
            'question' => 'Mengapa tumpukan kompos perlu dibalik setiap 3-4 hari?',
            'points' => 10,
            'order' => 5,
        ]);
        QuizOption::create(['question_id' => $q10->id, 'option_text' => 'Untuk memberikan aerasi dan mempercepat penguraian', 'is_correct' => true]);
        QuizOption::create(['question_id' => $q10->id, 'option_text' => 'Agar kompos lebih berat', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q10->id, 'option_text' => 'Supaya kompos tidak dicuri', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q10->id, 'option_text' => 'Untuk menambah volume kompos', 'is_correct' => false]);

        // Quiz 3: Pengolahan Pakan Ternak
        $quiz3 = Quiz::create([
            'module_id' => 3,
            'title' => 'Kuis: Pengolahan Pakan Ternak',
            'description' => 'Uji pemahaman Anda tentang pengolahan pakan ternak',
            'passing_score' => 70,
            'duration_minutes' => 15,
            'is_active' => true,
        ]);

        $q11 = QuizQuestion::create([
            'quiz_id' => $quiz3->id,
            'question' => 'Apa keuntungan utama pakan fermentasi dibanding pakan biasa?',
            'points' => 10,
            'order' => 1,
        ]);
        QuizOption::create(['question_id' => $q11->id, 'option_text' => 'Nilai gizi lebih tinggi dan mudah dicerna', 'is_correct' => true]);
        QuizOption::create(['question_id' => $q11->id, 'option_text' => 'Lebih mahal harganya', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q11->id, 'option_text' => 'Membuat ternak lebih agresif', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q11->id, 'option_text' => 'Mengurangi nafsu makan ternak', 'is_correct' => false]);

        $q12 = QuizQuestion::create([
            'quiz_id' => $quiz3->id,
            'question' => 'Berapa lama waktu fermentasi pakan yang ideal?',
            'points' => 10,
            'order' => 2,
        ]);
        QuizOption::create(['question_id' => $q12->id, 'option_text' => '7-14 hari', 'is_correct' => true]);
        QuizOption::create(['question_id' => $q12->id, 'option_text' => '1-2 jam', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q12->id, 'option_text' => '1 bulan', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q12->id, 'option_text' => '6 bulan', 'is_correct' => false]);

        $q13 = QuizQuestion::create([
            'quiz_id' => $quiz3->id,
            'question' => 'Apa fungsi molases dalam pembuatan pakan fermentasi?',
            'points' => 10,
            'order' => 3,
        ]);
        QuizOption::create(['question_id' => $q13->id, 'option_text' => 'Sebagai sumber energi untuk mikroorganisme', 'is_correct' => true]);
        QuizOption::create(['question_id' => $q13->id, 'option_text' => 'Sebagai pengeras pakan', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q13->id, 'option_text' => 'Sebagai pewarna pakan', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q13->id, 'option_text' => 'Untuk membuat pakan lebih berat', 'is_correct' => false]);

        $q14 = QuizQuestion::create([
            'quiz_id' => $quiz3->id,
            'question' => 'Apa ciri pakan fermentasi yang berhasil?',
            'points' => 10,
            'order' => 4,
        ]);
        QuizOption::create(['question_id' => $q14->id, 'option_text' => 'Berbau harum khas fermentasi (asam segar)', 'is_correct' => true]);
        QuizOption::create(['question_id' => $q14->id, 'option_text' => 'Berbau busuk menyengat', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q14->id, 'option_text' => 'Berwarna hitam pekat', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q14->id, 'option_text' => 'Bertekstur sangat keras', 'is_correct' => false]);

        $q15 = QuizQuestion::create([
            'quiz_id' => $quiz3->id,
            'question' => 'Berapa persen penghematan biaya pakan dengan menggunakan pakan fermentasi?',
            'points' => 10,
            'order' => 5,
        ]);
        QuizOption::create(['question_id' => $q15->id, 'option_text' => '30-40%', 'is_correct' => true]);
        QuizOption::create(['question_id' => $q15->id, 'option_text' => '5-10%', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q15->id, 'option_text' => '70-80%', 'is_correct' => false]);
        QuizOption::create(['question_id' => $q15->id, 'option_text' => 'Tidak ada penghematan', 'is_correct' => false]);
    }
}
