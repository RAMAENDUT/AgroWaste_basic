<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\UserModuleProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $filter = $request->get('filter', 'semua'); // semua, pemula, menengah, lanjutan

        $query = Module::where('is_active', true);

        // Search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by level
        if ($filter !== 'semua') {
            $query->where('level', $filter);
        }

        $modules = $query->orderBy('order')->get();

        // Get user progress for each module
        $userProgress = [];
        if (Auth::check()) {
            $progress = UserModuleProgress::where('user_id', Auth::id())->get();
            foreach ($progress as $p) {
                $userProgress[$p->module_id] = [
                    'started' => true,
                    'module_completed' => $p->module_completed,
                    'video_completed' => $p->video_completed,
                    'quiz_completed' => $p->quiz_completed,
                    'completed_at' => $p->completed_at,
                ];
            }
        }

        return \Inertia\Inertia::render('Modules/Index', [
            'modules' => $modules,
            'userProgress' => $userProgress,
            'filters' => [
                'search' => $search,
                'filter' => $filter,
            ]
        ]);
    }

    public function show($slug)
    {
        $module = Module::where('slug', $slug)->firstOrFail();
        
        // Create or get progress record
        $progress = null;
        if (Auth::check()) {
            $progress = UserModuleProgress::firstOrCreate([
                'user_id' => Auth::id(),
                'module_id' => $module->id,
            ], [
                'started_at' => now(),
            ]);
        }

        $firstVideo = $module->getFirstVideo();
        $firstQuiz = $module->getFirstQuiz();

        return view('modules.show', compact('module', 'progress', 'firstVideo', 'firstQuiz'));
    }

    public function markComplete($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $progress = UserModuleProgress::firstOrCreate([
            'user_id' => Auth::id(),
            'module_id' => $id,
        ]);

        $progress->update([
            'module_completed' => true,
        ]);

        // Check if all parts are completed
        if ($progress->module_completed && $progress->video_completed && $progress->quiz_completed) {
            $progress->update(['completed_at' => now()]);
        }

        return back()->with('success', 'Modul telah selesai dibaca!');
    }
}
