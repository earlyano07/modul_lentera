<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\JcTable;
use PhpOffice\PhpWord\SimpleType\VerticalJc;
use PhpOffice\PhpWord\Style\Table as TableStyle;
use PhpOffice\PhpWord\IOFactory;

$phpWord = new PhpWord();

// Define default font
$phpWord->setDefaultFontName('Calibri');
$phpWord->setDefaultFontSize(10.5);

// Define Page Settings: A4 Landscape (297mm x 210mm)
// 1 mm = 56.69 twips. 297mm = 16838 twips, 210mm = 11906 twips.
$sectionStyle = [
    'paperSize' => 'A4',
    'orientation' => 'landscape',
    'pageSizeW' => 16838,
    'pageSizeH' => 11906,
    'marginTop' => 700,
    'marginBottom' => 700,
    'marginLeft' => 850,
    'marginRight' => 850,
];

// Add Section
$section = $phpWord->addSection($sectionStyle);

// ----------------------------------------------------
// HALAMAN 1 : SERTIFIKAT DEPAN
// ----------------------------------------------------

// Outer decorative double frame table
$outerTable = $section->addTable([
    'alignment' => JcTable::CENTER,
    'width' => 100 * 50,
    'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::PERCENT,
    'borderSize' => 18, // 2.25 pt
    'borderColor' => '059669', // Emerald
    'cellMargin' => 140,
]);
$outerTable->addRow();
$mainCell = $outerTable->addCell(15000, [
    'borderSize' => 6, // 0.75 pt inner border
    'borderColor' => 'A7F3D0', // Mint
    'bgColor' => 'FFFFFF',
]);

// 1. Logo
$logoPath = __DIR__ . '/../public/images/certificate/lentera_logo.png';
if (file_exists($logoPath)) {
    $mainCell->addImage($logoPath, [
        'width' => 150,
        'height' => 48,
        'alignment' => Jc::CENTER,
    ]);
}

// 2. Title Section
$mainCell->addText('SERTIFIKAT', [
    'name' => 'Georgia',
    'size' => 28,
    'bold' => true,
    'color' => '064E3B',
], [
    'alignment' => Jc::CENTER,
    'spaceBefore' => 60,
    'spaceAfter' => 20,
]);

$mainCell->addText('PENYELESAIAN LAYANAN MODEL LENTERA', [
    'name' => 'Calibri',
    'size' => 12,
    'bold' => true,
    'color' => '059669',
], [
    'alignment' => Jc::CENTER,
    'spaceBefore' => 0,
    'spaceAfter' => 10,
]);

$mainCell->addText('Latihan Empati Terstruktur untuk Atasi Perundungan', [
    'name' => 'Calibri',
    'size' => 10,
    'italic' => true,
    'color' => '64748B',
], [
    'alignment' => Jc::CENTER,
    'spaceBefore' => 0,
    'spaceAfter' => 120,
]);

// Decorative Divider
$dividerTable = $mainCell->addTable(['alignment' => JcTable::CENTER]);
$dividerTable->addRow(20);
$dividerTable->addCell(3000, ['borderBottomSize' => 10, 'borderBottomColor' => '10B981']);
$dividerTable->addCell(400)->addText('◆', ['size' => 8, 'color' => '059669'], ['alignment' => Jc::CENTER]);
$dividerTable->addCell(3000, ['borderBottomSize' => 10, 'borderBottomColor' => '10B981']);

// 3. Recipient Section
$mainCell->addText('Diberikan kepada:', [
    'name' => 'Calibri',
    'size' => 10,
    'color' => '64748B',
], [
    'alignment' => Jc::CENTER,
    'spaceBefore' => 100,
    'spaceAfter' => 40,
]);

$mainCell->addText('${nama}', [
    'name' => 'Georgia',
    'size' => 22,
    'bold' => true,
    'color' => '0F172A',
    'underline' => 'single',
], [
    'alignment' => Jc::CENTER,
    'spaceBefore' => 0,
    'spaceAfter' => 80,
]);

