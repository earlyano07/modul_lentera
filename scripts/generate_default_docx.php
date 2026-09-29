<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\JcTable;
use PhpOffice\PhpWord\Style\Table as TableStyle;
use PhpOffice\PhpWord\IOFactory;

$phpWord = new PhpWord();

// Define font defaults
$phpWord->setDefaultFontName('Calibri');
$phpWord->setDefaultFontSize(11);

// Add landscape section (A4 Landscape: 297mm x 210mm)
// 1 inch = 1440 twips. A4 = 16838 x 11906 twips.
$section = $phpWord->addSection([
    'orientation' => 'landscape',
    'paperSize' => 'A4',
    'marginTop' => 720,
    'marginBottom' => 720,
    'marginLeft' => 900,
    'marginRight' => 900,
]);

// Logo image if exists
$logoPath = __DIR__ . '/../public/images/certificate/lentera_logo.png';
if (file_exists($logoPath)) {
    $section->addImage($logoPath, [
        'width' => 140,
        'height' => 45,
        'alignment' => Jc::CENTER,
    ]);
}

// ==================== HALAMAN 1 (SERTIFIKAT DEPAN) ====================
$section->addText('SERTIFIKAT', [
    'name' => 'Georgia',
    'size' => 28,
    'bold' => true,
    'color' => '064E3B',
], [
    'alignment' => Jc::CENTER,
    'spaceBefore' => 100,
    'spaceAfter' => 40,
]);

$section->addText('PENYELESAIAN LAYANAN MODEL LENTERA', [
    'name' => 'Calibri',
    'size' => 12,
    'bold' => true,
    'color' => '059669',
], [
    'alignment' => Jc::CENTER,
    'spaceBefore' => 0,
    'spaceAfter' => 20,
]);

$section->addText('Latihan Empati Terstruktur untuk Atasi Perundungan', [
    'name' => 'Calibri',
    'size' => 10,
    'italic' => true,
    'color' => '64748B',
], [
    'alignment' => Jc::CENTER,
    'spaceBefore' => 0,
    'spaceAfter' => 180,
]);

$section->addText('Diberikan kepada:', [
    'name' => 'Calibri',
    'size' => 10,
    'color' => '64748B',
], [
    'alignment' => Jc::CENTER,
    'spaceBefore' => 0,
    'spaceAfter' => 60,
]);

$section->addText('${nama}', [
    'name' => 'Georgia',
    'size' => 22,
    'bold' => true,
    'underline' => 'single',
    'color' => '0F172A',
], [
    'alignment' => Jc::CENTER,
    'spaceBefore' => 0,
    'spaceAfter' => 120,
]);

$section->addText('atas partisipasi dan penyelesaian rangkaian layanan Model LENTERA dalam mengembangkan empati dan perilaku positif untuk menciptakan lingkungan pertemanan yang aman, nyaman, dan saling menghargai.', [
    'name' => 'Calibri',
    'size' => 10.5,
    'color' => '334155',
], [
    'alignment' => Jc::CENTER,
    'spaceBefore' => 0,
    'spaceAfter' => 180,
]);

// 5 Topics Table
$topicsTable = $section->addTable([
    'alignment' => JcTable::CENTER,
    'cellMargin' => 60,
]);
$topicsTable->addRow(300);
$topics = [
    '01 Menyadari Masalah',
    '02 Memahami Emosi',
    '03 Mengambil Perspektif',
    '04 Bertindak Empatik',
    '05 Membudayakan Perilaku',
];
foreach ($topics as $t) {
    $cell = $topicsTable->addCell(2800, [
        'bgColor' => 'ECFDF5',
        'borderSize' => 6,
        'borderColor' => 'A7F3D0',
    ]);
    $cell->addText("✓ {$t}", ['size' => 8.5, 'bold' => true, 'color' => '065F46'], ['alignment' => Jc::CENTER]);
}

$section->addTextBreak(1);

// Bottom Signatures Table Page 1
$sigTable1 = $section->addTable([
    'alignment' => JcTable::CENTER,
    'width' => 100 * 50,
    'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::PERCENT,
]);
$sigTable1->addRow();
// Left meta
$cellLeft = $sigTable1->addCell(7000);
$cellLeft->addText('${sekolah}', ['size' => 10, 'bold' => true, 'color' => '0F172A']);
$cellLeft->addText('Kelas: ${kelas}', ['size' => 9.5, 'color' => '475569']);
$cellLeft->addText('No: ${no_sertifikat}', ['size' => 9, 'color' => '64748B']);

