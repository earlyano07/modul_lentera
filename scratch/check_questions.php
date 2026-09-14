<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$assessments = App\Models\Assessment::whereIn('id', [2, 8, 9])->with('questions.options')->get();

foreach ($assessments as $a) {
    echo "Assessment #{$a->id} - {$a->judul} ({$a->questions->count()} questions)\n";
    foreach ($a->questions as $q) {
        echo "  Q: {$q->question}\n";
    }
}
