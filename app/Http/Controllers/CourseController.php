<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\CourseContent;
use App\Models\CourseContentProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('is_active', true)
            ->orderBy('order')
            ->get();

        $coursesData = [];
        foreach ($courses as $course) {
            $enrollment = null;
            if (Auth::check()) {
                $enrollment = $course->getEnrollmentFor(Auth::id());
            }

            $totalContents = $course->contents()->where('is_active', true)->count();

            $coursesData[] = [
                'id' => $course->id,
                'title' => $course->title,
                'description' => $course->description,
                'thumbnail' => $course->thumbnail,
                'level' => $course->level,
                'duration_hours' => $course->duration_hours,
                'total_contents' => $totalContents,
                'is_enrolled' => $enrollment !== null,
                'progress_percentage' => $enrollment ? $enrollment->progress_percentage : 0,
            ];
        }

        return Inertia::render('Courses/Index', [
            'courses' => $coursesData,
        ]);
    }

    public function show($id)
    {
        $course = Course::with('contents')->findOrFail($id);

        // Check enrollment
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $enrollment = $course->getEnrollmentFor(Auth::id());
        if (!$enrollment) {
            return redirect()->route('courses.index')->with('error', 'Anda belum mendaftar di course ini.');
        }

        // Get all contents
        $contents = $course->contents()->where('is_active', true)->orderBy('order', 'ASC')->get();

        // Get progress for each content
        $contentsData = [];
        foreach ($contents as $content) {
            $progress = $content->getProgressFor(Auth::id());
            
            $contentsData[] = [
                'id' => $content->id,
                'type' => $content->type,
                'title' => $content->title,
                'description' => $content->description,
                'duration_seconds' => $content->duration_seconds,
                'is_completed' => $progress ? $progress->is_completed : false,
            ];
        }

        // Get first content to display
        $firstContent = $contents->first();
        $currentContent = null;
        
        if ($firstContent) {
            $progress = $firstContent->getProgressFor(Auth::id());
            
            $currentContent = [
                'id' => $firstContent->id,
                'type' => $firstContent->type,
                'title' => $firstContent->title,
                'description' => $firstContent->description,
                'content' => $firstContent->content,
                'video_url' => $firstContent->video_url,
                'duration_seconds' => $firstContent->duration_seconds,
                'is_completed' => $progress ? $progress->is_completed : false,
            ];

            // If quiz, load questions
            if ($firstContent->type === 'quiz') {
                $questions = $firstContent->quizQuestions()->with('options')->get();
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
            }
        }

        return Inertia::render('Courses/Show', [
            'course' => [
                'id' => $course->id,
                'title' => $course->title,
                'description' => $course->description,
                'thumbnail' => $course->thumbnail,
                'level' => $course->level,
                'duration_hours' => $course->duration_hours,
            ],
            'contents' => $contentsData,
            'currentContent' => $currentContent,
            'enrollment' => [
                'progress_percentage' => $enrollment->progress_percentage,
                'enrolled_at' => $enrollment->enrolled_at,
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

        // Log enroll activity
        \App\Models\UserActivity::create([
            'user_id' => Auth::id(),
            'activity_type' => 'enroll_course',
            'activity_title' => 'Mengambil course',
            'activity_description' => $course->title,
            'course_id' => $course->id,
        ]);

        return redirect()->route('my-courses.on-progress');
    }

    public function onProgress()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Get enrolled courses that are not 100% complete
        $enrollments = CourseEnrollment::with('course.contents')
            ->where('user_id', Auth::id())
            ->where('progress_percentage', '<', 100)
            ->get();

        $coursesData = [];
        foreach ($enrollments as $enrollment) {
            $course = $enrollment->course;
            $totalContents = $course->contents()->where('is_active', true)->count();
            if (!$totalContents) continue; // Skip courses without content
            
            $completedContents = CourseContentProgress::where('user_id', Auth::id())
                ->whereHas('content', function($q) use ($course) {
                    $q->where('course_id', $course->id);
                })
                ->where('is_completed', true)
                ->count();

            $coursesData[] = [
                'id' => $course->id,
                'title' => $course->title,
                'description' => $course->description,
                'thumbnail' => $course->thumbnail,
                'level' => $course->level,
                'duration_hours' => $course->duration_hours,
                'total_contents' => $totalContents,
                'completed_contents' => $completedContents,
                'progress_percentage' => $enrollment->progress_percentage,
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
        $enrollments = CourseEnrollment::with('course.contents')
            ->where('user_id', Auth::id())
            ->where('progress_percentage', 100)
            ->get();

        $coursesData = [];
        foreach ($enrollments as $enrollment) {
            $course = $enrollment->course;
            $totalContents = $course->contents()->where('is_active', true)->count();
            if (!$totalContents) continue; // Skip courses without content

            $coursesData[] = [
                'id' => $course->id,
                'title' => $course->title,
                'description' => $course->description,
                'thumbnail' => $course->thumbnail,
                'level' => $course->level,
                'duration_hours' => $course->duration_hours,
                'total_contents' => $totalContents,
                'progress_percentage' => 100,
            ];
        }

        return Inertia::render('MyCourses/Completed', [
            'courses' => $coursesData,
        ]);
    }
}
