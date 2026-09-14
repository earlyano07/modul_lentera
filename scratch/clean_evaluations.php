<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\StudentEvaluation;
use App\Models\StudentProgress;

foreach (StudentEvaluation::all() as $eval) {
    // Check if student has actual progress for self and commitment
    $hasSelf = StudentProgress::where('student_id', $eval->student_id)
        ->whereHas('assessment', fn($q) => $q->where('jenis', 'penilaian_diri'))
        ->where('status', 'selesai')
        ->exists();

    $hasCommitment = StudentProgress::where('student_id', $eval->student_id)
        ->whereHas('assessment', fn($q) => $q->where('jenis', 'lembar_komitmen'))
        ->where('status', 'selesai')
        ->exists();

    if (!$hasSelf && $eval->self_score !== null) {
        $eval->self_score = null;
    }
    if (!$hasCommitment && $eval->commitment_score !== null) {
        $eval->commitment_score = null;
    }
    $eval->save();
}
echo "Cleaned evaluations!\n";