// Right signature
$cellRight = $sigTable1->addCell(7000);
$cellRight->addText('${tanggal}', ['size' => 9.5, 'color' => '334155'], ['alignment' => Jc::RIGHT]);
$cellRight->addText('Guru Bimbingan dan Konseling', ['size' => 10, 'bold' => true, 'color' => '065F46'], ['alignment' => Jc::RIGHT]);
$cellRight->addTextBreak(2);
$cellRight->addText('${guru_bk}', ['size' => 10.5, 'bold' => true, 'underline' => 'single', 'color' => '0F172A'], ['alignment' => Jc::RIGHT]);
$cellRight->addText('${nip_guru_bk}', ['size' => 9, 'color' => '64748B'], ['alignment' => Jc::RIGHT]);


// ==================== HALAMAN 2 (REKAP & KOMITMEN) ====================
$section->addPageBreak();

$section->addText('REKAP CAPAIAN LAYANAN MODEL LENTERA', [
    'name' => 'Georgia',
    'size' => 14,
    'bold' => true,
    'color' => '064E3B',
], [
    'alignment' => Jc::LEFT,
    'spaceBefore' => 0,
    'spaceAfter' => 80,
]);

// Identity Table
$idTable = $section->addTable([
    'alignment' => JcTable::CENTER,
    'width' => 100 * 50,
    'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::PERCENT,
    'cellMargin' => 50,
]);
$idTable->addRow();
$idCell1 = $idTable->addCell(7000, ['bgColor' => 'F8FAFC', 'borderSize' => 4, 'borderColor' => 'E2E8F0']);
$idCell1->addText('Nama: ${nama}', ['size' => 9.5, 'bold' => true]);
$idCell1->addText('NIS: ${nis}', ['size' => 9]);

$idCell2 = $idTable->addCell(7000, ['bgColor' => 'F8FAFC', 'borderSize' => 4, 'borderColor' => 'E2E8F0']);
$idCell2->addText('Kelas: ${kelas} | Sekolah: ${sekolah}', ['size' => 9.5, 'bold' => true]);
$idCell2->addText('Tanggal: ${tanggal}', ['size' => 9]);

$section->addTextBreak(1);

// Two columns table for Scores (Left) and Commitment (Right)
$contentTable = $section->addTable([
    'alignment' => JcTable::CENTER,
    'width' => 100 * 50,
    'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::PERCENT,
]);
$contentTable->addRow();

// Left Column: Scores Table
$leftCol = $contentTable->addCell(7500, ['paddingRight' => 150]);
$scoreTbl = $leftCol->addTable(['cellMargin' => 40, 'borderSize' => 4, 'borderColor' => 'E2E8F0']);
$scoreTbl->addRow(240);
$scoreTbl->addCell(600, ['bgColor' => 'ECFDF5'])->addText('No', ['size' => 9, 'bold' => true, 'color' => '065F46'], ['alignment' => Jc::CENTER]);
$scoreTbl->addCell(4500, ['bgColor' => 'ECFDF5'])->addText('Topik Layanan', ['size' => 9, 'bold' => true, 'color' => '065F46']);
$scoreTbl->addCell(2000, ['bgColor' => 'ECFDF5'])->addText('Capaian', ['size' => 9, 'bold' => true, 'color' => '065F46'], ['alignment' => Jc::CENTER]);

$topicRows = [
    ['01', 'Topik 1: Menyadari Masalah', '${nilai_topik_1} — ${predikat_topik_1}'],
    ['02', 'Topik 2: Memahami Emosi', '${nilai_topik_2} — ${predikat_topik_2}'],
    ['03', 'Topik 3: Mengambil Perspektif', '${nilai_topik_3} — ${predikat_topik_3}'],
    ['04', 'Topik 4: Bertindak Empatik', '${nilai_topik_4} — ${predikat_topik_4}'],
    ['05', 'Topik 5: Membudayakan Anti-Perundungan', '${nilai_topik_5} — ${predikat_topik_5}'],
];
foreach ($topicRows as $r) {
    $scoreTbl->addRow();
    $scoreTbl->addCell(600)->addText($r[0], ['size' => 8.5], ['alignment' => Jc::CENTER]);
    $scoreTbl->addCell(4500)->addText($r[1], ['size' => 8.5]);
    $scoreTbl->addCell(2000)->addText($r[2], ['size' => 8.5, 'bold' => true], ['alignment' => Jc::CENTER]);
}
// Summary row
$scoreTbl->addRow();
$scoreTbl->addCell(5100, ['gridSpan' => 2, 'bgColor' => 'ECFDF5'])->addText('Capaian Keseluruhan:', ['size' => 9, 'bold' => true, 'color' => '065F46'], ['alignment' => Jc::RIGHT]);
$scoreTbl->addCell(2000, ['bgColor' => 'ECFDF5'])->addText('${nilai_akhir} — ${predikat_akhir}', ['size' => 9, 'bold' => true, 'color' => '065F46'], ['alignment' => Jc::CENTER]);

