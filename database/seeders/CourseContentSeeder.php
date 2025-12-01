<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\CourseModule;
use App\Models\Exercise;
use App\Models\ExerciseQuestion;
use App\Models\ExerciseOption;

class CourseContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = Course::all();

        foreach ($courses as $course) {
            // Delete existing modules for this course
            CourseModule::where('course_id', $course->id)->delete();

            // Create Module Content 1
            $module1 = CourseModule::create([
                'course_id' => $course->id,
                'type' => 'content',
                'title' => 'Materi Pengantar',
                'description' => 'Pengenalan dasar tentang topik ini',
                'content_text' => '<h2><strong>Macam-macam jenis ternak</strong></h2>
                
                <div style="margin: 20px 0;">
                    <h3>1. Ternak Ayam</h3>
                    <img src="/images/ayam.png" alt="Ayam" style="width: 100%; max-width: 450px; border-radius: 8px; margin: 10px 0;">
                </div>
                
                <div style="margin: 20px 0;">
                    <h3>2. Ternak Kuda</h3>
                    <img src="/images/kuda.png" alt="Kuda" style="width: 100%; max-width: 600px; border-radius: 8px; margin: 10px 0;">
                </div>',
                'display_order' => 1,
                'duration_seconds' => 600,
            ]);

            // Create Video Module
            $video = CourseModule::create([
                'course_id' => $course->id,
                'type' => 'video',
                'title' => 'Video Tutorial',
                'description' => 'Penjelasan melalui video pembelajaran',
                'video_path' => '/video/videoplayback.mp4',
                'display_order' => 2,
                'duration_seconds' => 600,
            ]);

            // Create Exercise Module
            $exerciseModule = CourseModule::create([
                'course_id' => $course->id,
                'type' => 'exercise',
                'title' => 'Latihan Evaluasi',
                'description' => 'Uji pemahaman Anda tentang materi',
                'display_order' => 3,
                'duration_seconds' => 300,
            ]);

            // Create Exercise
            $exercise = Exercise::create([
                'course_module_id' => $exerciseModule->id,
                'title' => 'Quiz Evaluasi',
                'passing_score' => 70,
            ]);

            // Create Exercise Question
            $question = ExerciseQuestion::create([
                'exercise_id' => $exercise->id,
                'question_text' => 'Ini contoh kan bang?',
                'display_order' => 1,
            ]);

            // Create Exercise Options
            ExerciseOption::create([
                'question_id' => $question->id,
                'option_text' => 'A. mang eak?',
                'is_correct' => false,
            ]);

            ExerciseOption::create([
                'question_id' => $question->id,
                'option_text' => 'B. iya kali',
                'is_correct' => false,
            ]);

            ExerciseOption::create([
                'question_id' => $question->id,
                'option_text' => 'C. saya suka nasi goreng',
                'is_correct' => false,
            ]);

            ExerciseOption::create([
                'question_id' => $question->id,
                'option_text' => 'D. Hidup Ismet',
                'is_correct' => true,
            ]);
        }
    }
}
