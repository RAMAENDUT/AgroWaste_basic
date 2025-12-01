<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\CourseModule;
use App\Models\CourseModuleProgress;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $enrolledCourses = 0;
        $activeCourses = 0;
        $completedCourses = 0;
        
        if (Auth::check()) {
            $enrollments = CourseEnrollment::where('user_id', Auth::id())
                ->with('course')
                ->get();
            
            // Count enrolled courses
            $enrolledCourses = $enrollments->count();
            
            // Count active courses (started but not completed)
            $activeCourses = $enrollments->filter(function($enrollment) {
                return $enrollment->progress_percent > 0 && $enrollment->progress_percent < 100;
            })->count();
            
            // Count completed courses
            $completedCourses = $enrollments->filter(function($enrollment) {
                return $enrollment->progress_percent >= 100;
            })->count();
        }

        // Get published courses
        $courses = Course::where('is_published', true)
            ->orderBy('display_order')
            ->take(3)
            ->get();

        return Inertia::render('Home', [
            'totalCourses' => $enrolledCourses,
            'completedCourses' => $completedCourses,
            'activeCourses' => $activeCourses,
            'courses' => $courses,
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
        $enrollments = CourseEnrollment::where('user_id', $user->id)
            ->with('course')
            ->get();
        
        // Calculate stats
        $completedCourses = $enrollments->where('progress_percent', 100)->count();
        
        // Calculate average quiz score
        $averageQuizScore = \DB::table('quiz_attempts')
            ->where('user_id', $user->id)
            ->avg('score');
        
        $stats = [
            'completedCourses' => $completedCourses,
            'averageQuizScore' => $averageQuizScore ? round($averageQuizScore) : 0,
        ];

        // Get course progress with details
        $courseProgress = $enrollments->map(function($enrollment) use ($user) {
            $course = $enrollment->course;
            $totalContents = CourseModule::where('course_id', $course->id)->count();
            
            $completedContents = CourseModuleProgress::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->where('is_completed', true)
                ->count();
            
            return [
                'id' => $course->id,
                'title' => $course->title,
                'progress' => $enrollment->progress_percent,
                'totalContents' => $totalContents,
                'completedContents' => $completedContents,
            ];
        });

        // Get recent activities from module progress
        $recentActivities = CourseModuleProgress::where('user_id', $user->id)
            ->with(['course', 'courseModule'])
            ->orderBy('completed_at', 'desc')
            ->take(10)
            ->get();

        $activities = $recentActivities->map(function($activity) {
            return [
                'id' => $activity->id,
                'type' => $activity->courseModule->type === 'exercise' ? 'quiz' : 'module',
                'title' => $activity->courseModule->title,
                'course' => $activity->course->title,
                'completed_at' => $activity->completed_at->diffForHumans(),
                'icon' => $activity->courseModule->type === 'exercise' ? 'quiz' : 
                         ($activity->courseModule->type === 'video' ? 'video' : 'module'),
            ];
        });

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
        $averageScore = $stats['averageQuizScore'];
        $achievements[] = [
            'title' => 'Master Quiz',
            'description' => 'Dapatkan nilai rata-rata quiz 100% (saat ini: ' . $averageScore . '%)',
            'unlocked' => $averageScore >= 100,
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
