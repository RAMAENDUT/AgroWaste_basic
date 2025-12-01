<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\CourseContent;
use App\Models\CourseQuizQuestion;
use App\Models\CourseQuizOption;

class CourseContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = Course::all();

        foreach ($courses as $course) {
            // Delete existing contents for this course
            CourseContent::where('course_id', $course->id)->delete();

            // Create Module Content 1
            $module1 = CourseContent::create([
                'course_id' => $course->id,
                'type' => 'module',
                'title' => 'Materi Pengantar',
                'description' => 'Pengenalan dasar tentang topik ini',
                'content' => '<h2><strong>Macam-macam jenis ternak</strong></h2>
                
                <div style="margin: 20px 0;">
                    <h3>1. Ternak Ayam</h3>
                    <img src="/images/ayam.png" alt="Ayam" style="width: 100%; max-width: 450px; border-radius: 8px; margin: 10px 0;">
                </div>
                
                <div style="margin: 20px 0;">
                    <h3>2. Ternak Kuda</h3>
                    <img src="/images/kuda.png" alt="Kuda" style="width: 100%; max-width: 600px; border-radius: 8px; margin: 10px 0;">
                </div>',
                'order' => 1,
                'duration_seconds' => 600,
                'is_active' => true,
            ]);

            // Create Video Content
            $video = CourseContent::create([
                'course_id' => $course->id,
                'type' => 'video',
                'title' => 'Video Tutorial',
                'description' => 'Penjelasan melalui video pembelajaran',
                'video_url' => '/video/videoplayback.mp4',
                'order' => 2,
                'duration_seconds' => 600,
                'is_active' => true,
            ]);

            // Create Quiz Content
            $quiz = CourseContent::create([
                'course_id' => $course->id,
                'type' => 'quiz',
                'title' => 'Quiz Evaluasi',
                'description' => 'Uji pemahaman Anda tentang materi',
                'order' => 3,
                'duration_seconds' => 300,
                'is_active' => true,
            ]);

            // Create Quiz Question
            $question = CourseQuizQuestion::create([
                'course_content_id' => $quiz->id,
                'question' => 'Ini contoh kan bang?',
                'order' => 1,
            ]);

            // Create Quiz Options
            CourseQuizOption::create([
                'course_quiz_question_id' => $question->id,
                'option_text' => 'A. mang eak?',
                'is_correct' => false,
                'order' => 1,
            ]);

            CourseQuizOption::create([
                'course_quiz_question_id' => $question->id,
                'option_text' => 'B. iya kali',
                'is_correct' => false,
                'order' => 2,
            ]);

            CourseQuizOption::create([
                'course_quiz_question_id' => $question->id,
                'option_text' => 'C. saya suka nasi goreng',
                'is_correct' => false,
                'order' => 3,
            ]);

            CourseQuizOption::create([
                'course_quiz_question_id' => $question->id,
                'option_text' => 'D. Hidup Ismet',
                'is_correct' => true,
                'order' => 4,
            ]);
        }
    }
}
