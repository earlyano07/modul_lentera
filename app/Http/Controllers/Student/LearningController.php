<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Module;
use App\Services\ProgressService;

class LearningController extends Controller
{
    public function __construct(protected ProgressService $progressService) {}

    public function roadmap()
    {
        $student = auth()->user()->student;
        if (!$student) { abort(404, 'Data siswa tidak ditemukan.'); }
        
        $topiks = Module::where('status', true)
            ->whereBetween('urutan', [1, 5])
            ->orderBy('urutan')
            ->with(['assessments.questions'])
            ->get();
            
        $hasCompletedAllTopics = $this->progressService->hasCompletedAllTopics($student);

        // Final Commitment Module (Tahap Akhir Pasca 5 Topik)
        $finalCommitmentModule = $this->progressService->getFinalCommitmentModule();
        if ($finalCommitmentModule) {
            $finalCommitmentModule->load(['assessments.questions']);
        }
        
        $hasCompletedFinalCommitment = $this->progressService->hasCompletedFinalCommitment($student);
        $canAccessCommitment = $hasCompletedAllTopics && $finalCommitmentModule ? $this->progressService->canAccessModule($student, $finalCommitmentModule) : false;
        $isProgramCompleted = $this->progressService->isProgramCompleted($student);
        
        $progressPercentage = $this->progressService->getProgressPercentage($student);
        
        return view('student.roadmap', compact(
            'student', 
            'topiks', 
            'hasCompletedAllTopics',
            'finalCommitmentModule',
            'hasCompletedFinalCommitment',
            'canAccessCommitment',
            'isProgramCompleted',
            'progressPercentage'
        ));
    }

    public function module(Module $module)
    {
        $student = auth()->user()->student;
        if (!$this->progressService->canAccessModule($student, $module)) {
            return redirect()->route('student.roadmap')->with('error', 'Anda belum dapat mengakses tahap ini.');
        }
        $module->load(['materials' => fn($q) => $q->orderBy('urutan'), 'assessments']);
        return view('student.learning.module', compact('module'));
    }

    public function material(Material $material)
    {
        $student = auth()->user()->student;
        if (!$this->progressService->canAccessModule($student, $material->module)) {
            return redirect()->route('student.roadmap')->with('error', 'Anda belum dapat mengakses materi ini.');
        }
        $material->load('module');
        return view('student.learning.material', compact('material'));
    }
}
