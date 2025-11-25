<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class AdminVideoController extends Controller
{
    public function index()
    {
        $videos = Video::with('module')->orderBy('order')->get();
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.videos.create');
    }

    public function store(Request $request)
    {
        // To be implemented
        return redirect()->route('admin.videos.index')->with('success', 'Video created successfully');
    }

    public function edit($id)
    {
        $video = Video::findOrFail($id);
        return view('admin.videos.edit', compact('video'));
    }

    public function update(Request $request, $id)
    {
        // To be implemented
        return redirect()->route('admin.videos.index')->with('success', 'Video updated successfully');
    }

    public function destroy($id)
    {
        // To be implemented
        return redirect()->route('admin.videos.index')->with('success', 'Video deleted successfully');
    }
}
