<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    public function run(): void
    {
        // Videos for Module 1: Pengenalan Limbah Pertanian
        Video::create([
            'module_id' => 1,
            'title' => 'Apa Itu Limbah Pertanian?',
            'description' => 'Video pengenalan tentang berbagai jenis limbah pertanian dan potensinya',
            'video_url' => '/videos/pengenalan-limbah.mp4',
            'duration_seconds' => 480,
            'order' => 1,
            'is_active' => true,
        ]);

        Video::create([
            'module_id' => 1,
            'title' => 'Jenis-Jenis Limbah Pertanian',
            'description' => 'Mengenal berbagai jenis limbah pertanian yang dapat dimanfaatkan',
            'video_url' => '/videos/jenis-limbah.mp4',
            'duration_seconds' => 420,
            'order' => 2,
            'is_active' => true,
        ]);

        Video::create([
            'module_id' => 1,
            'title' => 'Potensi Ekonomi Limbah Pertanian',
            'description' => 'Memahami nilai ekonomis dari pengolahan limbah pertanian',
            'video_url' => '/videos/potensi-ekonomi.mp4',
            'duration_seconds' => 360,
            'order' => 3,
            'is_active' => true,
        ]);

        // Videos for Module 2: Pembuatan Pupuk Kompos
        Video::create([
            'module_id' => 2,
            'title' => 'Persiapan Bahan Kompos',
            'description' => 'Cara mempersiapkan bahan-bahan untuk pembuatan kompos',
            'video_url' => '/videos/persiapan-kompos.mp4',
            'duration_seconds' => 540,
            'order' => 1,
            'is_active' => true,
        ]);

        Video::create([
            'module_id' => 2,
            'title' => 'Proses Pengomposan',
            'description' => 'Tutorial lengkap proses pembuatan pupuk kompos',
            'video_url' => '/videos/proses-kompos.mp4',
            'duration_seconds' => 720,
            'order' => 2,
            'is_active' => true,
        ]);

        Video::create([
            'module_id' => 2,
            'title' => 'Pemanenan dan Aplikasi Kompos',
            'description' => 'Cara memanen kompos yang sudah matang dan mengaplikasikannya',
            'video_url' => '/videos/panen-kompos.mp4',
            'duration_seconds' => 420,
            'order' => 3,
            'is_active' => true,
        ]);

        // Videos for Module 3: Pengolahan Pakan Ternak
        Video::create([
            'module_id' => 3,
            'title' => 'Pengenalan Pakan Fermentasi',
            'description' => 'Memahami konsep dan manfaat pakan fermentasi',
            'video_url' => '/videos/intro-pakan.mp4',
            'duration_seconds' => 390,
            'order' => 1,
            'is_active' => true,
        ]);

        Video::create([
            'module_id' => 3,
            'title' => 'Cara Membuat Pakan Fermentasi',
            'description' => 'Tutorial step-by-step pembuatan pakan fermentasi',
            'video_url' => '/videos/cara-pakan.mp4',
            'duration_seconds' => 660,
            'order' => 2,
            'is_active' => true,
        ]);

        Video::create([
            'module_id' => 3,
            'title' => 'Pemberian Pakan ke Ternak',
            'description' => 'Cara pemberian pakan fermentasi yang tepat ke ternak',
            'video_url' => '/videos/pemberian-pakan.mp4',
            'duration_seconds' => 360,
            'order' => 3,
            'is_active' => true,
        ]);
    }
}
