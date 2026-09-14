<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Assessment;

foreach (Assessment::all() as $a) {
    $judulLower = strtolower($a->judul);
    if (str_contains($judulLower, 'penilaian diri')) {
        $a->jenis = 'penilaian_diri';
        $a->save();
        echo "Updated Assessment #{$a->id} '{$a->judul}' to jenis='penilaian_diri'\n";
    } elseif (str_contains($judulLower, 'komitmen')) {
        $a->jenis = 'lembar_komitmen';
        $a->save();
        echo "Updated Assessment #{$a->id} '{$a->judul}' to jenis='lembar_komitmen'\n";
    } elseif (str_contains($judulLower, 'lkpd') || str_contains($judulLower, 'lembar kerja')) {
        $a->jenis = 'lkpd';
        $a->save();
        echo "Updated Assessment #{$a->id} '{$a->judul}' to jenis='lkpd'\n";
    }
}
