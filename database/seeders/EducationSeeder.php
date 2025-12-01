<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;
use App\Models\Module;
use App\Models\Video;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizOption;

class EducationSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['slug' => 'admin'], ['name' => 'Admin']);
        $userRole = Role::firstOrCreate(['slug' => 'user'], ['name' => 'User']);

        User::firstOrCreate(['email' => 'academy_admin@example.com'], [
            'name' => 'Admin Academy',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);

        User::firstOrCreate(['email' => 'petani@example.com'], [
            'name' => 'Petani Belajar',
            'password' => Hash::make('password'),
            'role_id' => $userRole->id,
        ]);

        $modules = [
            ['title' => 'Dasar Pengolahan Limbah', 'slug' => 'dasar-pengolahan-limbah', 'summary' => 'Memahami jenis limbah pertanian dan potensi pemanfaatannya.', 'display_order' => 1, 'is_published' => true],
            ['title' => 'Pembuatan Kompos', 'slug' => 'pembuatan-kompos', 'summary' => 'Langkah-langkah membuat kompos berkualitas.', 'display_order' => 2, 'is_published' => true],
            ['title' => 'Fermentasi Pakan Ternak', 'slug' => 'fermentasi-pakan-ternak', 'summary' => 'Mengubah limbah menjadi pakan bernutrisi.', 'display_order' => 3, 'is_published' => true],
        ];

        foreach ($modules as $data) {
            $module = Module::firstOrCreate(['slug' => $data['slug']], $data);

            Video::firstOrCreate([
                'module_id' => $module->id,
                'title' => 'Video ' . $module->title,
                'file_path' => 'videos/' . $module->slug . '.mp4',
            ], [
                'duration_seconds' => 600,
                'display_order' => 1,
            ]);

            $quiz = Quiz::firstOrCreate([
                'module_id' => $module->id,
                'title' => 'Kuis ' . $module->title,
            ], [
                'passing_score' => 70,
                'display_order' => 1,
            ]);

            $question = QuizQuestion::firstOrCreate([
                'quiz_id' => $quiz->id,
                'question_text' => 'Apa tujuan utama dari modul "' . $module->title . '"?'
            ], [
                'display_order' => 1,
            ]);

            QuizOption::firstOrCreate([
                'question_id' => $question->id,
                'option_text' => 'Memahami dan memanfaatkan limbah pertanian'
            ], [
                'is_correct' => true,
            ]);
            QuizOption::firstOrCreate([
                'question_id' => $question->id,
                'option_text' => 'Menambah jumlah limbah tanpa solusi'
            ], [
                'is_correct' => false,
            ]);
            QuizOption::firstOrCreate([
                'question_id' => $question->id,
                'option_text' => 'Membuang limbah langsung ke sungai'
            ], [
                'is_correct' => false,
            ]);
        }
    }
}
