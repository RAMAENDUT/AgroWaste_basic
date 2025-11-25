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
        $nextVideo = $video->getNextVideo();
        $previousVideo = $video->getPreviousVideo();

        // Get quiz for this module
        $quiz = $module->getFirstQuiz();

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

        return view('videos.show', compact('video', 'module', 'videos', 'nextVideo', 'previousVideo', 'quiz', 'progress'));
    }

    public function markComplete($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $video = Video::findOrFail($id);
        
        $progress = UserModuleProgress::firstOrCreate([
            'user_id' => Auth::id(),
            'module_id' => $video->module_id,
        ]);

        $progress->update([
            'video_completed' => true,
        ]);

        // Check if all parts are completed
        if ($progress->module_completed && $progress->video_completed && $progress->quiz_completed) {
            $progress->update(['completed_at' => now()]);
        }

        return back()->with('success', 'Video telah selesai ditonton!');
    }
}
