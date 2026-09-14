<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::withCount(['materials', 'assessments'])->orderBy('urutan')->get();
        $nextOrder = (Module::max('urutan') ?? 0) + 1;
        return view('admin.modules.index', compact('modules', 'nextOrder'));
    }

    public function create()
    {
        $nextOrder = Module::max('urutan') + 1;
        return view('admin.modules.create', compact('nextOrder'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'fokus_utama' => 'nullable|string',
            'ilustrasi' => 'nullable|image|max:2048',
            'urutan' => 'required|integer|min:0',
            'status' => 'boolean',
            'guide_modeling' => 'nullable|string',
            'guide_role_playing' => 'nullable|string',
            'guide_feedback' => 'nullable|string',
            'guide_transfer' => 'nullable|string',
        ]);
        if ($request->hasFile('ilustrasi')) {
            $validated['ilustrasi'] = $request->file('ilustrasi')->store('topics', 'public');
        }
        $validated['status'] = $request->has('status');
        Module::create($validated);
        return redirect()->route('admin.modules.index')->with('success', 'Topik berhasil ditambahkan.');
    }

    public function show(Module $module)
    {
        $module->load([
            'materials' => fn($q) => $q->orderBy('urutan'),
            'assessments' => fn($q) => $q->orderBy('urutan')
        ]);
        return view('admin.modules.show', compact('module'));
    }

    public function edit(Module $module)
    {
        return view('admin.modules.edit', compact('module'));
    }

    public function update(Request $request, Module $module)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'fokus_utama' => 'nullable|string',
            'ilustrasi' => 'nullable|image|max:2048',
            'urutan' => 'required|integer|min:0',
            'status' => 'boolean',
            'guide_modeling' => 'nullable|string',
            'guide_role_playing' => 'nullable|string',
            'guide_feedback' => 'nullable|string',
            'guide_transfer' => 'nullable|string',
        ]);
        if ($request->hasFile('ilustrasi')) {
            $validated['ilustrasi'] = $request->file('ilustrasi')->store('topics', 'public');
        }
        $validated['status'] = $request->has('status');
        $module->update($validated);
        return back()->with('success', 'Topik berhasil diperbarui.');
    }

    public function destroy(Module $module)
    {
        $module->delete();
        return redirect()->route('admin.modules.index')->with('success', 'Topik berhasil dihapus.');
    }
}
