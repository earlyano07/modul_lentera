<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\School;
use App\Models\Student;
use App\Services\ProgressService;

class MonitoringController extends Controller
{
    public function __construct(protected ProgressService $progressService) {}

    public function schools()
    {
        $konselor = auth()->user()->konselor;
        $schools = $konselor->schools()->withCount('kelas')->get();
        return view('counselor.monitoring.schools', compact('schools'));
    }

    public function kelas(School $school)
    {
        $konselor = auth()->user()->konselor;
        if (!$konselor->schools()->where('schools.id', $school->id)->exists()) {
            abort(403, 'Anda tidak memiliki akses ke sekolah ini.');
        }
        $kelasList = $school->kelas()->withCount('students')->get();
        return view('counselor.monitoring.kelas', compact('school', 'kelasList'));
    }

    public function students(Kelas $kelas)
    {
        $students = $kelas->students()->with('user')->get();
        $studentsData = $students->map(function ($student) {
            $currentStage = $this->progressService->getCurrentStage($student);
            return (object) [
                'student' => $student,
                'current_stage' => $currentStage?->judul ?? 'Program Selesai',
                'status' => $this->progressService->getCurrentStatusLabel($student),
                'progress_percentage' => $this->progressService->getProgressPercentage($student),
                'is_completed' => $this->progressService->isProgramCompleted($student),
            ];
        });
        return view('counselor.monitoring.students', compact('kelas', 'studentsData'));
    }

    public function studentDetail(Student $student)
    {
        $student->load(['user', 'kelas.school']);
        $timeline = $this->progressService->getProgressTimeline($student);
        $progressPercentage = $this->progressService->getProgressPercentage($student);
        return view('counselor.monitoring.student-detail', compact('student', 'timeline', 'progressPercentage'));
    }
}
