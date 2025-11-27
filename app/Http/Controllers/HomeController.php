<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\User;
use App\Models\QuizAttempt;
use App\Models\UserModuleProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $userProgress = [];
        $enrolledModules = 0;
        $activeModules = 0;
        $completedModules = 0;
        $recentAttempts = [];
        
        if (Auth::check()) {
            $userProgress = UserModuleProgress::where('user_id', Auth::id())
                ->with('module')
                ->get();
            
            // Count enrolled modules (any progress)
            $enrolledModules = $userProgress->count();
            
            // Count active modules (started but not completed)
            $activeModules = $userProgress->filter(function($progress) {
                return !($progress->module_completed && $progress->video_completed && $progress->quiz_completed);
            })->count();
            
            // Count completed modules (all parts done)
            $completedModules = $userProgress->filter(function($progress) {
                return $progress->module_completed && $progress->video_completed && $progress->quiz_completed;
            })->count();

            $recentAttempts = QuizAttempt::where('user_id', Auth::id())
                ->with(['quiz.module'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        }

        $modules = Module::where('is_active', true)
            ->orderBy('order')
            ->take(3)
            ->get();

        return Inertia::render('Home', [
            'totalModules' => $enrolledModules,
            'completedModules' => $completedModules,
            'modules' => $modules,
            'userProgress' => $userProgress,
            'recentAttempts' => $recentAttempts,
        ]);
    }

    public function landing()
    {
        // Redirect if already logged in
        if (Auth::check()) {
            if (Auth::user()->role_id === 1) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('home');
        }
        
        return inertia('Landing');
    }

    public function profile()
    {
        $user = Auth::user();
        
        // Get course enrollments
        $enrollments = \App\Models\CourseEnrollment::where('user_id', $user->id)
            ->with('course')
            ->get();
        
        // Calculate stats
        $completedCourses = $enrollments->where('progress_percentage', 100)->count();
        
        // Get all quiz attempts from course contents
        $quizScores = [];
        foreach ($enrollments as $enrollment) {
            $courseContents = \App\Models\CourseContent::where('course_id', $enrollment->course_id)
                ->where('type', 'quiz')
                ->pluck('id');
            
            // Get best score for each quiz
            foreach ($courseContents as $contentId) {
                $bestScore = \App\Models\CourseQuizAttempt::where('user_id', $user->id)
                    ->where('course_content_id', $contentId)
                    ->max('score');
                
                if ($bestScore !== null) {
                    $quizScores[] = $bestScore;
                }
            }
        }
        
        $averageQuizScore = count($quizScores) > 0 ? round(array_sum($quizScores) / count($quizScores)) : 0;
        
        $stats = [
            'completedCourses' => $completedCourses,
            'averageQuizScore' => $averageQuizScore,
        ];

        // Get course progress with details
        $courseProgress = $enrollments->map(function($enrollment) use ($user) {
            $course = $enrollment->course;
            $totalContents = \App\Models\CourseContent::where('course_id', $course->id)
                ->where('is_active', true)
                ->count();
            
            $completedContents = \App\Models\CourseContentProgress::where('user_id', $user->id)
                ->whereHas('content', function($q) use ($course) {
                    $q->where('course_id', $course->id);
                })
                ->where('is_completed', true)
                ->count();
            
            return [
                'id' => $course->id,
                'title' => $course->title,
                'progress' => $enrollment->progress_percentage,
                'totalContents' => $totalContents,
                'completedContents' => $completedContents,
            ];
        });

        // Get real user activities
        $userActivities = \App\Models\UserActivity::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $activities = $userActivities->map(function($activity) {
            return [
                'action' => $activity->activity_title,
                'description' => $activity->activity_description,
                'time' => $activity->formatted_time,
            ];
        })->toArray();

        // Calculate achievements based on actual progress
        $achievements = [];
        
        // Pemula Aktif - Enroll 3 courses
        $enrolledCount = $enrollments->count();
        $achievements[] = [
            'title' => 'Pemula Aktif',
            'description' => 'Enroll 3 course pertama (' . min($enrolledCount, 3) . '/3)',
            'unlocked' => $enrolledCount >= 3,
        ];
        
        // Master Quiz - Get 100% average quiz score
        $achievements[] = [
            'title' => 'Master Quiz',
            'description' => 'Dapatkan nilai rata-rata quiz 100%',
            'unlocked' => $averageQuizScore == 100 && count($quizScores) > 0,
        ];
        
        // Course Champion - Complete 5 courses
        $achievements[] = [
            'title' => 'Course Champion',
            'description' => 'Selesaikan 5 course (' . min($completedCourses, 5) . '/5)',
            'unlocked' => $completedCourses >= 5,
        ];

        return Inertia::render('Profile/Edit', [
            'stats' => $stats,
            'courseProgress' => $courseProgress,
            'activities' => $activities,
            'achievements' => $achievements,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $user->update($validated);

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }
}