$mainCell->addText('atas partisipasi dan penyelesaian rangkaian layanan Model LENTERA dalam mengembangkan empati dan perilaku positif untuk menciptakan lingkungan pertemanan yang aman, nyaman, dan saling menghargai.', [
    'name' => 'Calibri',
    'size' => 10.5,
    'color' => '334155',
], [
    'alignment' => Jc::CENTER,
    'spaceBefore' => 0,
    'spaceAfter' => 120,
]);

// 4. 5 Topics Badges Table
$topicsTable = $mainCell->addTable([
    'alignment' => JcTable::CENTER,
    'cellMargin' => 40,
]);
$topicsTable->addRow(260);
$topics = [
    '01 Menyadari Masalah',
    '02 Memahami Emosi',
    '03 Mengambil Perspektif',
    '04 Bertindak Empatik',
    '05 Membudayakan Perilaku',
];
foreach ($topics as $t) {
    $cell = $topicsTable->addCell(2700, [
        'bgColor' => 'ECFDF5',
        'borderSize' => 6,
        'borderColor' => 'BBF7D0',
        'valign' => 'center',
    ]);
    $cell->addText("✓ {$t}", ['size' => 8.5, 'bold' => true, 'color' => '065F46'], ['alignment' => Jc::CENTER]);
}

$mainCell->addTextBreak(1);

// 5. Footer / Signatures on Page 1
$sigTable1 = $mainCell->addTable([
    'alignment' => JcTable::CENTER,
    'width' => 100 * 50,
    'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::PERCENT,
]);
$sigTable1->addRow();

// Left Metadata
$cLeft = $sigTable1->addCell(7500);
$cLeft->addText('${sekolah}', ['size' => 10.5, 'bold' => true, 'color' => '0F172A']);
$cLeft->addText('Kelas: ${kelas}', ['size' => 9.5, 'color' => '334155']);
$cLeft->addText('No: ${no_sertifikat}', ['size' => 9, 'color' => '64748B']);

// Right Counselor Signature
$cRight = $sigTable1->addCell(7500);
$cRight->addText('${tanggal}', ['size' => 9.5, 'color' => '334155'], ['alignment' => Jc::RIGHT]);
$cRight->addText('Guru Bimbingan dan Konseling', ['size' => 10, 'bold' => true, 'color' => '065F46'], ['alignment' => Jc::RIGHT]);
$cRight->addTextBreak(2);
$cRight->addText('${guru_bk}', ['size' => 10.5, 'bold' => true, 'underline' => 'single', 'color' => '0F172A'], ['alignment' => Jc::RIGHT]);
$cRight->addText('${nip_guru_bk}', ['size' => 8.5, 'color' => '64748B'], ['alignment' => Jc::RIGHT]);



// ----------------------------------------------------
// HALAMAN 2 : REKAP CAPAIAN & KOMITMEN (BELAKANG)
// ----------------------------------------------------
$section->addPageBreak();

$outerTable2 = $section->addTable([
    'alignment' => JcTable::CENTER,
    'width' => 100 * 50,
    'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::PERCENT,
    'borderSize' => 18,
    'borderColor' => '059669',
    'cellMargin' => 140,
]);
$outerTable2->addRow();
$mainCell2 = $outerTable2->addCell(15000, [
    'borderSize' => 6,
    'borderColor' => 'A7F3D0',
    'bgColor' => 'FFFFFF',
]);

// Header Back Page
$backHeaderTable = $mainCell2->addTable([
    'alignment' => JcTable::CENTER,
    'width' => 100 * 50,
    'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::PERCENT,
    'borderBottomSize' => 12,
    'borderBottomColor' => '059669',
]);
$backHeaderTable->addRow();
$bhLeft = $backHeaderTable->addCell(10000);
$bhLeft->addText('REKAP CAPAIAN LAYANAN MODEL LENTERA', [
    'name' => 'Georgia',
    'size' => 14,
    'bold' => true,
    'color' => '064E3B',
]);

$bhRight = $backHeaderTable->addCell(5000);
if (file_exists($logoPath)) {
    $bhRight->addImage($logoPath, [
        'width' => 90,
        'height' => 28,
        'alignment' => Jc::RIGHT,
    ]);
}

