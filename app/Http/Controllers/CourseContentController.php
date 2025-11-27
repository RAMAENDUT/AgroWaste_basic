<?php

namespace App\Http\Controllers;

use App\Models\CourseContent;
use App\Models\CourseContentProgress;
use App\Models\CourseEnrollment;
use App\Models\CourseQuizAttempt;
use App\Models\CourseQuizOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CourseContentController extends Controller
{
    public function show($courseId, $contentId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $content = CourseContent::with('course')->findOrFail($contentId);
        
        // Check enrollment
        $enrollment = $content->course->getEnrollmentFor(Auth::id());
        if (!$enrollment) {
            return redirect()->route('courses.index')->with('error', 'Anda belum mendaftar di course ini.');
        }

        // Get all contents
        $contents = $content->course->contents()->where('is_active', true)->orderBy('order')->get();

        // Get progress for each content
        $contentsData = [];
        foreach ($contents as $c) {
            $progress = $c->getProgressFor(Auth::id());
            
            $contentsData[] = [
                'id' => $c->id,
                'type' => $c->type,
                'title' => $c->title,
                'description' => $c->description,
                'duration_seconds' => $c->duration_seconds,
                'is_completed' => $progress ? $progress->is_completed : false,
            ];
        }

        // Auto-complete module and video content when viewed
        if (in_array($content->type, ['module', 'video'])) {
            $progressRecord = CourseContentProgress::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'course_content_id' => $content->id,
                ],
                [
                    'is_completed' => true,
                    'completed_at' => now(),
                ]
            );

            // Log activity only if newly completed
            if ($progressRecord->wasRecentlyCreated || $progressRecord->wasChanged('is_completed')) {
                $activityType = $content->type === 'module' ? 'complete_module' : 'complete_video';
                $activityTitle = $content->type === 'module' ? 'Menyelesaikan materi' : 'Menonton video';
                
                \App\Models\UserActivity::create([
                    'user_id' => Auth::id(),
                    'activity_type' => $activityType,
                    'activity_title' => $activityTitle,
                    'activity_description' => $content->title . ' - ' . $content->course->title,
                    'course_id' => $content->course_id,
                ]);
            }

            // Update enrollment progress
            $enrollment->updateProgress();
            
            // Refresh enrollment to get updated progress
            $enrollment->refresh();
        }

        // Get current content data
        $progress = $content->getProgressFor(Auth::id());
        
        $currentContent = [
            'id' => $content->id,
            'type' => $content->type,
            'title' => $content->title,
            'description' => $content->description,
            'content' => $content->content,
            'video_url' => $content->video_url,
            'duration_seconds' => $content->duration_seconds,
            'is_completed' => $progress ? $progress->is_completed : false,
        ];

        // If quiz, load questions
        if ($content->type === 'quiz') {
            $questions = $content->quizQuestions()->with('options')->get();
            $currentContent['questions'] = $questions->map(function($q) {
                return [
                    'id' => $q->id,
                    'question' => $q->question,
                    'options' => $q->options->map(function($o) {
                        return [
                            'id' => $o->id,
                            'option_text' => $o->option_text,
                        ];
                    })->toArray(),
                ];
            })->toArray();

            // Get best attempt
            $bestAttempt = CourseQuizAttempt::where('user_id', Auth::id())
                ->where('course_content_id', $content->id)
                ->orderBy('score', 'desc')
                ->first();

            $currentContent['best_attempt'] = $bestAttempt ? [
                'score' => $bestAttempt->score,
                'total_questions' => $bestAttempt->total_questions,
            ] : null;
        }

        // Get next and previous content
        $currentIndex = $contents->search(function($c) use ($content) {
            return $c->id === $content->id;
        });
        
        $nextContent = $currentIndex !== false && $currentIndex < $contents->count() - 1 
            ? $contents[$currentIndex + 1] 
            : null;
            
        $previousContent = $currentIndex !== false && $currentIndex > 0 
            ? $contents[$currentIndex - 1] 
            : null;

        return Inertia::render('Courses/Show', [
            'course' => [
                'id' => $content->course->id,
                'title' => $content->course->title,
                'description' => $content->course->description,
                'thumbnail' => $content->course->thumbnail,
                'level' => $content->course->level,
                'duration_hours' => $content->course->duration_hours,
            ],
            'contents' => $contentsData,
            'currentContent' => $currentContent,
            'nextContent' => $nextContent ? [
                'id' => $nextContent->id,
                'title' => $nextContent->title,
                'type' => $nextContent->type,
            ] : null,
            'previousContent' => $previousContent ? [
                'id' => $previousContent->id,
                'title' => $previousContent->title,
                'type' => $previousContent->type,
            ] : null,
            'enrollment' => [
                'progress_percentage' => $enrollment->progress_percentage,
                'enrolled_at' => $enrollment->enrolled_at,
            ],
        ]);
    }

    // Removed - content completion only through quiz

    public function submitQuiz(Request $request, $courseId, $contentId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $content = CourseContent::with('quizQuestions.options')->findOrFail($contentId);
        
        if ($content->type !== 'quiz') {
            return back()->with('error', 'Konten ini bukan quiz.');
        }

        $answers = $request->input('answers', []); // ['question_id' => 'option_id']
        
        $totalQuestions = $content->quizQuestions->count();
        $correctAnswers = 0;

        foreach ($content->quizQuestions as $question) {
            $selectedOptionId = $answers[$question->id] ?? null;
            
            if ($selectedOptionId) {
                $selectedOption = CourseQuizOption::find($selectedOptionId);
                if ($selectedOption && $selectedOption->is_correct) {
                    $correctAnswers++;
                }
            }
        }

        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;

        // Save attempt
        $attempt = CourseQuizAttempt::create([
            'user_id' => Auth::id(),
            'course_content_id' => $content->id,
            'score' => $score,
            'total_questions' => $totalQuestions,
            'started_at' => now(),
            'completed_at' => now(),
        ]);

        // Mark as completed if score >= 70
        if ($score >= 70) {
            $progressRecord = CourseContentProgress::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'course_content_id' => $content->id,
                ],
                [
                    'is_completed' => true,
                    'completed_at' => now(),
                ]
            );

            // Log quiz completion activity only if newly completed
            if ($progressRecord->wasRecentlyCreated || $progressRecord->wasChanged('is_completed')) {
                \App\Models\UserActivity::create([
                    'user_id' => Auth::id(),
                    'activity_type' => 'complete_quiz',
                    'activity_title' => 'Menyelesaikan quiz',
                    'activity_description' => $content->title . ' (Skor: ' . $score . '%) - ' . $content->course->title,
                    'course_id' => $content->course_id,
                ]);
            }

            // Update enrollment progress
            $enrollment = CourseEnrollment::where('user_id', Auth::id())
                ->where('course_id', $content->course_id)
                ->first();

            if ($enrollment) {
                $enrollment->updateProgress();
                
                // Check if course is now 100% complete and log activity
                if ($enrollment->progress_percentage == 100) {
                    // Check if activity already exists
                    $existingActivity = \App\Models\UserActivity::where('user_id', Auth::id())
                        ->where('activity_type', 'complete_course')
                        ->where('course_id', $content->course_id)
                        ->first();
                    
                    if (!$existingActivity) {
                        \App\Models\UserActivity::create([
                            'user_id' => Auth::id(),
                            'activity_type' => 'complete_course',
                            'activity_title' => 'Menyelesaikan course',
                            'activity_description' => $content->course->title . ' - Selamat! Anda berhasil menyelesaikan course ini',
                            'course_id' => $content->course_id,
                        ]);
                    }
                }
            }
        }

        return back()->with('quiz_result', [
            'score' => $score,
            'correct_answers' => $correctAnswers,
            'total_questions' => $totalQuestions,
            'passed' => $score >= 70,
        ]);
    }
}
