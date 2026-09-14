<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\StudentProgress;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $konselor = $user->konselor;
        $schools = $konselor ? $konselor->schools()->withCount(['kelas', 'kelas as students_count' => function ($query) {
            $query->join('students', 'kelas.id', '=', 'students.kelas_id');
        }])->get() : collect();

        $totalStudents = 0;
        $totalKelas = 0;
        $schoolIds = $schools->pluck('id')->toArray();
        
        foreach ($schools as $school) {
            $totalStudents += $school->students_count;
            $totalKelas += $school->kelas_count;
        }

        // Count of students currently in progress in counselor's schools
        $intervensiBerjalan = StudentProgress::where('status', 'sedang_mengerjakan')
            ->whereHas('student.kelas', function ($query) use ($schoolIds) {
                $query->whereIn('school_id', $schoolIds);
            })
            ->count();

        return view('counselor.dashboard', compact(
            'schools', 
            'totalStudents', 
            'totalKelas', 
            'intervensiBerjalan', 
            'konselor'
        ));
    }
}
