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
        
        $topiks = \App\Models\Module::where('urutan', '>=', 1)
            ->where('urutan', '<=', 5)
            ->orderBy('urutan')
            ->with(['assessments.questions'])
            ->get();
            
        // Pre-test module
        $preTestModule = \App\Models\Module::where('urutan', 0)->first();
        $preTest = null;
        $preTestCompleted = false;
        if ($preTestModule) {
            $preTest = $preTestModule->assessments->where('jenis', 'pre_test')->first();
            if ($preTest) {
                $preTestCompleted = $this->progressService->isAssessmentCompleted($student, $preTest);
            }
        }
        
        // Post-test module
        $postTestModule = \App\Models\Module::where('urutan', 6)->first();
        $postTest = null;
        $postTestCompleted = false;
        if ($postTestModule) {
            $postTest = $postTestModule->assessments->where('jenis', 'post_test')->first();
            if ($postTest) {
                $postTestCompleted = $this->progressService->isAssessmentCompleted($student, $postTest);
            }
        }
        
        // Determine if they completed all 5 topic LKPDs
        $completedAllLkpd = true;
        foreach ($topiks as $t) {
            $lkpd = $t->assessments->where('jenis', \App\Models\Assessment::JENIS_LKPD)->first();
            if ($lkpd && !$this->progressService->isAssessmentCompleted($student, $lkpd)) {
                $completedAllLkpd = false;
            }
        }
        
        $progressPercentage = $this->progressService->getProgressPercentage($student);
        
        return view('student.roadmap', compact(
            'student', 
            'topiks', 
            'preTest', 
            'preTestCompleted', 
            'postTest', 
            'postTestCompleted', 
            'completedAllLkpd', 
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
