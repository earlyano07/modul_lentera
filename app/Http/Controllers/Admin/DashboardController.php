<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Kelas;
use App\Models\User;
use App\Models\Module;
use App\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_schools' => School::count(),
            'total_kelas' => Kelas::count(),
            'total_konselor' => User::where('role_id', Role::KONSELOR)->count(),
            'total_siswa' => User::where('role_id', Role::SISWA)->count(),
            'total_modules' => Module::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
