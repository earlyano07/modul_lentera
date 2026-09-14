<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Student;
use App\Models\StudentProgress;
use App\Services\ProgressService;

class ReportController extends Controller
{
    public function __construct(protected ProgressService $progressService) {}

    public function student(Student $student)
    {
        $student->load(['user', 'kelas.school']);
        $timeline = $this->progressService->getProgressTimeline($student);
        $progressPercentage = $this->progressService->getProgressPercentage($student);
        $assessmentResults = StudentProgress::where('student_id', $student->id)
            ->whereNotNull('assessment_id')->where('status', 'selesai')
            ->with(['assessment.module'])->orderBy('finished_at')->get();
        return view('counselor.reports.student', compact('student', 'timeline', 'progressPercentage', 'assessmentResults'));
    }

    public function studentPdf(Student $student)
    {
        $student->load(['user', 'kelas.school']);
        $timeline = $this->progressService->getProgressTimeline($student);
        $progressPercentage = $this->progressService->getProgressPercentage($student);
        $assessmentResults = StudentProgress::where('student_id', $student->id)
            ->whereNotNull('assessment_id')->where('status', 'selesai')
            ->with(['assessment.module'])->orderBy('finished_at')->get();
        return view('counselor.reports.pdf.student-report', compact('student', 'timeline', 'progressPercentage', 'assessmentResults'));
    }

    public function kelas(Kelas $kelas)
    {
        $kelas->load('school');
        $students = $kelas->students()->with('user')->get();
        $studentsData = $students->map(function ($student) {
            $assessmentResults = StudentProgress::where('student_id', $student->id)
                ->whereNotNull('assessment_id')->where('status', 'selesai')
                ->with(['assessment'])->get();
            return (object) [
                'student' => $student,
                'progress_percentage' => $this->progressService->getProgressPercentage($student),
                'is_completed' => $this->progressService->isProgramCompleted($student),
                'assessment_results' => $assessmentResults,
                'average_score' => $assessmentResults->avg('nilai') ?? 0,
            ];
        });
        return view('counselor.reports.kelas', compact('kelas', 'studentsData'));
    }

    public function kelasPdf(Kelas $kelas)
    {
        $kelas->load('school');
        $students = $kelas->students()->with('user')->get();
        $studentsData = $students->map(function ($student) {
            $assessmentResults = StudentProgress::where('student_id', $student->id)
                ->whereNotNull('assessment_id')->where('status', 'selesai')
                ->with(['assessment'])->get();
            return (object) [
                'student' => $student,
                'progress_percentage' => $this->progressService->getProgressPercentage($student),
                'is_completed' => $this->progressService->isProgramCompleted($student),
                'assessment_results' => $assessmentResults,
                'average_score' => $assessmentResults->avg('nilai') ?? 0,
            ];
        });
        return view('counselor.reports.pdf.kelas-report', compact('kelas', 'studentsData'));
    }
}
