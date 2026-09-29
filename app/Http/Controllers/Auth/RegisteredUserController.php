<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Role;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $schools = School::where('status', true)->orderBy('nama')->get();
        $kelasList = Kelas::with('school')
            ->orderBy('school_id')
            ->orderBy('nama_kelas')
            ->get();

        return view('auth.register', compact('schools', 'kelasList'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nis' => ['required', 'string', 'max:50'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tanggal_lahir' => ['required', 'date'],
        ]);

        // 1. Generate Username: 3 huruf paling depan nama + NIS + tanggal daftar
        $prefix = strtolower(substr(preg_replace('/[^a-zA-Z]/', '', $request->nama), 0, 3));
        if (strlen($prefix) < 3) {
            $prefix = str_pad($prefix, 3, 'x');
        }
        $cleanNis = preg_replace('/[^a-zA-Z0-9]/', '', $request->nis);
        $tglDaftar = now()->format('d'); // Tanggal saat pendaftaran (01-31)
        $baseUsername = $prefix . $cleanNis . $tglDaftar;

        $username = $baseUsername;
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        // 2. Generate Default Password: kombinasi 6 abjad besar kecil + spesial karakter
        $defaultPassword = $this->generateDefaultPassword();

        // 3. Simpan User & Student dalam database transaction
        $data = DB::transaction(function () use ($request, $username, $defaultPassword) {
            $user = User::create([
                'role_id' => Role::SISWA,
                'username' => $username,
                'email' => null,
                'nama' => $request->nama,
                'password' => Hash::make($defaultPassword),
                'status' => true,
            ]);

            $student = Student::create([
                'user_id' => $user->id,
                'kelas_id' => $request->kelas_id,
                'nis' => $request->nis,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
            ]);

            return ['user' => $user, 'student' => $student];
        });

        $user = $data['user'];
        $student = $data['student'];
        $student->load(['kelas.school']);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('register.success')->with('registered_credentials', [
            'nama' => $user->nama,
            'username' => $username,
            'password' => $defaultPassword,
            'nis' => $student->nis,
            'kelas' => 'Kelas ' . ($student->kelas->nama_kelas ?? '-') . ' (' . ($student->kelas->school->nama ?? '-') . ')',
        ]);
    }

    /**
     * Display registration success page with generated credentials.
     */
    public function success(): View|RedirectResponse
    {
        if (! session()->has('registered_credentials')) {
            if (Auth::check()) {
                return redirect()->route(Auth::user()->dashboardRoute());
            }
            return redirect()->route('login');
        }

        $credentials = session('registered_credentials');
        return view('auth.register-success', compact('credentials'));
    }

    /**
     * Generate default password: kombinasi 6 abjad besar-kecil + spesial karakter.
     */
    protected function generateDefaultPassword(): string
    {
        $uppers = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $lowers = 'abcdefghijkmnopqrstuvwxyz';
        $specials = '@#!$%*&';

        // 6 abjad: ambil kombinasi huruf besar dan huruf kecil
        $letters = [];
        for ($i = 0; $i < 3; $i++) {
            $letters[] = $uppers[random_int(0, strlen($uppers) - 1)];
            $letters[] = $lowers[random_int(0, strlen($lowers) - 1)];
        }
        shuffle($letters);
        $sixLetters = implode('', $letters);

        // Tambahkan karakter spesial
        $special1 = $specials[random_int(0, strlen($specials) - 1)];
        $special2 = $specials[random_int(0, strlen($specials) - 1)];

        return $sixLetters . $special1 . $special2;
    }
}