$mainCell2->addTextBreak(1);

// Student Identity Box
$idTable = $mainCell2->addTable([
    'alignment' => JcTable::CENTER,
    'width' => 100 * 50,
    'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::PERCENT,
    'bgColor' => 'F8FAFC',
    'borderSize' => 6,
    'borderColor' => 'E2E8F0',
    'cellMargin' => 60,
]);
$idTable->addRow();
$ic1 = $idTable->addCell(7500);
$ic1->addText('Nama Peserta Didik: ${nama}', ['size' => 9.5, 'bold' => true, 'color' => '0F172A']);
$ic1->addText('NIS / NISN: ${nis}', ['size' => 9, 'color' => '475569']);

$ic2 = $idTable->addCell(7500);
$ic2->addText('Kelas: ${kelas}  |  Sekolah: ${sekolah}', ['size' => 9.5, 'bold' => true, 'color' => '0F172A']);
$ic2->addText('Tanggal Penyelesaian: ${tanggal}', ['size' => 9, 'color' => '475569']);

$mainCell2->addTextBreak(1);

// Two Columns: Left = Scores Table & Disclaimer, Right = Commitment Box
$twoColTable = $mainCell2->addTable([
    'alignment' => JcTable::CENTER,
    'width' => 100 * 50,
    'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::PERCENT,
]);
$twoColTable->addRow();

// Left Column: Table of Scores
$col1 = $twoColTable->addCell(7600, ['paddingRight' => 100]);

$scoreTable = $col1->addTable([
    'width' => 100 * 50,
    'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::PERCENT,
    'cellMargin' => 45,
    'borderSize' => 4,
    'borderColor' => 'CBD5E1',
]);
$scoreTable->addRow(220);
$scoreTable->addCell(700, ['bgColor' => 'ECFDF5'])->addText('No', ['size' => 8.5, 'bold' => true, 'color' => '065F46'], ['alignment' => Jc::CENTER]);
$scoreTable->addCell(4500, ['bgColor' => 'ECFDF5'])->addText('Topik Layanan', ['size' => 8.5, 'bold' => true, 'color' => '065F46']);
$scoreTable->addCell(2200, ['bgColor' => 'ECFDF5'])->addText('Capaian', ['size' => 8.5, 'bold' => true, 'color' => '065F46'], ['alignment' => Jc::CENTER]);

$scoreRows = [
    ['01', 'Topik 1: Menyadari Masalah', '${nilai_topik_1} — ${predikat_topik_1}'],
    ['02', 'Topik 2: Memahami Emosi', '${nilai_topik_2} — ${predikat_topik_2}'],
    ['03', 'Topik 3: Mengambil Perspektif', '${nilai_topik_3} — ${predikat_topik_3}'],
    ['04', 'Topik 4: Bertindak Empatik', '${nilai_topik_4} — ${predikat_topik_4}'],
    ['05', 'Topik 5: Membudayakan Anti-Perundungan', '${nilai_topik_5} — ${predikat_topik_5}'],
];

foreach ($scoreRows as $r) {
    $scoreTable->addRow(200);
    $scoreTable->addCell(700)->addText($r[0], ['size' => 8], ['alignment' => Jc::CENTER]);
    $scoreTable->addCell(4500)->addText($r[1], ['size' => 8]);
    $scoreTable->addCell(2200)->addText($r[2], ['size' => 8, 'bold' => true, 'color' => '065F46'], ['alignment' => Jc::CENTER]);
}

// Summary Row
$scoreTable->addRow(220);
$scoreTable->addCell(5200, ['gridSpan' => 2, 'bgColor' => 'ECFDF5'])->addText('Capaian Keseluruhan:', ['size' => 8.5, 'bold' => true, 'color' => '064E3B'], ['alignment' => Jc::RIGHT]);
$scoreTable->addCell(2200, ['bgColor' => 'ECFDF5'])->addText('${nilai_akhir} — ${predikat_akhir}', ['size' => 8.5, 'bold' => true, 'color' => '064E3B'], ['alignment' => Jc::CENTER]);

