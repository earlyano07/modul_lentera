<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Student;
use App\Models\StudentEvaluation;
use Illuminate\Http\Request;

class EvaluasiController extends Controller
{
    public function index(Request $request)
    {
        $counselor = auth()->user()->konselor;
        if (!$counselor) {
            return redirect()->route('dashboard')->with('error', 'Akses dibatasi hanya untuk Konselor.');
        }

        $schoolIds = $counselor->schools->pluck('id');
        $students = Student::whereHas('kelas', function ($query) use ($schoolIds) {
            $query->whereIn('school_id', $schoolIds);
        })->with(['user', 'kelas.school'])->get();

        $modules = Module::where('urutan', '>=', 1)->where('urutan', '<=', 5)->orderBy('urutan')->get();

        $selectedStudentId = $request->query('student_id') ?? $students->first()?->id;
        $selectedStudent = $students->firstWhere('id', $selectedStudentId) ?? $students->first();

        $selectedModuleId = $request->query('module_id') ?? $modules->first()?->id;
        $selectedModule = $modules->firstWhere('id', $selectedModuleId) ?? $modules->first();

        if ($selectedModule) {
            $selectedModule->load('assessments.questions');
        }

        $lkpdAssessment = $selectedModule?->assessments->first(function ($a) {
            return $a->jenis === 'lkpd' || str_contains(strtolower($a->judul), 'lkpd') || str_contains(strtolower($a->judul), 'lembar kerja') || $a->urutan == 1;
        });

        $selfAssessment = $selectedModule?->assessments->first(function ($a) {
            return $a->jenis === 'penilaian_diri' || str_contains(strtolower($a->judul), 'penilaian diri') || str_contains(strtolower($a->judul), 'self') || $a->urutan == 2;
        });

        $commitmentAssessment = $selectedModule?->assessments->first(function ($a) {
            return $a->jenis === 'lembar_komitmen' || str_contains(strtolower($a->judul), 'komitmen') || str_contains(strtolower($a->judul), 'commitment') || $a->urutan == 3;
        });

        // Skor maksimal dihitung dari total skor/jumlah seluruh pertanyaan (jika semua benar)
        $maxLkpdScore = $lkpdAssessment ? ($lkpdAssessment->questions->sum('score') ?: $lkpdAssessment->questions->count() ?: 20) : 20;
        $maxSelfScore = $selfAssessment ? ($selfAssessment->questions->sum('score') ?: $selfAssessment->questions->count() ?: 20) : 20;
        $maxCommitmentScore = $commitmentAssessment ? ($commitmentAssessment->questions->sum('score') ?: $commitmentAssessment->questions->count() ?: 6) : 6;

        $evaluation = null;
        $assessmentProgress = null;
        $recommendedScores = [
            'lkpd' => null,
            'self' => null,
            'commitment' => null,
        ];

        if ($selectedStudent && $selectedModule) {
            $evaluation = StudentEvaluation::where('student_id', $selectedStudent->id)
                ->where('module_id', $selectedModule->id)
                ->first();

            $lkpdProgress = $lkpdAssessment ? \App\Models\StudentProgress::where('student_id', $selectedStudent->id)
                ->where('assessment_id', $lkpdAssessment->id)
                ->where('status', 'selesai')
                ->first() : null;

            $selfProgress = $selfAssessment ? \App\Models\StudentProgress::where('student_id', $selectedStudent->id)
                ->where('assessment_id', $selfAssessment->id)
                ->where('status', 'selesai')
                ->first() : null;

            $commitmentProgress = $commitmentAssessment ? \App\Models\StudentProgress::where('student_id', $selectedStudent->id)
                ->where('assessment_id', $commitmentAssessment->id)
                ->where('status', 'selesai')
                ->first() : null;

            $assessmentProgress = $lkpdProgress ?? $selfProgress ?? $commitmentProgress ?? \App\Models\StudentProgress::where('student_id', $selectedStudent->id)
                ->where('module_id', $selectedModule->id)
                ->whereNotNull('assessment_id')
                ->with('assessment')
                ->latest()
                ->first();

            if ($lkpdProgress && $lkpdProgress->nilai !== null) {
                $score = (float) $lkpdProgress->nilai;
                $recommendedScores['lkpd'] = (int) ($score > $maxLkpdScore ? round(($score / 100) * $maxLkpdScore) : $score);
            }

            if ($selfProgress && $selfProgress->nilai !== null) {
                $score = (float) $selfProgress->nilai;
                $recommendedScores['self'] = (int) ($score > $maxSelfScore ? round(($score / 100) * $maxSelfScore) : $score);
            }

            if ($commitmentProgress && $commitmentProgress->nilai !== null) {
                $score = (float) $commitmentProgress->nilai;
                $recommendedScores['commitment'] = (int) ($score > $maxCommitmentScore ? round(($score / 100) * $maxCommitmentScore) : $score);
            }

            if (!$evaluation && ($recommendedScores['lkpd'] !== null || $recommendedScores['self'] !== null || $recommendedScores['commitment'] !== null)) {
                $evaluation = new StudentEvaluation([
                    'student_id' => $selectedStudent->id,
                    'module_id' => $selectedModule->id,
                    'lkpd_score' => $recommendedScores['lkpd'],
                    'self_score' => $recommendedScores['self'],
                    'commitment_score' => $recommendedScores['commitment'],
                ]);
            }
        }

        return view('counselor.evaluasi.index', compact(
            'students',
            'modules',
            'selectedStudent',
            'selectedModule',
            'evaluation',
            'assessmentProgress',
            'lkpdProgress',
            'selfProgress',
            'commitmentProgress',
            'recommendedScores',
            'maxLkpdScore',
            'maxSelfScore',
            'maxCommitmentScore'
        ));
    }

