<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\StudentProgress;
use App\Models\StudentEvaluation;
use App\Models\Assessment;

echo "=== RECENT STUDENT PROGRESS ===\n";
$progresses = StudentProgress::with('assessment')->latest()->take(10)->get();
foreach ($progresses as $p) {
    echo "ID: {$p->id} | Student: {$p->student_id} | Module: {$p->module_id} | Assessment ID: {$p->assessment_id} ({$p->assessment?->judul}, jenis: {$p->assessment?->jenis}) | Status: {$p->status} | Nilai: {$p->nilai} | Finished: {$p->finished_at}\n";
}

echo "\n=== RECENT STUDENT EVALUATIONS ===\n";
$evals = StudentEvaluation::latest()->take(10)->get();
foreach ($evals as $e) {
    echo "ID: {$e->id} | Student: {$e->student_id} | Module: {$e->module_id} | LKPD: {$e->lkpd_score} | Self: {$e->self_score} | Commitment: {$e->commitment_score} | Updated: {$e->updated_at}\n";
}
