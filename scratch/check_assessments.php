<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Module;
use App\Models\Assessment;

$modules = Module::with(['assessments.questions'])->orderBy('urutan')->get();

foreach ($modules as $module) {
    echo "=== MODUL {$module->urutan}: {$module->judul} (ID: {$module->id}) ===\n";
    foreach ($module->assessments as $a) {
        $qCount = $a->questions->count();
        $qSum = $a->questions->sum('score');
        echo "  - Assessment ID {$a->id} [{$a->jenis}]: '{$a->judul}' (Urutan: {$a->urutan})\n";
        echo "    Total Questions: {$qCount}, Total Score: {$qSum}\n";
    }
    echo "\n";
}