    public function store(Request $request)
    {
        $module = Module::with('assessments.questions')->find($request->module_id);
        $lkpdAssessment = $module?->assessments->first(function ($a) {
            return $a->jenis === 'lkpd' || str_contains(strtolower($a->judul), 'lkpd') || str_contains(strtolower($a->judul), 'lembar kerja') || $a->urutan == 1;
        });
        $selfAssessment = $module?->assessments->first(function ($a) {
            return $a->jenis === 'penilaian_diri' || str_contains(strtolower($a->judul), 'penilaian diri') || str_contains(strtolower($a->judul), 'self') || $a->urutan == 2;
        });
        $commitmentAssessment = $module?->assessments->first(function ($a) {
            return $a->jenis === 'lembar_komitmen' || str_contains(strtolower($a->judul), 'komitmen') || str_contains(strtolower($a->judul), 'commitment') || $a->urutan == 3;
        });

        $maxLkpd = $lkpdAssessment ? ($lkpdAssessment->questions->sum('score') ?: $lkpdAssessment->questions->count() ?: 20) : 20;
        $maxSelf = $selfAssessment ? ($selfAssessment->questions->sum('score') ?: $selfAssessment->questions->count() ?: 20) : 20;
        $maxCommitment = $commitmentAssessment ? ($commitmentAssessment->questions->sum('score') ?: $commitmentAssessment->questions->count() ?: 6) : 6;

        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'module_id' => 'required|exists:modules,id',
            'lkpd_score' => "required|integer|min:0|max:{$maxLkpd}",
            'lkpd_note' => 'nullable|string',
            'self_score' => "required|integer|min:0|max:{$maxSelf}",
            'self_note' => 'nullable|string',
            'commitment_score' => "required|integer|min:0|max:{$maxCommitment}",
            'commitment_note' => 'nullable|string',
        ]);

        StudentEvaluation::updateOrCreate(
            [
                'student_id' => $validated['student_id'],
                'module_id' => $validated['module_id'],
            ],
            [
                'lkpd_score' => $validated['lkpd_score'],
                'lkpd_note' => $validated['lkpd_note'] ?? null,
                'self_score' => $validated['self_score'],
                'self_note' => $validated['self_note'] ?? null,
                'commitment_score' => $validated['commitment_score'],
                'commitment_note' => $validated['commitment_note'] ?? null,
            ]
        );

        return redirect()->route('counselor.evaluasi', [
            'student_id' => $validated['student_id'],
            'module_id' => $validated['module_id']
        ])->with('success', 'Hasil evaluasi berhasil disimpan.');
    }
}
