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
        
        // Get user progress
        $userProgress = UserModuleProgress::where('user_id', $user->id)->get();
        
        // Calculate stats
        $stats = [
            'completedModules' => $userProgress->where('module_completed', true)->count(),
            'completedVideos' => $userProgress->where('video_completed', true)->count(),
            'passedQuizzes' => $userProgress->where('quiz_completed', true)->count(),
            'averageScore' => round($userProgress->where('quiz_completed', true)->avg('quiz_score') ?? 0),
        ];

        // Get module progress with details
        $moduleProgress = Module::whereIn('id', $userProgress->pluck('module_id'))
            ->get()
            ->map(function($module) use ($userProgress) {
                $progress = $userProgress->where('module_id', $module->id)->first();
                $percentage = 0;
                $status = 'Belum Dimulai';
                
                if ($progress) {
                    $completed = 0;
                    if ($progress->module_completed) $completed++;
                    if ($progress->video_completed) $completed++;
                    if ($progress->quiz_completed) $completed++;
                    $percentage = round(($completed / 3) * 100);
                    
                    if ($percentage === 100) {
                        $status = 'Selesai';
                    } elseif ($percentage > 0) {
                        $status = 'Sedang Berjalan';
                    }
                }
                
                return [
                    'id' => $module->id,
                    'slug' => $module->slug,
                    'title' => $module->title,
                    'status' => $status,
                    'progress' => $percentage,
                    'lastAccessed' => $progress ? $progress->updated_at->diffForHumans() : '-',
                ];
            });

        // Get video progress
        $videoProgress = \App\Models\Video::whereHas('module', function($query) use ($userProgress) {
            $query->whereIn('id', $userProgress->pluck('module_id'));
        })
        ->take(5)
        ->get()
        ->map(function($video) use ($userProgress) {
            $progress = $userProgress->where('module_id', $video->module_id)->first();
            return [
                'id' => $video->id,
                'title' => $video->title,
                'status' => $progress && $progress->video_completed ? 'Selesai' : 'Belum',
                'progress' => $progress && $progress->video_completed ? 100 : 0,
                'date' => $video->created_at->format('d/m/Y'),
            ];
        });

        // Mock activities (can be enhanced with real activity tracking)
        $activities = [
            [
                'action' => 'Menyelesaikan modul',
                'description' => 'Pengenalan Limbah Pertanian - Selamat! Anda berhasil menyelesaikan modul ini',
                'time' => '2 hari yang lalu',
            ],
            [
                'action' => 'Menonton video',
                'description' => 'Instalasi Biogas Sederhana',
                'time' => '3 hari yang lalu',
            ],
            [
                'action' => 'Mengikuti quiz',
                'description' => 'Quiz: Teknik Komposting',
                'time' => '5 hari yang lalu',
            ],
            [
                'action' => 'Mendaftar kursus',
                'description' => 'Selamat bergabung di AgroWaste Academy!',
                'time' => '1 minggu yang lalu',
            ],
        ];

        return Inertia::render('Profile/Edit', [
            'stats' => $stats,
            'moduleProgress' => $moduleProgress,
            'videoProgress' => $videoProgress,
            'activities' => $activities,
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
