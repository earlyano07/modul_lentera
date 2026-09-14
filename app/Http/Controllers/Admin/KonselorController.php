<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Konselor;
use App\Models\School;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class KonselorController extends Controller
{
    public function index(Request $request)
    {
        $query = Konselor::with(['user', 'schools']);
        $konselors = $query->latest()->get();
        $schools = School::where('status', true)->get();
        return view('admin.konselor.index', compact('konselors', 'schools'));
    }

    public function create()
    {
        $schools = School::where('status', true)->get();
        return view('admin.konselor.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'nip' => 'required|string|max:50',
            'no_hp' => 'nullable|string|max:20',
            'schools' => 'nullable|array',
            'schools.*' => 'exists:schools,id',
        ]);
        DB::transaction(function () use ($validated, $request) {
            $user = User::create([
                'role_id' => Role::KONSELOR,
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);
            $konselor = Konselor::create([
                'user_id' => $user->id,
                'nip' => $validated['nip'],
                'no_hp' => $validated['no_hp'] ?? null,
            ]);
            if ($request->has('schools')) {
                $konselor->schools()->sync($request->schools);
            }
        });
        return redirect()->route('admin.konselor.index')->with('success', 'Konselor berhasil ditambahkan.');
    }

    public function edit(Konselor $konselor)
    {
        $konselor->load(['user', 'schools']);
        $schools = School::where('status', true)->get();
        return view('admin.konselor.edit', compact('konselor', 'schools'));
    }

    public function update(Request $request, Konselor $konselor)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $konselor->user_id,
            'password' => 'nullable|string|min:8',
            'nip' => 'required|string|max:50',
            'no_hp' => 'nullable|string|max:20',
            'schools' => 'nullable|array',
            'schools.*' => 'exists:schools,id',
        ]);
        DB::transaction(function () use ($validated, $request, $konselor) {
            $userData = ['nama' => $validated['nama'], 'email' => $validated['email']];
            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }
            $konselor->user->update($userData);
            $konselor->update(['nip' => $validated['nip'], 'no_hp' => $validated['no_hp'] ?? null]);
            $konselor->schools()->sync($request->schools ?? []);
        });
        return redirect()->route('admin.konselor.index')->with('success', 'Konselor berhasil diperbarui.');
    }

    public function destroy(Konselor $konselor)
    {
        $konselor->user->delete();
        return redirect()->route('admin.konselor.index')->with('success', 'Konselor berhasil dihapus.');
    }

    public function assignSchools(Request $request, Konselor $konselor)
    {
        $validated = $request->validate([
            'schools' => 'required|array',
            'schools.*' => 'exists:schools,id',
        ]);
        $konselor->schools()->sync($validated['schools']);
        return back()->with('success', 'Sekolah berhasil di-assign.');
    }
}
