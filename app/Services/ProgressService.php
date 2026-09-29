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
        $modules = $this->getModulesInOrder()->filter(function ($m) {
            // Filter out empty modules that have no materials and no assessments
            return $m->status && ($m->materials()->exists() || $m->assessments()->exists());
        })->values();

        $moduleIndex = $modules->search(fn ($m) => $m->id === $module->id);

        // First module is always accessible
        if ($moduleIndex === 0 || $moduleIndex === false) {
            return true;
        }

        // Check if previous module is completed
        $previousModule = $modules[$moduleIndex - 1] ?? null;
        if (!$previousModule) {
            return true;
        }

        return $this->isModuleCompleted($student, $previousModule);
    }

    /**
     * Check if a student can access a specific assessment.
     */
    public function canAccessAssessment(Student $student, Assessment $assessment): bool
    {
        // Check if the module itself is accessible
        if ($assessment->module && !$this->canAccessModule($student, $assessment->module)) {
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
        $materials = $module->materials;

        // If module has neither materials nor assessments, it is trivially completed
        if ($assessments->isEmpty() && $materials->isEmpty()) {
            return true;
        }

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
        $hasProgress = StudentProgress::where('student_id', $student->id)
            ->where('assessment_id', $assessment->id)
            ->where('status', 'selesai')
            ->exists();

        if ($hasProgress) {
            return true;
        }

        // Also check if StudentEvaluation has a recorded score for this assessment
        if ($assessment->module_id) {
            $evaluation = \App\Models\StudentEvaluation::where('student_id', $student->id)
                ->where('module_id', $assessment->module_id)
                ->first();

            if ($evaluation) {
                if (($assessment->jenis === 'penilaian_diri' || str_contains(strtolower($assessment->judul), 'penilaian diri')) && $evaluation->self_score !== null) {
                    return true;
                }
                if (($assessment->jenis === 'lembar_komitmen' || str_contains(strtolower($assessment->judul), 'komitmen')) && $evaluation->commitment_score !== null) {
                    return true;
                }
                if (($assessment->jenis === 'refleksi_diri' || $assessment->jenis === 'lkpd' || str_contains(strtolower($assessment->judul), 'refleksi') || str_contains(strtolower($assessment->judul), 'lkpd')) && $evaluation->lkpd_score !== null) {
                    return true;
                }
            }
        }

        return false;
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
     * Get the current active assessment that the student should work on next.
     */
    public function getCurrentActiveAssessment(Student $student, ?Module $currentModule = null): ?Assessment
    {
        $module = $currentModule ?? $this->getCurrentStage($student);
        if (!$module) {
            return null;
        }

        $assessments = $module->assessments()->orderBy('urutan')->get();
        foreach ($assessments as $assessment) {
            if (!$this->isAssessmentCompleted($student, $assessment)) {
                return $assessment;
            }
        }

        return null;
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
            ->where('status', 'sedang_mengerjakan')
            ->exists();

        if ($inProgress) {
            return 'Sedang Mengerjakan';
        }

        // Check if student has completed any assessment in this or any module
        $hasAnyCompleted = StudentProgress::where('student_id', $student->id)
            ->where('status', 'selesai')
            ->exists()
            || \App\Models\StudentEvaluation::where('student_id', $student->id)->exists();

        if ($hasAnyCompleted) {
            return 'Sedang Berjalan';
        }

        return 'Belum Mulai';
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
        $percentageScore = $this->calculateScore($assessment, $answers);
        $rawScore = $this->calculateRawScore($assessment, $answers);

        $progress = StudentProgress::updateOrCreate(
            [
                'student_id' => $student->id,
                'module_id' => $assessment->module_id,
                'assessment_id' => $assessment->id,
            ],
            [
                'status' => 'selesai',
                'nilai' => $percentageScore,
                'answers' => $answers,
                'finished_at' => now(),
            ]
        );

        // Auto-integrate score into StudentEvaluation if module is within Topik 1-5
        if ($assessment->module_id) {
            $evaluation = \App\Models\StudentEvaluation::firstOrNew([
                'student_id' => $student->id,
                'module_id' => $assessment->module_id,
            ]);

            $earnedRaw = (int) $rawScore;

            if ($assessment->jenis === 'penilaian_diri' || str_contains(strtolower($assessment->judul), 'penilaian diri')) {
                $evaluation->self_score = $earnedRaw;
            } elseif ($assessment->jenis === 'lembar_komitmen' || str_contains(strtolower($assessment->judul), 'komitmen')) {
                $evaluation->commitment_score = $earnedRaw;
            } else {
                $evaluation->lkpd_score = $earnedRaw;
            }

            $evaluation->save();
        }

        return $progress;
    }

    /**
     * Calculate score percentage from answers (supporting option weights/Likert scale, single choice, checklist, and essay).
     *
     * @param  array<int, mixed>  $answers  [question_id => selected_option_id|array_of_ids|essay_text]
     */
    public function calculateScore(Assessment $assessment, array $answers): float
    {
        $questions = $assessment->questions()->with('options')->get();
        if ($questions->isEmpty()) {
            return 0.0;
        }

        $totalEarned = 0.0;
        $maxPossible = 0.0;

        foreach ($questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;

            if ($question->type === 'checklist') {
                $selectedIds = is_array($userAnswer) ? $userAnswer : (empty($userAnswer) ? [] : [$userAnswer]);
                $hasOptionScores = $question->options->sum('score') > 0;

                if ($hasOptionScores) {
                    $maxPossible += $question->options->sum('score');
                    foreach ($selectedIds as $optId) {
                        $opt = $question->options->firstWhere('id', $optId);
                        if ($opt && $opt->score > 0) {
                            $totalEarned += $opt->score;
                        }
                    }
                } else {
                    $correctOptions = $question->options->where('is_correct', true);
                    $correctCount = $correctOptions->count();
                    $qMax = $question->score > 0 ? $question->score : max(1, $correctCount);
                    $maxPossible += $qMax;

                    if ($correctCount > 0) {
                        $matchedCount = 0;
                        foreach ($selectedIds as $optId) {
                            if ($correctOptions->where('id', $optId)->isNotEmpty()) {
                                $matchedCount++;
                            }
                        }
                        $pointPerItem = $qMax / $correctCount;
                        $totalEarned += ($matchedCount * $pointPerItem);
                    } else {
                        $totalEarned += count($selectedIds);
                    }
                }
            } elseif ($question->type === 'essay') {
                $qMax = $question->score ?: 1;
                $maxPossible += $qMax;
                if (is_string($userAnswer) && trim($userAnswer) !== '') {
                    $totalEarned += $qMax;
                }
            } else {
                // Single choice / Likert
                $maxOptionScore = $question->options->max('score');
                $hasOptionScores = $maxOptionScore !== null && $maxOptionScore > 0;
                $qMax = $hasOptionScores ? $maxOptionScore : ($question->score ?: 1);
                $maxPossible += $qMax;

                if ($userAnswer !== null && $userAnswer !== '') {
                    $selectedOptionId = is_array($userAnswer) ? ($userAnswer[0] ?? null) : $userAnswer;
                    if ($selectedOptionId) {
                        $selectedOption = $question->options->firstWhere('id', $selectedOptionId);
                        if ($selectedOption) {
                            if ($hasOptionScores) {
                                $totalEarned += (int) $selectedOption->score;
                            } elseif ($selectedOption->is_correct) {
                                $totalEarned += ($question->score ?: 1);
                            }
                        }
                    }
                }
            }
        }

        if ($maxPossible <= 0) {
            return 0.0;
        }

        return (float) round(($totalEarned / $maxPossible) * 100, 1);
    }

    /**
     * Calculate raw accumulated score from answers (total points from option weights).
     *
     * @param  array<int, mixed>  $answers
     */
    public function calculateRawScore(Assessment $assessment, array $answers): float
    {
        $questions = $assessment->questions()->with('options')->get();
        $totalEarned = 0.0;

        foreach ($questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            if ($userAnswer === null || $userAnswer === '') {
                continue;
            }

            if ($question->type === 'checklist') {
                $selectedIds = is_array($userAnswer) ? $userAnswer : [$userAnswer];
                $hasOptionScores = $question->options->sum('score') > 0;
                if ($hasOptionScores) {
                    foreach ($selectedIds as $optId) {
                        $opt = $question->options->firstWhere('id', $optId);
                        if ($opt && $opt->score > 0) {
                            $totalEarned += $opt->score;
                        }
                    }
                } else {
                    $correctOptions = $question->options->where('is_correct', true);
                    $correctCount = $correctOptions->count();
                    $qMax = $question->score > 0 ? $question->score : max(1, $correctCount);
                    if ($correctCount > 0) {
                        $matchedCount = 0;
                        foreach ($selectedIds as $optId) {
                            if ($correctOptions->where('id', $optId)->isNotEmpty()) {
                                $matchedCount++;
                            }
                        }
                        $pointPerItem = $qMax / $correctCount;
                        $totalEarned += ($matchedCount * $pointPerItem);
                    } else {
                        $totalEarned += count($selectedIds);
                    }
                }
            } elseif ($question->type === 'essay') {
                if (is_string($userAnswer) && trim($userAnswer) !== '') {
                    $totalEarned += ($question->score ?: 1);
                }
            } else {
                $selectedOptionId = is_array($userAnswer) ? ($userAnswer[0] ?? null) : $userAnswer;
                if ($selectedOptionId) {
                    $selectedOption = $question->options->firstWhere('id', $selectedOptionId);
                    if ($selectedOption) {
                        $hasOptionScores = $question->options->max('score') > 0;
                        if ($hasOptionScores) {
                            $totalEarned += (int) $selectedOption->score;
                        } elseif ($selectedOption->is_correct) {
                            $totalEarned += ($question->score ?: 1);
                        }
                    }
                }
            }
        }

        return (float) $totalEarned;
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
                    'penilaian_diri' => 'Penilaian Diri',
                    'refleksi_diri', 'lkpd' => 'Refleksi Diri',
                    'lembar_komitmen' => 'Lembar Komitmen',
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
     * Calculate progress fraction (0.0 to 1.0) for a specific module.
     */
    public function getModuleProgressFraction(Student $student, Module $module): float
    {
        $assessments = $module->assessments;
        if ($assessments->isNotEmpty()) {
            $totalAss = $assessments->count();
            $completedAss = 0;
            foreach ($assessments as $ass) {
                if ($this->isAssessmentCompleted($student, $ass)) {
                    $completedAss++;
                }
            }
            return $totalAss > 0 ? min(1.0, $completedAss / $totalAss) : 0.0;
        }

        if ($module->materials()->exists()) {
            $hasCompleted = StudentProgress::where('student_id', $student->id)
                ->where('module_id', $module->id)
                ->where('status', 'selesai')
                ->whereNull('assessment_id')
                ->exists();
            return $hasCompleted ? 1.0 : 0.0;
        }

        return 0.0;
    }

    /**
     * Calculate overall progress percentage for a student.
     */
    public function getProgressPercentage(Student $student): float
    {
        $modules = $this->getModulesInOrder();
        $totalModules = $modules->count();

        if ($totalModules === 0) {
            return 0.0;
        }

        $accumulatedFraction = 0.0;
        foreach ($modules as $module) {
            $accumulatedFraction += $this->getModuleProgressFraction($student, $module);
        }

        return round(($accumulatedFraction / $totalModules) * 100, 1);
    }

    /**
     * Check if the entire program is completed.
     */
    public function isProgramCompleted(Student $student): bool
    {
        return $this->getCurrentStage($student) === null;
    }
}
