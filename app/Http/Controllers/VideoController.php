<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Module;
use App\Models\UserModuleProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class VideoController extends Controller
{
    public function index()
    {
        // Get all modules with videos
        $modules = Module::where('is_active', true)
            ->orderBy('order')
            ->get();

        $modulesData = [];
        foreach ($modules as $module) {
            $videos = Video::where('module_id', $module->id)
                ->where('is_active', true)
                ->orderBy('order')
                ->get();

            $modulesData[] = [
                'id' => $module->id,
                'title' => $module->title,
                'description' => $module->description,
                'thumbnail' => $module->thumbnail,
                'videos' => $videos->map(function($video) {
                    return [
                        'id' => $video->id,
                        'title' => $video->title,
                        'description' => $video->description,
                        'duration_seconds' => $video->duration_seconds,
                        'created_at' => $video->created_at,
                        'updated_at' => $video->updated_at,
                    ];
                })->toArray(),
            ];
        }

        // Get user progress for all modules
        $userProgress = [];
        if (Auth::check()) {
            $progress = UserModuleProgress::where('user_id', Auth::id())->get();
            foreach ($progress as $p) {
                $userProgress[$p->module_id] = [
                    'video_completed' => $p->video_completed,
                    'module_completed' => $p->module_completed,
                    'quiz_completed' => $p->quiz_completed,
                ];
            }
        }

        return Inertia::render('Videos/Index', [
            'modules' => $modulesData,
            'userProgress' => $userProgress,
        ]);
    }

    public function show($id)
    {
        $video = Video::with('module')->findOrFail($id);
        $module = $video->module;
        
        // Get all videos in this module
        $videos = Video::where('module_id', $module->id)
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        // Get next and previous videos
        $currentIndex = $videos->search(function($v) use ($video) {
            return $v->id === $video->id;
        });
        
        $nextVideo = $currentIndex !== false && $currentIndex < $videos->count() - 1 
            ? $videos[$currentIndex + 1] 
            : null;
            
        $previousVideo = $currentIndex !== false && $currentIndex > 0 
            ? $videos[$currentIndex - 1] 
            : null;

        // Get quiz for this module
        $quiz = \App\Models\Quiz::where('module_id', $module->id)
            ->where('is_active', true)
            ->first();

        // Get or create progress
        $progress = null;
        if (Auth::check()) {
            $progress = UserModuleProgress::firstOrCreate([
                'user_id' => Auth::id(),
                'module_id' => $module->id,
            ], [
                'started_at' => now(),
            ]);
        }

        return Inertia::render('Videos/Show', [
            'video' => [
                'id' => $video->id,
                'title' => $video->title,
                'description' => $video->description,
                'duration_seconds' => $video->duration_seconds,
                'video_url' => $video->video_url,
            ],
            'module' => [
                'id' => $module->id,
                'title' => $module->title,
                'description' => $module->description,
                'thumbnail' => $module->thumbnail,
            ],
            'videos' => $videos->map(function($v) {
                return [
                    'id' => $v->id,
                    'title' => $v->title,
                    'duration_seconds' => $v->duration_seconds,
                ];
            })->toArray(),
            'nextVideo' => $nextVideo ? [
                'id' => $nextVideo->id,
                'title' => $nextVideo->title,
            ] : null,
            'previousVideo' => $previousVideo ? [
                'id' => $previousVideo->id,
                'title' => $previousVideo->title,
            ] : null,
            'quiz' => $quiz ? [
                'id' => $quiz->id,
                'title' => $quiz->title,
            ] : null,
            'progress' => $progress ? [
                'video_completed' => $progress->video_completed,
                'module_completed' => $progress->module_completed,
                'quiz_completed' => $progress->quiz_completed,
            ] : null,
        ]);
    }

    public function complete($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $video = Video::findOrFail($id);
        
        $progress = UserModuleProgress::firstOrCreate([
            'user_id' => Auth::id(),
            'module_id' => $video->module_id,
        ], [
            'started_at' => now(),
        ]);

        $progress->update([
            'video_completed' => true,
        ]);

        // Check if all parts are completed
        if ($progress->module_completed && $progress->video_completed && $progress->quiz_completed) {
            $progress->update(['completed_at' => now()]);
        }

        return back();
    }
}