$leftCol->addText('Catatan: Hasil ini merupakan gambaran capaian peserta didik selama mengikuti layanan LENTERA dan bukan merupakan diagnosis psikologis.', [
    'size' => 7.5,
    'italic' => true,
    'color' => '78350F',
], ['spaceBefore' => 60]);

// Right Column: Commitment Box
$rightCol = $contentTable->addCell(6500, [
    'bgColor' => 'F0FDF4',
    'borderSize' => 6,
    'borderColor' => 'BBF7D0',
    'cellMargin' => 80,
]);
$rightCol->addText('KOMITMEN SAYA', ['size' => 10.5, 'bold' => true, 'color' => '064E3B'], ['spaceAfter' => 20]);
$rightCol->addText('Setelah mengikuti rangkaian LENTERA, saya berkomitmen untuk:', ['size' => 8.5, 'color' => '166534'], ['spaceAfter' => 40]);
$commitments = [
    'menghargai perasaan dan keberadaan orang lain;',
    'tidak ikut melakukan atau menyebarkan perundungan;',
    'berusaha memahami sudut pandang orang lain;',
    'menunjukkan kepedulian ketika melihat teman mengalami kesulitan;',
    'ikut menciptakan lingkungan pertemanan yang aman dan saling menghargai.',
];
foreach ($commitments as $c) {
    $rightCol->addText("☑ {$c}", ['size' => 8, 'color' => '1F2937'], ['spaceAfter' => 15]);
}

$rightCol->addText('Komitmen pribadi saya:', ['size' => 8.5, 'bold' => true, 'color' => '065F46'], ['spaceBefore' => 40]);
$rightCol->addText('“Mulai sekarang, saya akan...”', ['size' => 8, 'italic' => true, 'color' => '64748B']);
$rightCol->addText('__________________________________________________________', ['size' => 8, 'color' => 'CBD5E1']);

// Signatures Table Page 2
$sigTable2 = $section->addTable([
    'alignment' => JcTable::CENTER,
    'width' => 100 * 50,
    'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::PERCENT,
]);
$sigTable2->addRow();
$sigCell1 = $sigTable2->addCell(7000);
$sigCell1->addText('Peserta Didik,', ['size' => 9.5, 'color' => '334155'], ['alignment' => Jc::CENTER]);
$sigCell1->addTextBreak(2);
$sigCell1->addText('${nama}', ['size' => 10, 'bold' => true, 'underline' => 'single', 'color' => '0F172A'], ['alignment' => Jc::CENTER]);
$sigCell1->addText('Peserta LENTERA', ['size' => 8.5, 'color' => '64748B'], ['alignment' => Jc::CENTER]);

$sigCell2 = $sigTable2->addCell(7000);
$sigCell2->addText('Guru Bimbingan dan Konseling,', ['size' => 9.5, 'bold' => true, 'color' => '065F46'], ['alignment' => Jc::CENTER]);
$sigCell2->addTextBreak(2);
$sigCell2->addText('${guru_bk}', ['size' => 10, 'bold' => true, 'underline' => 'single', 'color' => '0F172A'], ['alignment' => Jc::CENTER]);
$sigCell2->addText('${nip_guru_bk}', ['size' => 8.5, 'color' => '64748B'], ['alignment' => Jc::CENTER]);

// Save document
$targetPath = __DIR__ . '/../storage/app/templates/certificate_template_default.docx';
$writer = IOFactory::createWriter($phpWord, 'Word2007');
$writer->save($targetPath);

echo "Successfully generated: {$targetPath}\n";