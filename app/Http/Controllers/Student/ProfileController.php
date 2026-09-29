<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the student's profile edit page.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $student = $user->student;
        if ($student) {
            $student->load(['kelas.school']);
        }

        return view('student.profile', compact('user', 'student'));
    }

    /**
     * Update the student's username.
     */
    public function updateUsername(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'alpha_dash',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
        ], [
            'username.required' => 'Nama pengguna (username) wajib diisi.',
            'username.unique' => 'Nama pengguna ini sudah digunakan oleh akun lain. Silakan pilih nama pengguna lain.',
            'username.alpha_dash' => 'Nama pengguna hanya boleh berisi huruf, angka, tanda hubung (-), dan garis bawah (_).',
            'username.min' => 'Nama pengguna minimal 3 karakter.',
            'username.max' => 'Nama pengguna maksimal 50 karakter.',
        ]);

        $user->username = $validated['username'];
        $user->save();

        return redirect()->route('student.profile.edit')
            ->with('success', 'Nama pengguna (username) berhasil diperbarui menjadi: ' . $user->username);
    }

    /**
     * Update the student's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'current_password.current_password' => 'Kata sandi saat ini yang Anda masukkan salah.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('student.profile.edit')
            ->with('success', 'Kata sandi Anda berhasil diperbarui.');
    }
}