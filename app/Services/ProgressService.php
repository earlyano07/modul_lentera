<?php

namespace App\Services;

use App\Models\Assessment;
use App\Models\Module;
use App\Models\Student;
use App\Models\StudentProgress;
use App\Models\QuestionOption;
use Illuminate\Support\Collection;

class ProgressService
{
    /**
     * Get all modules in order (the learning path).
     */
    public function getModulesInOrder(): Collection
    {
        return Module::where('status', true)
            ->orderBy('urutan')
            ->get();
    }

    /**
     * Check if a student can access a specific module.
     */
    public function canAccessModule(Student $student, Module $module): bool
    {
        $modules = $this->getModulesInOrder();
        $moduleIndex = $modules->search(fn ($m) => $m->id === $module->id);

        // First module is always accessible
        if ($moduleIndex === 0) {
            return true;
        }

        // Check if previous module is completed
        $previousModule = $modules[$moduleIndex - 1] ?? null;
        if (!$previousModule) {
            return false;
        }

        return $this->isModuleCompleted($student, $previousModule);
    }

    /**
     * Check if a student can access a specific assessment.
     */
    public function canAccessAssessment(Student $student, Assessment $assessment): bool
    {
        // Check if the module itself is accessible
        if (!$this->canAccessModule($student, $assessment->module)) {
            return false;
        }

        return true;
    }

