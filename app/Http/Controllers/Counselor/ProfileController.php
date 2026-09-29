<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Konselor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the counselor's profile edit page.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $konselor = $user->konselor;

        if (!$konselor) {
            $konselor = Konselor::firstOrCreate(
                ['user_id' => $user->id],
                ['nip' => '-', 'no_hp' => '-']
            );
        }

        $konselor->load('schools');

        return view('counselor.profile', compact('user', 'konselor'));
    }

    /**
     * Update the counselor's profile information (name, email, NIP, no_hp).
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = $request->user();
        $konselor = $user->konselor;

        if (!$konselor) {
            $konselor = Konselor::firstOrCreate(
                ['user_id' => $user->id],
                ['nip' => '-', 'no_hp' => '-']
            );
        }

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'nip' => ['nullable', 'string', 'max:100'],
            'no_hp' => ['nullable', 'string', 'max:30'],
        ], [
            'nama.required' => 'Nama lengkap konselor wajib diisi.',
            'nama.max' => 'Nama lengkap maksimal 255 karakter.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email ini sudah digunakan oleh akun lain.',
            'nip.max' => 'NIP maksimal 100 karakter.',
            'no_hp.max' => 'Nomor HP maksimal 30 karakter.',
        ]);

        $user->nama = $validated['nama'];
        $user->email = $validated['email'];
        $user->save();

        $konselor->nip = $validated['nip'] ?? '-';
        $konselor->no_hp = $validated['no_hp'] ?? '-';
        $konselor->save();

        return redirect()->route('counselor.profile.edit')
            ->with('success', 'Informasi profil dan kontak berhasil diperbarui.');
    }

    /**
     * Update the counselor's username.
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
            'username.unique' => 'Nama pengguna ini sudah digunakan oleh akun lain. Silakan pilih yang lain.',
            'username.alpha_dash' => 'Nama pengguna hanya boleh berisi huruf, angka, tanda hubung (-), dan garis bawah (_).',
            'username.min' => 'Nama pengguna minimal 3 karakter.',
            'username.max' => 'Nama pengguna maksimal 50 karakter.',
        ]);

        $user->username = $validated['username'];
        $user->save();

        return redirect()->route('counselor.profile.edit')
            ->with('success', 'Nama pengguna (username) berhasil diperbarui menjadi: ' . $user->username);
    }

    /**
     * Update the counselor's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'current_password.current_password' => 'Kata sandi saat ini yang Anda masukkan tidak sesuai.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('counselor.profile.edit')
            ->with('success', 'Kata sandi akun Anda berhasil diperbarui.');
    }
}
