<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\StudentProgress;
use App\Services\ProgressService;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function __construct(protected ProgressService $progressService) {}

    public function show(Assessment $assessment)
    {
        $student = auth()->user()->student;
        if (!$this->progressService->canAccessAssessment($student, $assessment)) {
            return redirect()->route('student.roadmap')->with('error', 'Anda belum dapat mengakses assessment ini.');
        }
        if ($this->progressService->isAssessmentCompleted($student, $assessment)) {
            return redirect()->route('student.assessment.result', $assessment);
        }
        $assessment->load(['module', 'questions.options']);
        return view('student.assessment.show', compact('assessment'));
    }

    public function start(Assessment $assessment)
    {
        $student = auth()->user()->student;
        if (!$this->progressService->canAccessAssessment($student, $assessment)) {
            return redirect()->route('student.roadmap')->with('error', 'Anda belum dapat mengakses assessment ini.');
        }
        $this->progressService->startAssessment($student, $assessment);
        $assessment->load(['questions.options']);
        return view('student.assessment.questions', compact('assessment'));
    }

    public function submit(Request $request, Assessment $assessment)
    {
        $student = auth()->user()->student;
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|integer|exists:question_options,id',
        ]);
        $this->progressService->completeAssessment($student, $assessment, $validated['answers']);
        return redirect()->route('student.assessment.result', $assessment)->with('success', 'Assessment berhasil diselesaikan!');
    }

    public function result(Assessment $assessment)
    {
        $student = auth()->user()->student;
        $progress = StudentProgress::where('student_id', $student->id)
            ->where('assessment_id', $assessment->id)->first();
        if (!$progress || $progress->status !== 'selesai') {
            return redirect()->route('student.assessment.show', $assessment);
        }
        $assessment->load('module');
        return view('student.assessment.result', compact('assessment', 'progress'));
    }
}