// Disclaimer Box
$col1->addText('* Catatan: Hasil ini merupakan gambaran capaian peserta didik selama mengikuti layanan LENTERA dan bukan merupakan diagnosis psikologis.', [
    'size' => 7.5,
    'italic' => true,
    'color' => '78350F',
], ['spaceBefore' => 60]);


// Right Column: Commitment Section
$col2 = $twoColTable->addCell(6800, [
    'bgColor' => 'F0FDF4',
    'borderSize' => 6,
    'borderColor' => 'BBF7D0',
    'cellMargin' => 70,
]);
$col2->addText('KOMITMEN SAYA', ['size' => 10, 'bold' => true, 'color' => '064E3B'], ['spaceAfter' => 20]);
$col2->addText('Setelah mengikuti rangkaian LENTERA, saya berkomitmen untuk:', ['size' => 8.5, 'color' => '166534'], ['spaceAfter' => 30]);

$commitments = [
    'menghargai perasaan dan keberadaan orang lain;',
    'tidak ikut melakukan atau menyebarkan perundungan;',
    'berusaha memahami sudut pandang orang lain;',
    'menunjukkan kepedulian ketika melihat teman mengalami kesulitan;',
    'ikut menciptakan lingkungan pertemanan yang aman dan saling menghargai.',
];
foreach ($commitments as $c) {
    $col2->addText("☑ {$c}", ['size' => 8, 'color' => '1F2937'], ['spaceAfter' => 10]);
}

$col2->addText('Komitmen pribadi saya:', ['size' => 8.5, 'bold' => true, 'color' => '065F46'], ['spaceBefore' => 30]);
$col2->addText('“Mulai sekarang, saya akan...”', ['size' => 8, 'italic' => true, 'color' => '64748B']);
$col2->addText('_________________________________________________________________', ['size' => 7.5, 'color' => 'CBD5E1']);


$mainCell2->addTextBreak(1);

// Signatures Back Page (Student & Counselor)
$sigTable2 = $mainCell2->addTable([
    'alignment' => JcTable::CENTER,
    'width' => 100 * 50,
    'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::PERCENT,
]);
$sigTable2->addRow();

$sc1 = $sigTable2->addCell(7500);
$sc1->addText('Peserta Didik,', ['size' => 9.5, 'color' => '334155'], ['alignment' => Jc::CENTER]);
$sc1->addTextBreak(2);
$sc1->addText('${nama}', ['size' => 10, 'bold' => true, 'underline' => 'single', 'color' => '0F172A'], ['alignment' => Jc::CENTER]);
$sc1->addText('Peserta LENTERA', ['size' => 8.5, 'color' => '64748B'], ['alignment' => Jc::CENTER]);

$sc2 = $sigTable2->addCell(7500);
$sc2->addText('Guru Bimbingan dan Konseling,', ['size' => 9.5, 'bold' => true, 'color' => '065F46'], ['alignment' => Jc::CENTER]);
$sc2->addTextBreak(2);
$sc2->addText('${guru_bk}', ['size' => 10, 'bold' => true, 'underline' => 'single', 'color' => '0F172A'], ['alignment' => Jc::CENTER]);
$sc2->addText('${nip_guru_bk}', ['size' => 8.5, 'color' => '64748B'], ['alignment' => Jc::CENTER]);


// ----------------------------------------------------
// SAVE TO TARGET LOCATIONS
// ----------------------------------------------------
$writer = IOFactory::createWriter($phpWord, 'Word2007');

// 1. Storage default
$storagePath = __DIR__ . '/../storage/app/templates/certificate_template_default.docx';
$writer->save($storagePath);

// 2. Public download
$publicPath = __DIR__ . '/../public/templates/template_sertifikat_lentera.docx';
$writer->save($publicPath);

// Also copy to public/templates/certificate_template_default.docx
copy($publicPath, __DIR__ . '/../public/templates/certificate_template_default.docx');

echo "SUCCESS! Template created:\n1. {$storagePath}\n2. {$publicPath}\n";