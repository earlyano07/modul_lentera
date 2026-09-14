<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Module;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function create(Module $module)
    {
        $nextOrder = $module->assessments()->max('urutan') + 1;
        return view('admin.assessments.create', compact('module', 'nextOrder'));
    }

    public function store(Request $request, Module $module)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'jenis' => 'required|in:pre_test,post_test,lkpd,penilaian_diri,lembar_komitmen,stage_assessment',
            'max_skor' => 'nullable|integer|min:0',
            'urutan' => 'required|integer|min:1',
        ]);
        $validated['module_id'] = $module->id;
        $validated['max_skor'] = $validated['max_skor'] ?? 0;
        Assessment::create($validated);
        return redirect()->route('admin.modules.show', ['module' => $module, 'step' => 4])->with('success', 'Asesmen berhasil ditambahkan.');
    }

    public function show(Assessment $assessment)
    {
        $assessment->load(['module', 'questions.options']);
        return view('admin.assessments.show', compact('assessment'));
    }

    public function edit(Assessment $assessment)
    {
        $assessment->load('module');
        return view('admin.assessments.edit', compact('assessment'));
    }

    public function update(Request $request, Assessment $assessment)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'jenis' => 'required|in:pre_test,post_test,lkpd,penilaian_diri,lembar_komitmen,stage_assessment',
            'max_skor' => 'nullable|integer|min:0',
            'urutan' => 'required|integer|min:1',
        ]);
        if (!isset($validated['max_skor'])) {
            unset($validated['max_skor']);
        }
        $assessment->update($validated);
        return redirect()->route('admin.modules.show', ['module' => $assessment->module, 'step' => 4])->with('success', 'Asesmen berhasil diperbarui.');
    }

    public function destroy(Assessment $assessment)
    {
        $module = $assessment->module;
        $assessment->delete();
        return redirect()->route('admin.modules.show', ['module' => $module, 'step' => 4])->with('success', 'Assessment berhasil dihapus.');
    }
}
