<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index(Request $request)
    {
        $query = School::query();
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }
        $schools = $query->withCount('kelas')->latest()->get();
        return view('admin.schools.index', compact('schools'));
    }

    public function create()
    {
        return view('admin.schools.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'npsn' => 'nullable|string|max:20',
            'logo' => 'nullable|image|max:2048',
            'status' => 'boolean',
        ]);
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('schools/logos', 'public');
        }
        $validated['status'] = $request->has('status');
        School::create($validated);
        return redirect()->route('admin.schools.index')->with('success', 'Sekolah berhasil ditambahkan.');
    }

    public function show(School $school)
    {
        $school->load(['kelas.students', 'konselors.user']);
        return view('admin.schools.show', compact('school'));
    }

    public function edit(School $school)
    {
        return view('admin.schools.edit', compact('school'));
    }

    public function update(Request $request, School $school)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'npsn' => 'nullable|string|max:20',
            'logo' => 'nullable|image|max:2048',
            'status' => 'boolean',
        ]);
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('schools/logos', 'public');
        }
        $validated['status'] = $request->has('status');
        $school->update($validated);
        return redirect()->route('admin.schools.index')->with('success', 'Sekolah berhasil diperbarui.');
    }

    public function destroy(School $school)
    {
        $school->delete();
        return redirect()->route('admin.schools.index')->with('success', 'Sekolah berhasil dihapus.');
    }
}
