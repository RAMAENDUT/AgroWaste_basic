<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Module;
use App\Models\QuizAttempt;
use App\Models\UserModuleProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class QuizController extends Controller
{
    public function index()
    {
        // Get all modules
        $modules = Module::where('is_active', true)
            ->orderBy('order')
            ->get();

        $modulesData = [];
        foreach ($modules as $module) {
            $quizzes = Quiz::where('module_id', $module->id)
                ->where('is_active', true)
                ->get();

            $modulesData[] = [
                'id' => $module->id,
                'title' => $module->title,
                'description' => $module->description,
                'quizzes' => $quizzes->map(function($quiz) {
                    return [
                        'id' => $quiz->id,
                        'title' => $quiz->title,
                        'description' => $quiz->description,
                        'duration_minutes' => $quiz->duration_minutes,
                        'passing_score' => $quiz->passing_score,
                        'total_questions' => $quiz->questions()->count(),
                        'created_at' => $quiz->created_at,
                    ];
                })->toArray(),
            ];
        }

        // Get user progress and attempts
        $userProgress = [];
        $userAttempts = [];
        $stats = [
            'total' => 0,
            'completed' => 0,
            'averageScore' => 0,
            'passed' => 0,
        ];

        if (Auth::check()) {
            $progress = UserModuleProgress::where('user_id', Auth::id())->get();
            foreach ($progress as $p) {
                $userProgress[$p->module_id] = [
                    'quiz_completed' => $p->quiz_completed,
                    'quiz_score' => $p->quiz_score,
                ];
                if ($p->quiz_completed) {
                    $stats['completed']++;
                    $stats['passed']++;
                }
            }

            // Get all user attempts
            $attempts = QuizAttempt::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
            
            $totalScore = 0;
            $attemptCount = 0;
            
            foreach ($attempts as $attempt) {
                if (!isset($userAttempts[$attempt->quiz_id])) {
                    $userAttempts[$attempt->quiz_id] = [];
                }
                $userAttempts[$attempt->quiz_id][] = [
                    'id' => $attempt->id,
                    'score' => $attempt->score,
                    'is_passed' => $attempt->is_passed,
                    'created_at' => $attempt->created_at->format('d M Y H:i'),
                ];
                
                $totalScore += $attempt->score;
                $attemptCount++;
            }

            // Calculate total quizzes
            foreach ($modulesData as $module) {
                $stats['total'] += count($module['quizzes']);
            }

            // Calculate average score
            if ($attemptCount > 0) {
                $stats['averageScore'] = round($totalScore / $attemptCount);
            }
        }

        return Inertia::render('Quizzes/Index', [
            'modules' => $modulesData,
            'userProgress' => $userProgress,
            'userAttempts' => $userAttempts,
            'stats' => $stats,
        ]);
    }

    public function show($id)
    {
        $quiz = Quiz::with(['questions.options', 'module'])->findOrFail($id);
        $module = $quiz->module;

        // Get user's previous attempts
        $previousAttempts = [];
        $bestScore = null;
        if (Auth::check()) {
            $previousAttempts = QuizAttempt::where('user_id', Auth::id())
                ->where('quiz_id', $id)
                ->orderBy('created_at', 'desc')
                ->get();
            
            $bestScore = $previousAttempts->max('score');
        }

        return view('quizzes.show', compact('quiz', 'module', 'previousAttempts', 'bestScore'));
    }

    public function start($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $quiz = Quiz::with('questions.options')->findOrFail($id);

        return view('quizzes.take', compact('quiz'));
    }

    public function submit(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $quiz = Quiz::with('questions.options')->findOrFail($id);
        
        $request->validate([
            'answers' => 'required|array',
        ]);

        $answers = $request->input('answers', []);
        $correctAnswers = 0;
        $totalQuestions = $quiz->questions->count();

        // Calculate score
        foreach ($quiz->questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            if ($userAnswer && $question->isCorrectOption($userAnswer)) {
                $correctAnswers++;
            }
        }

        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;
        $isPassed = $score >= $quiz->passing_score;

        // Save quiz attempt
        $attempt = QuizAttempt::create([
            'user_id' => Auth::id(),
            'quiz_id' => $quiz->id,
            'score' => $score,
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'is_passed' => $isPassed,
            'started_at' => now()->subMinutes(10), // Approximation
            'completed_at' => now(),
        ]);

        // Update module progress
        $progress = UserModuleProgress::firstOrCreate([
            'user_id' => Auth::id(),
            'module_id' => $quiz->module_id,
        ]);

        if ($isPassed) {
            $progress->update([
                'quiz_completed' => true,
                'quiz_score' => $score,
            ]);

            // Check if all parts are completed
            if ($progress->module_completed && $progress->video_completed && $progress->quiz_completed) {
                $progress->update(['completed_at' => now()]);
            }
        }

        return redirect()->route('quizzes.result', $attempt->id);
    }

    public function result($attemptId)
    {
        $attempt = QuizAttempt::with(['quiz.module', 'quiz.questions.options'])
            ->where('user_id', Auth::id())
            ->findOrFail($attemptId);

        $quiz = $attempt->quiz;
        $module = $quiz->module;

        // Check if user has completed all parts of the module
        $progress = UserModuleProgress::where('user_id', Auth::id())
            ->where('module_id', $module->id)
            ->first();

        $allCompleted = $progress && $progress->isFullyCompleted();

        return view('quizzes.result', compact('attempt', 'quiz', 'module', 'allCompleted'));
    }
}
