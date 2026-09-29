<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Konselor;
use App\Models\School;
use App\Models\Student;
use App\Services\ProgressService;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function __construct(protected ProgressService $progressService) {}

    public function schools()
    {
        $user = auth()->user();
        $konselor = $user->konselor;
        if (!$konselor) {
            $konselor = Konselor::firstOrCreate(
                ['user_id' => $user->id],
                ['nip' => '-', 'no_hp' => '-']
            );
        }

        $schools = $konselor->schools()->withCount('kelas')->get();
        $allSchools = School::where('status', true)->withCount('kelas')->orderBy('nama')->get();
        $assignedSchoolIds = $schools->pluck('id')->toArray();

        return view('counselor.monitoring.schools', compact('schools', 'allSchools', 'assignedSchoolIds'));
    }

    public function assignSchools(Request $request)
    {
        $user = auth()->user();
        $konselor = $user->konselor;
        if (!$konselor) {
            $konselor = Konselor::firstOrCreate(
                ['user_id' => $user->id],
                ['nip' => '-', 'no_hp' => '-']
            );
        }

        $validated = $request->validate([
            'schools' => 'nullable|array',
            'schools.*' => 'exists:schools,id',
            'school_ids' => 'nullable|array',
            'school_ids.*' => 'exists:schools,id',
        ]);

        $selectedSchools = $validated['schools'] ?? $validated['school_ids'] ?? [];
        $konselor->schools()->sync($selectedSchools);

        return redirect()->route('counselor.monitoring.schools')
            ->with('success', 'Penugasan sekolah binaan berhasil diperbarui.');
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
        $kelas->load('school');
        $students = $kelas->students()->with('user')->get();
        $studentsData = $students->map(function ($student) {
            $currentStage = $this->progressService->getCurrentStage($student);
            $activeAssessment = $this->progressService->getCurrentActiveAssessment($student, $currentStage);
            $progressPct = $this->progressService->getProgressPercentage($student);
            $statusLabel = $this->progressService->getCurrentStatusLabel($student);
            $isCompleted = $this->progressService->isProgramCompleted($student);

            // Detailed stage metrics for current module
            $stageDetails = null;
            if ($currentStage) {
                $totalAss = $currentStage->assessments()->count();
                $completedAss = 0;
                foreach ($currentStage->assessments as $ass) {
                    if ($this->progressService->isAssessmentCompleted($student, $ass)) {
                        $completedAss++;
                    }
                }
                $stageDetails = (object) [
                    'total_assessments' => $totalAss,
                    'completed_assessments' => $completedAss,
                    'active_assessment' => $activeAssessment,
                ];
            }

            return (object) [
                'student' => $student,
                'current_module' => $currentStage,
                'current_stage' => $currentStage ? "Topik {$currentStage->urutan}: {$currentStage->judul}" : 'Program Selesai',
                'active_assessment' => $activeAssessment,
                'stage_details' => $stageDetails,
                'status' => $statusLabel,
                'progress_percentage' => $progressPct,
                'is_completed' => $isCompleted,
            ];
        });

        $totalSiswa = $studentsData->count();
        $totalSelesai = $studentsData->where('is_completed', true)->count();
        $totalSedang = $studentsData->where('is_completed', false)->filter(fn($s) => $s->progress_percentage > 0 || $s->status === 'Sedang Mengerjakan' || $s->status === 'Sedang Berjalan')->count();
        $totalBelum = max(0, $totalSiswa - $totalSelesai - $totalSedang);
        $avgProgress = $totalSiswa > 0 ? round($studentsData->avg('progress_percentage'), 1) : 0;

        return view('counselor.monitoring.students', compact(
            'kelas', 
            'studentsData', 
            'totalSiswa', 
            'totalSelesai', 
            'totalSedang', 
            'totalBelum', 
            'avgProgress'
        ));
    }

    public function studentDetail(Student $student)
    {
        $student->load(['user', 'kelas.school']);

        // Load other students in the same class for quick switcher
        $classStudents = Student::where('kelas_id', $student->kelas_id)
            ->with('user')
            ->get();

        // Load Topik 1 to 5 modules with their assessments & materials
        $modules = \App\Models\Module::where('status', true)
            ->where('urutan', '>=', 1)
            ->where('urutan', '<=', 5)
            ->orderBy('urutan')
            ->with(['assessments.questions.options', 'materials'])
            ->get();

        // Load all evaluations of this student
        $evaluations = \App\Models\StudentEvaluation::where('student_id', $student->id)
            ->get()
            ->keyBy('module_id');

        // Load all progresses of this student
        $progressList = \App\Models\StudentProgress::where('student_id', $student->id)
            ->with('assessment')
            ->get()
            ->keyBy('assessment_id');

        $timeline = $this->progressService->getProgressTimeline($student);
        $progressPercentage = $this->progressService->getProgressPercentage($student);
        $currentStage = $this->progressService->getCurrentStage($student);
        $statusLabel = $this->progressService->getCurrentStatusLabel($student);

        // Final Commitment Module (Pasca 5 Topik)
        $finalCommitmentModule = $this->progressService->getFinalCommitmentModule();
        if ($finalCommitmentModule) {
            $finalCommitmentModule->load(['assessments.questions.options', 'materials']);
        }

        return view('counselor.monitoring.student-detail', compact(
            'student',
            'classStudents',
            'modules',
            'finalCommitmentModule',
            'evaluations',
            'progressList',
            'timeline',
            'progressPercentage',
            'currentStage',
            'statusLabel'
        ));
    }
}