    /**
     * Check if a module is completed by a student.
     */
    public function isModuleCompleted(Student $student, Module $module): bool
    {
        $assessments = $module->assessments;
        if ($assessments->isEmpty()) {
            return StudentProgress::where('student_id', $student->id)
                ->where('module_id', $module->id)
                ->where('status', 'selesai')
                ->whereNull('assessment_id')
                ->exists();
        }

        // Must complete ALL assessments in this module
        foreach ($assessments as $assessment) {
            if (!$this->isAssessmentCompleted($student, $assessment)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if an assessment is completed by a student.
     */
    public function isAssessmentCompleted(Student $student, Assessment $assessment): bool
    {
        return StudentProgress::where('student_id', $student->id)
            ->where('assessment_id', $assessment->id)
            ->where('status', 'selesai')
            ->exists();
    }

    /**
     * Get the current active stage for a student.
     */
    public function getCurrentStage(Student $student): ?Module
    {
        $modules = $this->getModulesInOrder();

        foreach ($modules as $module) {
            if (!$this->isModuleCompleted($student, $module)) {
                return $module;
            }
        }

        return null; // All completed
    }

    /**
     * Get the current status label for a student.
     */
    public function getCurrentStatusLabel(Student $student): string
    {
        $currentModule = $this->getCurrentStage($student);

        if (!$currentModule) {
            return 'Program Selesai';
        }

        // Check if there's an in-progress assessment
        $inProgress = StudentProgress::where('student_id', $student->id)
            ->where('module_id', $currentModule->id)
            ->where('status', 'sedang_mengerjakan')
            ->exists();

        if ($inProgress) {
            return 'Sedang Mengerjakan';
        }

        // Check if any progress exists at all
        $hasProgress = StudentProgress::where('student_id', $student->id)->exists();

        return $hasProgress ? 'Belum Mulai Tahap Ini' : 'Belum Mulai';
    }

    /**
     * Start an assessment for a student.
     */
    public function startAssessment(Student $student, Assessment $assessment): StudentProgress
    {
        return StudentProgress::updateOrCreate(
            [
                'student_id' => $student->id,
                'module_id' => $assessment->module_id,
                'assessment_id' => $assessment->id,
            ],
            [
                'status' => 'sedang_mengerjakan',
                'started_at' => now(),
            ]
        );
    }

    /**
     * Submit assessment answers, calculate score, and unlock next stage.
     *
     * @param  array<int, int>  $answers  [question_id => selected_option_id]
     */
    public function completeAssessment(Student $student, Assessment $assessment, array $answers): StudentProgress
    {
        $score = $this->calculateScore($assessment, $answers);

        $progress = StudentProgress::updateOrCreate(
            [
                'student_id' => $student->id,
                'module_id' => $assessment->module_id,
                'assessment_id' => $assessment->id,
            ],
            [
                'status' => 'selesai',
                'nilai' => $score,
                'finished_at' => now(),
            ]
        );

        // Auto-integrate score into StudentEvaluation if module is within Topik 1-5
        if ($assessment->module_id) {
            $evaluation = \App\Models\StudentEvaluation::firstOrNew([
                'student_id' => $student->id,
                'module_id' => $assessment->module_id,
            ]);

            $earnedScore = (int) $score;

            if ($assessment->jenis === 'penilaian_diri' || str_contains(strtolower($assessment->judul), 'penilaian diri')) {
                $evaluation->self_score = $earnedScore;
            } elseif ($assessment->jenis === 'lembar_komitmen' || str_contains(strtolower($assessment->judul), 'komitmen')) {
                $evaluation->commitment_score = $earnedScore;
            } else {
                $evaluation->lkpd_score = $earnedScore;
            }

            $evaluation->save();
        }

        return $progress;
    }

    /**
     * Calculate score from multiple choice answers (direct sum of correct answer points).
     *
     * @param  array<int, int>  $answers  [question_id => selected_option_id]
     */
    public function calculateScore(Assessment $assessment, array $answers): float
    {
        $questions = $assessment->questions()->with('options')->get();
        $earnedScore = 0;

        foreach ($questions as $question) {
            $selectedOptionId = $answers[$question->id] ?? null;
            if ($selectedOptionId) {
                $isCorrect = QuestionOption::where('id', $selectedOptionId)
                    ->where('question_id', $question->id)
                    ->where('is_correct', true)
                    ->exists();

                if ($isCorrect) {
                    $earnedScore += ($question->score ?: 1);
                }
            }
        }

        return (float) $earnedScore;
    }

    public function getProgressTimeline(Student $student): Collection
    {
        $modules = $this->getModulesInOrder();
        $timeline = collect();
        $previousCompleted = true;

        foreach ($modules as $module) {
            $hasMaterials = $module->materials()->exists();
            
            // Module progress
            $moduleProgress = StudentProgress::where('student_id', $student->id)
                ->where('module_id', $module->id)
                ->whereNull('assessment_id')
                ->first();

            // Determine if the module (Topic) is available
            $moduleStatus = $previousCompleted ? 'available' : 'locked';
            
            // Check if any progress exists for this module's materials
            if ($moduleProgress?->status === 'selesai') {
                $moduleStatus = 'completed';
            } elseif ($moduleProgress?->status === 'sedang_mengerjakan') {
                $moduleStatus = 'in_progress';
            }

            if ($hasMaterials) {
                $timeline->push([
                    'type' => 'module',
                    'module' => $module,
                    'title' => $module->judul,
                    'description' => $module->deskripsi,
                    'type_label' => 'Topik',
                    'status' => $moduleStatus,
                    'url' => route('student.module', $module->id),
                    'icon' => match ($moduleStatus) {
                        'completed' => '✓',
                        'in_progress' => '⏳',
                        'available' => '▶',
                        default => '🔒',
                    },
                    'completed_at' => $moduleProgress?->finished_at,
                ]);

                // To unlock assessments, the student must have finished the main topic materials first
                if ($moduleStatus !== 'completed') {
                    $previousCompleted = false;
                }
            }

            // Loop through all assessments of this module
            $assessments = $module->assessments()->orderBy('urutan')->get();
            
            foreach ($assessments as $assessment) {
                $assessmentProgress = StudentProgress::where('student_id', $student->id)
                    ->where('assessment_id', $assessment->id)
                    ->first();

                $assessmentStatus = 'locked';
                if ($previousCompleted) {
                    $assessmentStatus = 'available';
                }
                
                if ($assessmentProgress?->status === 'selesai') {
                    $assessmentStatus = 'completed';
                } elseif ($assessmentProgress?->status === 'sedang_mengerjakan') {
                    $assessmentStatus = 'in_progress';
                }

                $typeLabel = match ($assessment->jenis) {
                    'pre_test' => 'Pre-Test',
                    'post_test' => 'Post-Test',
                    'lkpd' => 'LKPD',
                    default => 'Asesmen',
                };

                $timeline->push([
                    'type' => 'assessment',
                    'assessment' => $assessment,
                    'module' => $module,
                    'title' => $assessment->judul,
                    'description' => 'Evaluasi/LKPD untuk ' . $module->judul,
                    'type_label' => $typeLabel,
                    'status' => $assessmentStatus,
                    'url' => route('student.assessment.show', $assessment->id),
                    'score' => $assessmentProgress?->nilai,
                    'icon' => match ($assessmentStatus) {
                        'completed' => '✓',
                        'in_progress' => '⏳',
                        'available' => '▶',
                        default => '🔒',
                    },
                    'completed_at' => $assessmentProgress?->finished_at,
                ]);

                $previousCompleted = $assessmentProgress?->status === 'selesai';
            }

            if ($assessments->isEmpty()) {
                $previousCompleted = $moduleStatus === 'completed';
            }
        }

        return $timeline;
    }

    /**
     * Calculate overall progress percentage for a student.
     */
    public function getProgressPercentage(Student $student): float
    {
        $modules = $this->getModulesInOrder();
        $totalSteps = $modules->count();

        if ($totalSteps === 0) {
            return 0;
        }

        $completedSteps = 0;
        foreach ($modules as $module) {
            if ($this->isModuleCompleted($student, $module)) {
                $completedSteps++;
            }
        }

        return round(($completedSteps / $totalSteps) * 100, 2);
    }

    /**
     * Check if the entire program is completed.
     */
    public function isProgramCompleted(Student $student): bool
    {
        return $this->getCurrentStage($student) === null;
    }
}
