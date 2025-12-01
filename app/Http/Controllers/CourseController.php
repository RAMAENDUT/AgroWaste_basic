<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\CourseModule;
use App\Models\CourseModuleProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('is_published', true)
            ->orderBy('display_order')
            ->get();

        $coursesData = [];
        foreach ($courses as $course) {
            $enrollment = null;
            if (Auth::check()) {
                $enrollment = CourseEnrollment::where('course_id', $course->id)
                    ->where('user_id', Auth::id())
                    ->first();
            }

            $totalContents = CourseModule::where('course_id', $course->id)->count();

            $coursesData[] = [
                'id' => $course->id,
                'title' => $course->title,
                'description' => $course->description,
                'thumbnail' => $course->thumbnail,
                'level' => $course->level,
                'duration_minutes' => $course->duration_minutes,
                'total_contents' => $totalContents,
                'is_enrolled' => $enrollment !== null,
                'progress_percentage' => $enrollment ? $enrollment->progress_percent : 0,
            ];
        }

        return Inertia::render('Courses/Index', [
            'courses' => $coursesData,
        ]);
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);

        // Check enrollment
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $enrollment = CourseEnrollment::where('course_id', $course->id)
            ->where('user_id', Auth::id())
            ->first();
        if (!$enrollment) {
            return redirect()->route('courses.index')->with('error', 'Anda belum mendaftar di course ini.');
        }

        // Get all contents with exercises
        $contents = CourseModule::where('course_id', $course->id)
            ->with(['exercise.questions.options'])
            ->orderBy('display_order', 'ASC')
            ->get();

        // Format contents data
        $contentsData = [];
        foreach ($contents as $content) {
            $moduleData = [
                'id' => $content->id,
                'type' => $content->type,
                'title' => $content->title,
                'description' => $content->description,
                'content_text' => $content->content_text,
                'video_path' => $content->video_path,
                'duration_seconds' => $content->duration_seconds,
                'is_completed' => false, // TODO: implement progress tracking
            ];

            // Add exercise data if exists
            if ($content->type === 'exercise' && $content->exercise) {
                $moduleData['exercise'] = [
                    'id' => $content->exercise->id,
                    'title' => $content->exercise->title,
                    'passing_score' => $content->exercise->passing_score,
                    'questions' => $content->exercise->questions->map(function($q) {
                        return [
                            'id' => $q->id,
                            'question_text' => $q->question_text,
                            'display_order' => $q->display_order,
                            'options' => $q->options->map(function($o) {
                                return [
                                    'id' => $o->id,
                                    'option_text' => $o->option_text,
                                    'is_correct' => $o->is_correct,
                                ];
                            })->toArray()
                        ];
                    })->toArray()
                ];
            }

            $contentsData[] = $moduleData;
        }

        // Redirect to first content
        $firstContent = $contents->first();
        if ($firstContent) {
            return redirect()->route('courses.content.show', [$course->id, $firstContent->id]);
        }

        return Inertia::render('Courses/ShowSimple', [
            'course' => [
                'id' => $course->id,
                'title' => $course->title,
                'description' => $course->description,
                'thumbnail' => $course->thumbnail,
                'level' => $course->level,
                'duration_minutes' => $course->duration_minutes,
            ],
            'contents' => $contentsData,
            'enrollment' => [
                'progress_percent' => $enrollment->progress_percent,
                'enrolled_at' => $enrollment->enrolled_at,
                'completed_at' => $enrollment->completed_at,
            ],
        ]);
    }

    public function enroll($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $course = Course::findOrFail($id);

        // Check if already enrolled
        if ($course->isEnrolledBy(Auth::id())) {
            return redirect()->route('courses.show', $id);
        }

        // Create enrollment
        CourseEnrollment::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'enrolled_at' => now(),
        ]);

        // TODO: Log enroll activity (table not exist yet)

        return redirect()->route('my-courses.on-progress');
    }

    public function onProgress()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Get enrolled courses that are not 100% complete
        $enrollments = CourseEnrollment::with('course')
            ->where('user_id', Auth::id())
            ->where('progress_percent', '<', 100)
            ->get();

        $coursesData = [];
        foreach ($enrollments as $enrollment) {
            $course = $enrollment->course;
            $totalContents = CourseModule::where('course_id', $course->id)->count();
            if (!$totalContents) continue; // Skip courses without content
            
            $completedContents = 0; // TODO: implement module progress tracking

            $coursesData[] = [
                'id' => $course->id,
                'title' => $course->title,
                'description' => $course->description,
                'thumbnail' => $course->thumbnail,
                'level' => $course->level,
                'duration_minutes' => $course->duration_minutes,
                'total_contents' => $totalContents,
                'completed_contents' => $completedContents,
                'progress_percentage' => $enrollment->progress_percent,
            ];
        }

        return Inertia::render('MyCourses/OnProgress', [
            'courses' => $coursesData,
        ]);
    }

    public function completed()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Get enrolled courses that are 100% complete
        $enrollments = CourseEnrollment::with('course')
            ->where('user_id', Auth::id())
            ->where('progress_percent', 100)
            ->get();

        $coursesData = [];
        foreach ($enrollments as $enrollment) {
            $course = $enrollment->course;
            $totalContents = CourseModule::where('course_id', $course->id)->count();
            if (!$totalContents) continue; // Skip courses without content

            $coursesData[] = [
                'id' => $course->id,
                'title' => $course->title,
                'description' => $course->description,
                'thumbnail' => $course->thumbnail,
                'level' => $course->level,
                'duration_minutes' => $course->duration_minutes,
                'total_contents' => $totalContents,
                'progress_percentage' => 100,
            ];
        }

        return Inertia::render('MyCourses/Completed', [
            'courses' => $coursesData,
        ]);
    }

    public function showContent($courseId, $contentId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $course = Course::findOrFail($courseId);
        $enrollment = CourseEnrollment::where('course_id', $courseId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$enrollment) {
            return redirect()->route('courses.index')->with('error', 'Anda belum mendaftar di course ini.');
        }

        // Get current content
        $currentContent = CourseModule::with(['exercise.questions.options'])
            ->where('course_id', $courseId)
            ->where('id', $contentId)
            ->firstOrFail();

        // Auto-complete when viewing content or video (not quiz)
        if (in_array($currentContent->type, ['content', 'video'])) {
            CourseModuleProgress::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'course_module_id' => $contentId,
                ],
                [
                    'course_id' => $courseId,
                    'is_completed' => true,
                    'completed_at' => now(),
                ]
            );

            // Update enrollment progress
            $totalModules = CourseModule::where('course_id', $courseId)->count();
            $completedModules = CourseModuleProgress::where('user_id', Auth::id())
                ->where('course_id', $courseId)
                ->where('is_completed', true)
                ->count();

            $progressPercent = $totalModules > 0 ? round(($completedModules / $totalModules) * 100) : 0;
            
            $enrollment->progress_percent = $progressPercent;
            if ($progressPercent >= 100) {
                $enrollment->completed_at = now();
                $enrollment->status = 'completed';
            }
            $enrollment->save();
        }

        // Get all contents for navigation
        $allContents = CourseModule::where('course_id', $courseId)
            ->orderBy('display_order')
            ->get();

        // Find previous and next content
        $currentIndex = $allContents->search(function($item) use ($contentId) {
            return $item->id == $contentId;
        });

        $previousContent = null;
        $nextContent = null;

        if ($currentIndex !== false) {
            if ($currentIndex > 0) {
                $prev = $allContents[$currentIndex - 1];
                $previousContent = [
                    'id' => $prev->id,
                    'title' => $prev->title,
                ];
            }
            if ($currentIndex < $allContents->count() - 1) {
                $next = $allContents[$currentIndex + 1];
                $nextContent = [
                    'id' => $next->id,
                    'title' => $next->title,
                ];
            }
        }

        // Format current content data
        $contentData = [
            'id' => $currentContent->id,
            'title' => $currentContent->title,
            'description' => $currentContent->description,
            'type' => $currentContent->type,
            'content_text' => $currentContent->content_text,
            'video_path' => $currentContent->video_path,
            'duration_seconds' => $currentContent->duration_seconds,
        ];

        // Add exercise data if exists
        if ($currentContent->type === 'exercise' && $currentContent->exercise) {
            $contentData['exercise'] = [
                'id' => $currentContent->exercise->id,
                'title' => $currentContent->exercise->title,
                'passing_score' => $currentContent->exercise->passing_score,
                'questions' => $currentContent->exercise->questions->map(function($q) {
                    return [
                        'id' => $q->id,
                        'question_text' => $q->question_text,
                        'display_order' => $q->display_order,
                        'options' => $q->options->map(function($o) {
                            return [
                                'id' => $o->id,
                                'option_text' => $o->option_text,
                                // Don't send is_correct to frontend for security
                            ];
                        })->toArray()
                    ];
                })->toArray()
            ];
        }

        // Get completed modules for this user
        $completedModuleIds = CourseModuleProgress::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->where('is_completed', true)
            ->pluck('course_module_id')
            ->toArray();

        // Format all contents for sidebar
        $contentsData = $allContents->map(function($content) use ($completedModuleIds) {
            return [
                'id' => $content->id,
                'title' => $content->title,
                'type' => $content->type,
                'duration_seconds' => $content->duration_seconds,
                'is_completed' => in_array($content->id, $completedModuleIds),
            ];
        })->toArray();

        // Check if current module is completed
        $currentModuleCompleted = in_array($currentContent->id, $completedModuleIds);

        return Inertia::render('Courses/Content', [
            'course' => [
                'id' => $course->id,
                'title' => $course->title,
                'description' => $course->description,
                'thumbnail' => $course->thumbnail,
            ],
            'currentContent' => $contentData,
            'currentModuleCompleted' => $currentModuleCompleted,
            'previousContent' => $previousContent,
            'nextContent' => $nextContent,
            'contents' => $contentsData,
            'enrollment' => [
                'progress_percent' => $enrollment->progress_percent,
                'enrolled_at' => $enrollment->enrolled_at,
                'completed_at' => $enrollment->completed_at,
            ],
        ]);
    }

    public function markComplete($courseId, $contentId)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $enrollment = CourseEnrollment::where('course_id', $courseId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$enrollment) {
            return response()->json(['error' => 'Not enrolled'], 403);
        }

        // Mark module as completed
        CourseModuleProgress::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'course_module_id' => $contentId,
            ],
            [
                'course_id' => $courseId,
                'is_completed' => true,
                'completed_at' => now(),
            ]
        );

        // Calculate progress based on completed modules
        $totalModules = CourseModule::where('course_id', $courseId)->count();
        $completedModules = CourseModuleProgress::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->where('is_completed', true)
            ->count();

        $progressPercent = $totalModules > 0 ? round(($completedModules / $totalModules) * 100) : 0;
        
        $enrollment->progress_percent = $progressPercent;
        if ($progressPercent >= 100) {
            $enrollment->completed_at = now();
            $enrollment->status = 'completed';
        }
        $enrollment->save();

        return response()->json(['success' => true, 'progress_percent' => $enrollment->progress_percent]);
    }

    public function submitQuiz(Request $request, $courseId, $contentId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $enrollment = CourseEnrollment::where('course_id', $courseId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$enrollment) {
            return back()->with('error', 'Not enrolled');
        }

        $content = CourseModule::with(['exercise.questions.options'])
            ->where('course_id', $courseId)
            ->where('id', $contentId)
            ->firstOrFail();

        if ($content->type !== 'exercise' || !$content->exercise) {
            return back()->with('error', 'This is not a quiz');
        }

        $answers = $request->input('answers', []);
        $exercise = $content->exercise;
        
        // Calculate score
        $totalQuestions = $exercise->questions->count();
        $correctAnswers = 0;

        foreach ($exercise->questions as $question) {
            $userAnswerId = $answers[$question->id] ?? null;
            if ($userAnswerId) {
                $correctOption = $question->options->where('is_correct', true)->first();
                if ($correctOption && $correctOption->id == $userAnswerId) {
                    $correctAnswers++;
                }
            }
        }

        $score = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;
        $passed = $score >= $exercise->passing_score;

        // Save quiz attempt to database
        DB::table('quiz_attempts')->insert([
            'user_id' => Auth::id(),
            'course_id' => $courseId,
            'course_module_id' => $contentId,
            'exercise_id' => $exercise->id,
            'score' => round($score),
            'passed' => $passed,
            'correct_answers' => $correctAnswers,
            'total_questions' => $totalQuestions,
            'answers' => json_encode($answers),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Update progress if passed
        if ($passed) {
            // Mark quiz module as completed
            CourseModuleProgress::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'course_module_id' => $contentId,
                ],
                [
                    'course_id' => $courseId,
                    'is_completed' => true,
                    'completed_at' => now(),
                ]
            );

            // Calculate progress based on completed modules
            $totalModules = CourseModule::where('course_id', $courseId)->count();
            $completedModules = CourseModuleProgress::where('user_id', Auth::id())
                ->where('course_id', $courseId)
                ->where('is_completed', true)
                ->count();

            $progressPercent = $totalModules > 0 ? round(($completedModules / $totalModules) * 100) : 0;
            
            $enrollment->progress_percent = $progressPercent;
            if ($progressPercent >= 100) {
                $enrollment->completed_at = now();
                $enrollment->status = 'completed';
            }
            $enrollment->save();
        }

        return back()->with('quiz_result', [
            'score' => $score,
            'passed' => $passed,
            'correct_answers' => $correctAnswers,
            'total_questions' => $totalQuestions,
            'passing_score' => $exercise->passing_score,
        ]);
    }
}
