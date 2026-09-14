<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Module;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Module $module)
    {
        $materials = $module->materials()->orderBy('urutan')->paginate(10);
        return view('admin.materials.index', compact('module', 'materials'));
    }

    public function create(Request $request, Module $module)
    {
        if ($request->query('jenis') === 'video') {
            return redirect()->route('admin.modules.show', $module);
        }
        $nextOrder = $module->materials()->max('urutan') + 1;
        return view('admin.materials.create', compact('module', 'nextOrder'));
    }

    public function store(Request $request, Module $module)
    {
        $validated = $request->validate([
            'judul' => 'nullable|string|max:255',
            'jenis' => 'nullable|string|in:video,kartu_situasi',
            'isi' => 'nullable|string',
            'video' => 'nullable|string|max:500',
            'video_file' => 'nullable|file|mimes:mp4,webm,ogg|max:102400',
            'file_upload' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:10240',
            'situasi' => 'nullable|string',
            'peran' => 'nullable|string',
            'diskusi' => 'nullable|string',
            'urutan' => 'nullable|integer|min:1',
        ]);

        $jenis = $validated['jenis'] ?? ($request->has('video') || $request->hasFile('video_file') ? 'video' : 'kartu_situasi');
        $validated['jenis'] = $jenis;

        if (empty($validated['judul'])) {
            $count = $module->materials()->where('jenis', 'kartu_situasi')->count() + 1;
            $validated['judul'] = $jenis === 'video' 
                ? 'Video Modeling: Topik ' . $module->urutan . ' - ' . $module->judul 
                : 'Kartu Situasi #' . $count;
        }

        if (empty($validated['urutan'])) {
            $validated['urutan'] = $module->materials()->where('jenis', $jenis)->max('urutan') + 1;
        }

        if ($request->hasFile('video_file')) {
            $validated['video'] = $request->file('video_file')->store('materials/videos', 'public');
        }
        if ($request->hasFile('file_upload')) {
            $validated['file_path'] = $request->file('file_upload')->store('materials/files', 'public');
        }
        unset($validated['video_file'], $validated['file_upload']);
        $validated['module_id'] = $module->id;

        if ($jenis === 'video') {
            $existingVideo = $module->materials()->where('jenis', 'video')->first();
            if ($existingVideo) {
                $existingVideo->update($validated);
                return redirect()->route('admin.modules.show', ['module' => $module, 'step' => 1])->with('success', 'Video modeling berhasil diperbarui.');
            }
        }

        Material::create($validated);
        $step = $jenis === 'kartu_situasi' ? 2 : 1;
        return redirect()->route('admin.modules.show', ['module' => $module, 'step' => $step])->with('success', $jenis === 'kartu_situasi' ? 'Kartu situasi berhasil ditambahkan.' : 'Video modeling berhasil ditambahkan.');
    }

    public function edit(Material $material)
    {
        $step = $material->jenis === 'kartu_situasi' ? 2 : 1;
        return redirect()->route('admin.modules.show', ['module' => $material->module, 'step' => $step]);
    }

    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'judul' => 'nullable|string|max:255',
            'jenis' => 'nullable|string|in:video,kartu_situasi',
            'isi' => 'nullable|string',
            'video' => 'nullable|string|max:500',
            'video_file' => 'nullable|file|mimes:mp4,webm,ogg|max:102400',
            'file_upload' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:10240',
            'situasi' => 'nullable|string',
            'peran' => 'nullable|string',
            'diskusi' => 'nullable|string',
            'urutan' => 'nullable|integer|min:1',
        ]);
        if (empty($validated['judul'])) {
            $validated['judul'] = $material->judul ?: ($material->jenis === 'kartu_situasi' ? 'Kartu Situasi #' . $material->urutan : 'Video Modeling: ' . $material->module->judul);
        }
        if ($request->hasFile('video_file')) {
            $validated['video'] = $request->file('video_file')->store('materials/videos', 'public');
        }
        if ($request->hasFile('file_upload')) {
            $validated['file_path'] = $request->file('file_upload')->store('materials/files', 'public');
        }
        unset($validated['video_file'], $validated['file_upload']);
        $material->update($validated);
        $step = $material->jenis === 'kartu_situasi' ? 2 : 1;
        return redirect()->route('admin.modules.show', ['module' => $material->module, 'step' => $step])->with('success', $material->jenis === 'kartu_situasi' ? 'Kartu situasi berhasil diperbarui.' : 'Fasilitas berhasil diperbarui.');
    }

    public function destroy(Material $material)
    {
        $module = $material->module;
        $step = $material->jenis === 'kartu_situasi' ? 2 : 1;
        $material->delete();
        return redirect()->route('admin.modules.show', ['module' => $module, 'step' => $step])->with('success', 'Fasilitas berhasil dihapus.');
    }
}
