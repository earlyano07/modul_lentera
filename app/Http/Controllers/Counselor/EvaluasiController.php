<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Module;
use App\Models\School;
use App\Models\Student;
use App\Models\StudentEvaluation;
use App\Models\StudentProgress;
use Illuminate\Http\Request;

class EvaluasiController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $counselor = $user->konselor;
        if (!$counselor) {
            $counselor = \App\Models\Konselor::firstOrCreate(
                ['user_id' => $user->id],
                ['nip' => '-', 'no_hp' => '-']
            );
        }

        $schools = $counselor->schools()->withCount('kelas')->orderBy('nama')->get();

        // Check if student_id requested to auto-select their school and class
        $requestedStudent = null;
        if ($request->filled('student_id')) {
            $requestedStudent = Student::with('kelas.school')->find($request->query('student_id'));
        }

        // Active School
        $selectedSchoolId = $request->query('school_id') 
            ?? $requestedStudent?->kelas?->school_id 
            ?? $schools->first()?->id;
        $selectedSchool = $schools->firstWhere('id', $selectedSchoolId) ?? $schools->first();

        // Classes for the selected school
        $kelasList = $selectedSchool 
            ? Kelas::where('school_id', $selectedSchool->id)->withCount('students')->orderBy('nama_kelas')->get() 
            : collect();

        // Active Class
        $selectedKelasId = $request->query('kelas_id') 
            ?? $requestedStudent?->kelas_id 
            ?? $kelasList->first()?->id;
        $selectedKelas = $kelasList->firstWhere('id', $selectedKelasId) ?? $kelasList->first();

        // Modules (Topik 1-5)
        $modules = Module::where('urutan', '>=', 1)
            ->where('urutan', '<=', 5)
            ->orderBy('urutan')
            ->with(['assessments.questions.options'])
            ->get();

        $selectedModuleId = $request->query('module_id') ?? $modules->first()?->id;
        $selectedModule = $modules->firstWhere('id', $selectedModuleId) ?? $modules->first();

        // 3 Instruments for selected module:
        // 1. Penilaian Diri
        $selfAssessment = $selectedModule?->assessments->first(function ($a) {
            return $a->jenis === 'penilaian_diri' || str_contains(strtolower($a->judul), 'penilaian diri') || str_contains(strtolower($a->judul), 'self');
        });

        // 2. Refleksi Diri
        $refleksiAssessment = $selectedModule?->assessments->first(function ($a) {
            return $a->jenis === 'refleksi_diri' || $a->jenis === 'lkpd' || str_contains(strtolower($a->judul), 'refleksi') || str_contains(strtolower($a->judul), 'lkpd') || str_contains(strtolower($a->judul), 'lembar kerja');
        });

        // 3. Lembar Komitmen
        $commitmentAssessment = $selectedModule?->assessments->first(function ($a) {
            return $a->jenis === 'lembar_komitmen' || str_contains(strtolower($a->judul), 'komitmen') || str_contains(strtolower($a->judul), 'commitment');
        });

        $maxSelfScore = $this->calculateAssessmentMaxScore($selfAssessment, 24);
        $maxRefleksiScore = $this->calculateAssessmentMaxScore($refleksiAssessment, 16);
        $maxCommitmentScore = $this->calculateAssessmentMaxScore($commitmentAssessment, 6);
        $maxTotalScore = $maxSelfScore + $maxRefleksiScore + $maxCommitmentScore;

        // Load students
        $studentsQuery = Student::with(['user', 'kelas.school']);
        if ($selectedKelas) {
            $studentsQuery->where('kelas_id', $selectedKelas->id);
        } elseif ($selectedSchool) {
            $studentsQuery->whereHas('kelas', fn($q) => $q->where('school_id', $selectedSchool->id));
        } elseif ($schools->isNotEmpty()) {
            $studentsQuery->whereHas('kelas', fn($q) => $q->whereIn('school_id', $schools->pluck('id')));
        }
        $students = $studentsQuery->get();

        $studentIds = $students->pluck('id');

        // Load evaluations for all students in this class for the selected module
        $evaluations = StudentEvaluation::whereIn('student_id', $studentIds)
            ->where('module_id', $selectedModule?->id ?? 0)
            ->get()
            ->keyBy('student_id');

        // Load assessment progresses for all students in this class
        $assessmentIds = array_filter([
            $selfAssessment?->id,
            $refleksiAssessment?->id,
            $commitmentAssessment?->id
        ]);

        $progresses = StudentProgress::whereIn('student_id', $studentIds)
            ->whereIn('assessment_id', $assessmentIds)
            ->where('status', 'selesai')
            ->get()
            ->groupBy('student_id');

        // Build data collection with student info, task completions, evaluation scores
        $studentsData = $students->map(function ($student) use (
            $evaluations, 
            $progresses, 
            $selfAssessment, 
            $refleksiAssessment, 
            $commitmentAssessment,
            $maxSelfScore,
            $maxRefleksiScore,
            $maxCommitmentScore,
            $maxTotalScore
        ) {
            $evaluation = $evaluations->get($student->id);
            $studentProg = $progresses->get($student->id, collect());

            $selfProg = $selfAssessment ? $studentProg->firstWhere('assessment_id', $selfAssessment->id) : null;
            $refleksiProg = $refleksiAssessment ? $studentProg->firstWhere('assessment_id', $refleksiAssessment->id) : null;
            $commitProg = $commitmentAssessment ? $studentProg->firstWhere('assessment_id', $commitmentAssessment->id) : null;

            // Suggested scores based on student's actual work
            $recSelf = null;
            if ($selfProg && $selfProg->nilai !== null) {
                $score = (float) $selfProg->nilai;
                $recSelf = (int) ($score > $maxSelfScore ? round(($score / 100) * $maxSelfScore) : $score);
            }

            $recRefleksi = null;
            if ($refleksiProg && $refleksiProg->nilai !== null) {
                $score = (float) $refleksiProg->nilai;
                $recRefleksi = (int) ($score > $maxRefleksiScore ? round(($score / 100) * $maxRefleksiScore) : $score);
            }

            $recCommit = null;
            if ($commitProg && $commitProg->nilai !== null) {
                $score = (float) $commitProg->nilai;
                $recCommit = (int) ($score > $maxCommitmentScore ? round(($score / 100) * $maxCommitmentScore) : $score);
            }

            $isFullyEvaluated = $evaluation && $evaluation->self_score !== null && $evaluation->lkpd_score !== null && $evaluation->commitment_score !== null;
            $isFullyDoneByStudent = $selfProg !== null && $refleksiProg !== null && $commitProg !== null;

            if ($isFullyEvaluated) {
                $overall = $evaluation->getOverallDetails();
                $totalScore = ($evaluation->self_score ?? 0) + ($evaluation->lkpd_score ?? 0) + ($evaluation->commitment_score ?? 0);
            } elseif ($isFullyDoneByStudent) {
                $sScore = $recSelf ?? 0;
                $rScore = $recRefleksi ?? 0;
                $cScore = $recCommit ?? 0;
                $totalScore = $sScore + $rScore + $cScore;
                $avgPct = round(((float)$selfProg->nilai + (float)$refleksiProg->nilai + (float)$commitProg->nilai) / 3, 1);
                $cat = StudentEvaluation::getCategoryFromPercentage($avgPct);
                $overall = [
                    'average_code' => $avgPct,
                    'percentage' => $avgPct,
                    'total_score' => $totalScore,
                    'total_max' => $maxTotalScore,
                    'category' => $cat['category'],
                    'meaning' => $cat['meaning'],
                    'color' => $cat['color'],
                    'badge' => $cat['badge'],
                    'is_provisional' => true,
                ];
            } else {
                $overall = null;
                $totalScore = ($evaluation?->self_score ?? $recSelf ?? 0) + ($evaluation?->lkpd_score ?? $recRefleksi ?? 0) + ($evaluation?->commitment_score ?? $recCommit ?? 0);
            }

            return [
                'id' => $student->id,
                'name' => $student->user->nama ?? 'Siswa',
                'nis' => $student->nis ?? '-',
                'kelas_nama' => $student->kelas->nama_kelas ?? '-',
                'school_nama' => $student->kelas->school->nama ?? '-',
                'is_evaluated' => $evaluation !== null,
                'evaluation_id' => $evaluation?->id,
                'is_fully_evaluated' => $isFullyEvaluated,
                'is_fully_done' => $isFullyDoneByStudent,
                
                'self_done' => $selfProg !== null,
                'self_nilai' => $selfProg ? (float)$selfProg->nilai : null,
                'refleksi_done' => $refleksiProg !== null,
                'refleksi_nilai' => $refleksiProg ? (float)$refleksiProg->nilai : null,
                'commit_done' => $commitProg !== null,
                'commit_nilai' => $commitProg ? (float)$commitProg->nilai : null,

                'current_self_score' => $evaluation?->self_score ?? $recSelf ?? 0,
                'current_refleksi_score' => $evaluation?->lkpd_score ?? $recRefleksi ?? 0,
                'current_commit_score' => $evaluation?->commitment_score ?? $recCommit ?? 0,

                // Legacy aliases
                'lkpd_done' => $refleksiProg !== null,
                'lkpd_nilai' => $refleksiProg ? (float)$refleksiProg->nilai : null,
                'current_lkpd_score' => $evaluation?->lkpd_score ?? $recRefleksi ?? 0,

                'current_notes' => $evaluation?->counselor_note ?? '',
                
                'self_evaluated' => $evaluation && $evaluation->self_score !== null,
                'refleksi_evaluated' => $evaluation && $evaluation->lkpd_score !== null,
                'commit_evaluated' => $evaluation && $evaluation->commitment_score !== null,

                // Per-assessment details (Category, Meaning, Percentage, Badge)
                'self_details' => ($evaluation && $evaluation->self_score !== null)
                    ? $evaluation->getSelfDetails()
                    : ($selfProg && $selfProg->nilai !== null ? StudentEvaluation::getCategoryFromPercentage((float)$selfProg->nilai) : null),
                'refleksi_details' => ($evaluation && $evaluation->lkpd_score !== null)
                    ? $evaluation->getRefleksiDetails()
                    : ($refleksiProg && $refleksiProg->nilai !== null ? StudentEvaluation::getCategoryFromPercentage((float)$refleksiProg->nilai) : null),
                'commit_details' => ($evaluation && $evaluation->commitment_score !== null)
                    ? $evaluation->getCommitmentDetails()
                    : ($commitProg && $commitProg->nilai !== null ? StudentEvaluation::getCategoryFromPercentage((float)$commitProg->nilai) : null),

                'total_score' => $totalScore,
                'max_total_score' => $maxTotalScore,
                'overall_percentage' => $overall['percentage'] ?? null,
                'overall_category' => $overall['category'] ?? 'Belum Lengkap',
                'overall_code' => $overall['average_code'] ?? 0,
                'overall_meaning' => $overall['meaning'] ?? '',
                'overall_color' => $overall['color'] ?? 'slate',
                'overall_badge' => $overall['badge'] ?? 'bg-slate-100 text-slate-500 border-slate-200',

                'rec_self' => $recSelf,
                'rec_refleksi' => $recRefleksi,
                'rec_commit' => $recCommit,
                'rec_lkpd' => $recRefleksi,
            ];
        });

        $totalStudents = $studentsData->count();
        $evaluatedCount = $studentsData->where('is_evaluated', true)->count();
        $pendingCount = $totalStudents - $evaluatedCount;

        // Auto open modal student ID if requested
        $autoOpenStudentId = $requestedStudent?->id ?? null;

        return view('counselor.evaluasi.index', [
            'schools' => $schools,
            'selectedSchool' => $selectedSchool,
            'kelasList' => $kelasList,
            'selectedKelas' => $selectedKelas,
            'modules' => $modules,
            'selectedModule' => $selectedModule,
            'students' => $students,
            'studentsData' => $studentsData,
            'totalStudents' => $totalStudents,
            'evaluatedCount' => $evaluatedCount,
            'pendingCount' => $pendingCount,
            'maxSelfScore' => $maxSelfScore,
            'maxRefleksiScore' => $maxRefleksiScore,
            'maxCommitmentScore' => $maxCommitmentScore,
            'maxTotalScore' => $maxTotalScore,
            'tindakLanjutGuidelines' => StudentEvaluation::getAllTindakLanjutGuidelines(),
            // legacy variable aliases
            'maxLkpdScore' => $maxRefleksiScore,
            'autoOpenStudentId' => $autoOpenStudentId,
        ]);
    }

    public function store(Request $request)
    {
        $module = Module::with('assessments.questions.options')->find($request->module_id);
        
        $selfAssessment = $module?->assessments->first(function ($a) {
            return $a->jenis === 'penilaian_diri' || str_contains(strtolower($a->judul), 'penilaian diri') || str_contains(strtolower($a->judul), 'self');
        });

        $refleksiAssessment = $module?->assessments->first(function ($a) {
            return $a->jenis === 'refleksi_diri' || $a->jenis === 'lkpd' || str_contains(strtolower($a->judul), 'refleksi') || str_contains(strtolower($a->judul), 'lkpd') || str_contains(strtolower($a->judul), 'lembar kerja');
        });

        $commitmentAssessment = $module?->assessments->first(function ($a) {
            return $a->jenis === 'lembar_komitmen' || str_contains(strtolower($a->judul), 'komitmen') || str_contains(strtolower($a->judul), 'commitment');
        });

        $maxSelf = $this->calculateAssessmentMaxScore($selfAssessment, 24);
        $maxRefleksi = $this->calculateAssessmentMaxScore($refleksiAssessment, 20);
        $maxCommitment = $this->calculateAssessmentMaxScore($commitmentAssessment, 6);

        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'module_id' => 'required|exists:modules,id',
            'self_score' => "nullable|integer|min:0|max:{$maxSelf}",
            'refleksi_score' => "nullable|integer|min:0|max:{$maxRefleksi}",
            'lkpd_score' => "nullable|integer|min:0|max:{$maxRefleksi}",
            'commitment_score' => "required|integer|min:0|max:{$maxCommitment}",
            'notes' => 'nullable|string',
            'lkpd_note' => 'nullable|string',
            'self_note' => 'nullable|string',
            'commitment_note' => 'nullable|string',
            'school_id' => 'nullable|exists:schools,id',
            'kelas_id' => 'nullable|exists:kelas,id',
        ]);

        $finalRefleksiScore = $validated['refleksi_score'] ?? $validated['lkpd_score'] ?? 0;
        $finalSelfScore = $validated['self_score'] ?? 0;

        StudentEvaluation::updateOrCreate(
            [
                'student_id' => $validated['student_id'],
                'module_id' => $validated['module_id'],
            ],
            [
                'lkpd_score' => $finalRefleksiScore,
                'self_score' => $finalSelfScore,
                'commitment_score' => $validated['commitment_score'],
                'notes' => $validated['notes'] ?? ($validated['lkpd_note'] ?? ($validated['self_note'] ?? ($validated['commitment_note'] ?? null))),
                'lkpd_note' => $validated['notes'] ?? ($validated['lkpd_note'] ?? null),
                'self_note' => $validated['notes'] ?? ($validated['self_note'] ?? null),
                'commitment_note' => $validated['notes'] ?? ($validated['commitment_note'] ?? null),
            ]
        );

        // Synchronize StudentProgress records so progress tracking stays 100% in sync
        if ($selfAssessment && $finalSelfScore > 0) {
            StudentProgress::updateOrCreate(
                [
                    'student_id' => $validated['student_id'],
                    'module_id' => $validated['module_id'],
                    'assessment_id' => $selfAssessment->id,
                ],
                [
                    'status' => 'selesai',
                    'nilai' => round(($finalSelfScore / max(1, $maxSelf)) * 100, 2),
                    'finished_at' => now(),
                ]
            );
        }

        if ($refleksiAssessment && $finalRefleksiScore > 0) {
            StudentProgress::updateOrCreate(
                [
                    'student_id' => $validated['student_id'],
                    'module_id' => $validated['module_id'],
                    'assessment_id' => $refleksiAssessment->id,
                ],
                [
                    'status' => 'selesai',
                    'nilai' => round(($finalRefleksiScore / max(1, $maxRefleksi)) * 100, 2),
                    'finished_at' => now(),
                ]
            );
        }

        if ($commitmentAssessment && isset($validated['commitment_score'])) {
            StudentProgress::updateOrCreate(
                [
                    'student_id' => $validated['student_id'],
                    'module_id' => $validated['module_id'],
                    'assessment_id' => $commitmentAssessment->id,
                ],
                [
                    'status' => 'selesai',
                    'nilai' => round(($validated['commitment_score'] / max(1, $maxCommitment)) * 100, 2),
                    'finished_at' => now(),
                ]
            );
        }

        $student = Student::with('kelas')->find($validated['student_id']);

        // Build redirect parameters cleanly preserving context
        $redirectParams = [
            'student_id' => $validated['student_id'],
            'module_id' => $validated['module_id'],
        ];

        if (!empty($validated['school_id'])) {
            $redirectParams['school_id'] = $validated['school_id'];
        }
        if (!empty($validated['kelas_id'])) {
            $redirectParams['kelas_id'] = $validated['kelas_id'];
        }

        return redirect()->route('counselor.evaluasi', $redirectParams)
            ->with('success', 'Hasil evaluasi untuk ' . ($student?->user?->nama ?? 'siswa') . ' berhasil disimpan.');
    }

    private function calculateAssessmentMaxScore(?\App\Models\Assessment $assessment, int $fallback = 16): int
    {
        if (!$assessment || $assessment->questions->isEmpty()) {
            return $fallback;
        }

        $totalMax = 0;
        foreach ($assessment->questions as $question) {
            $maxOpt = $question->options->max('score');
            if ($maxOpt !== null && $maxOpt > 0) {
                $totalMax += $maxOpt;
            } elseif ($question->score > 0) {
                $totalMax += $question->score;
            } else {
                $totalMax += ($question->tipe === 'essay' ? 10 : 1);
            }
        }

        return $totalMax > 0 ? (int)$totalMax : $fallback;
    }
}
