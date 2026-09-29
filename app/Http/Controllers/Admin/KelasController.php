<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\School;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $query = Kelas::with('school');
        if ($request->filled('school_id')) {
            $query->where('school_id', $request->school_id);
        }
        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }
        if ($request->filled('search')) {
            $query->where('nama_kelas', 'like', '%' . $request->search . '%');
        }
        $kelasList = $query->withCount('students')->latest()->get();
        $schools = School::where('status', true)->get();
        $tahunAjaranList = Kelas::distinct()->pluck('tahun_ajaran');
        return view('admin.kelas.index', compact('kelasList', 'schools', 'tahunAjaranList'));
    }

    public function create()
    {
        $schools = School::where('status', true)->get();
        return view('admin.kelas.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'nama_kelas' => 'required|string|max:255',
            'tingkat' => 'required|string|max:50',
            'tahun_ajaran' => 'required|string|max:20',
        ]);
        Kelas::create($validated);
        if ($request->filled('_redirect_to')) {
            return redirect($request->input('_redirect_to'))->with('success', 'Kelas berhasil ditambahkan.');
        }
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(Kelas $kela)
    {
        $schools = School::where('status', true)->get();
        return view('admin.kelas.edit', compact('kela', 'schools'));
    }

    public function update(Request $request, Kelas $kela)
    {
        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'nama_kelas' => 'required|string|max:255',
            'tingkat' => 'required|string|max:50',
            'tahun_ajaran' => 'required|string|max:20',
        ]);
        $kela->update($validated);
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kela)
    {
        $kela->delete();
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
