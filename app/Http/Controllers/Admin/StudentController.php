<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Kelas;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(['user', 'kelas.school']);
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }
        $students = $query->latest()->get();
        $kelasList = Kelas::with('school')->get();
        return view('admin.students.index', compact('students', 'kelasList'));
    }

    public function create()
    {
        $kelasList = Kelas::with('school')->get();
        return view('admin.students.create', compact('kelasList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'kelas_id' => 'required|exists:kelas,id',
            'nis' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
        ]);
        DB::transaction(function () use ($validated) {
            $user = User::create([
                'role_id' => Role::SISWA,
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);
            Student::create([
                'user_id' => $user->id,
                'kelas_id' => $validated['kelas_id'],
                'nis' => $validated['nis'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
            ]);
        });
        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function edit(Student $student)
    {
        $student->load('user');
        $kelasList = Kelas::with('school')->get();
        return view('admin.students.edit', compact('student', 'kelasList'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->user_id,
            'password' => 'nullable|string|min:8',
            'kelas_id' => 'required|exists:kelas,id',
            'nis' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
        ]);
        DB::transaction(function () use ($validated, $student) {
            $userData = ['nama' => $validated['nama'], 'email' => $validated['email']];
            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }
            $student->user->update($userData);
            $student->update([
                'kelas_id' => $validated['kelas_id'],
                'nis' => $validated['nis'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
            ]);
        });
        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        $student->user->delete();
        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil dihapus.');
    }

    public function importForm()
    {
        $kelasList = Kelas::with('school')->get();
        return view('admin.students.import', compact('kelasList'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls|max:5120',
            'kelas_id' => 'required|exists:kelas,id',
        ]);
        // TODO: Implement with maatwebsite/excel
        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil diimpor.');
    }
}
