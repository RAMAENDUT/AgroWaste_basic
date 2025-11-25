<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;

class AdminQuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with('module')->get();
        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        return view('admin.quizzes.create');
    }

    public function store(Request $request)
    {
        // To be implemented
        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz created successfully');
    }

    public function edit($id)
    {
        $quiz = Quiz::findOrFail($id);
        return view('admin.quizzes.edit', compact('quiz'));
    }

    public function update(Request $request, $id)
    {
        // To be implemented
        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz updated successfully');
    }

    public function destroy($id)
    {
        // To be implemented
        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz deleted successfully');
    }
}
