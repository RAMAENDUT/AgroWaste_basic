<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;

class AdminModuleController extends Controller
{
    public function index()
    {
        $modules = Module::orderBy('order')->get();
        return view('admin.modules.index', compact('modules'));
    }

    public function create()
    {
        return view('admin.modules.create');
    }

    public function store(Request $request)
    {
        // To be implemented
        return redirect()->route('admin.modules.index')->with('success', 'Module created successfully');
    }

    public function edit($id)
    {
        $module = Module::findOrFail($id);
        return view('admin.modules.edit', compact('module'));
    }

    public function update(Request $request, $id)
    {
        // To be implemented
        return redirect()->route('admin.modules.index')->with('success', 'Module updated successfully');
    }

    public function destroy($id)
    {
        // To be implemented
        return redirect()->route('admin.modules.index')->with('success', 'Module deleted successfully');
    }
}
