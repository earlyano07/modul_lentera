<?php

namespace App\Services;

use App\Models\Material;
use App\Models\Module;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\TblWidth;

class KartuSituasiDocxService
{
    /**
     * Generate a .docx file for a collection of kartu situasi
     *
     * @param Module $module
     * @param iterable $cards
     * @param string $filename
     * @return string Absolute file path to the generated document
     */
    public function generateDocx(Module $module, $cards, string $filename): string
    {
        $phpWord = new PhpWord();

        // Default document styling
        $phpWord->setDefaultFontName('Calibri');
        $phpWord->setDefaultFontSize(10);

        $section = $phpWord->addSection([
            'marginTop' => 800,
            'marginBottom' => 800,
            'marginLeft' => 800,
            'marginRight' => 800,
            'paperSize' => 'A4',
            'orientation' => 'portrait',
        ]);

        // Title Header
        $section->addText(
            'LENTERA - KARTU SITUASI ROLE PLAYING',
            ['bold' => true, 'size' => 15, 'color' => '006D2C'],
            ['alignment' => Jc::CENTER, 'spaceAfter' => 40]
        );

        $section->addText(
            "Topik {$module->urutan}: {$module->judul}" . ($module->subtitle ? " ({$module->subtitle})" : ''),
            ['bold' => true, 'size' => 11, 'color' => '475569'],
            ['alignment' => Jc::CENTER, 'spaceAfter' => 140]
        );

        $cardCount = 0;
        foreach ($cards as $index => $card) {
            $cardCount++;
            $this->addCardToSection($section, $card, $index + 1, $module);

            // Add page break after every card or 2 cards depending on density
            if ($cardCount % 2 === 0) {
                $section->addPageBreak();
            } else {
                $section->addTextBreak(1);
            }
        }

        // Save to temporary file
        $tempDir = storage_path('app/temp');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $filePath = $tempDir . '/' . $filename;
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($filePath);

        return $filePath;
    }

    /**
     * Format a single card into a clean table structure matching the mockup
     */
    protected function addCardToSection($section, Material $card, int $number, Module $module): void
    {
        // Outer Card Table
        $tableStyle = [
            'borderSize' => 12,
            'borderColor' => '006D2C',
            'cellMarginTop' => 100,
            'cellMarginBottom' => 100,
            'cellMarginLeft' => 140,
            'cellMarginRight' => 140,
            'width' => 100 * 50,
            'unit' => TblWidth::PERCENT,
            'alignment' => Jc::CENTER,
        ];

        $table = $section->addTable($tableStyle);

        // Header Row: Number and Card Title
        $table->addRow();
        $headerCell = $table->addCell(10000, ['bgColor' => 'FFFFFF']);
        $headerCell->addText(
            "● [ {$number} ]   " . mb_strtoupper($card->judul, 'UTF-8'),
            ['bold' => true, 'size' => 12, 'color' => '006D2C'],
            ['alignment' => Jc::CENTER, 'spaceAfter' => 40]
        );

        // Row 2: Illustration Box Placeholder
        $table->addRow();
        $illustrationCell = $table->addCell(10000, ['bgColor' => 'ECFDF5']);
        $illustrationCell->addText(
            'ILUSTRASI KEGIATAN PELATIHAN',
            ['bold' => true, 'size' => 9, 'color' => '059669'],
            ['alignment' => Jc::CENTER, 'spaceAfter' => 20]
        );

        // Row 3: Situasi
        $table->addRow();
        $situasiCell = $table->addCell(10000, ['bgColor' => 'FFFFFF']);
        $situasiCell->addText(
            'SITUASI:',
            ['bold' => true, 'size' => 9.5, 'color' => '006D2C'],
            ['spaceAfter' => 30]
        );
        $situasiCell->addText(
            $card->situasi ?: '-',
            ['italic' => false, 'size' => 10, 'color' => '1E293B'],
            ['spaceAfter' => 60]
        );

        // Row 4: Two Columns (Peran & Diskusi)
        $table->addRow();
        $columnsCell = $table->addCell(10000, ['bgColor' => 'F8FAFC']);

        $innerTable = $columnsCell->addTable([
            'borderSize' => 0,
            'borderColor' => 'FFFFFF',
            'width' => 100 * 50,
            'unit' => TblWidth::PERCENT,
            'cellMarginTop' => 40,
            'cellMarginBottom' => 40,
            'cellMarginLeft' => 60,
            'cellMarginRight' => 60,
        ]);

        $innerTable->addRow();

        // Left Column: Peran
        $peranCell = $innerTable->addCell(5000, ['bgColor' => 'F8FAFC']);
        $peranCell->addText(
            'PERAN:',
            ['bold' => true, 'size' => 9, 'color' => '006D2C'],
            ['spaceAfter' => 30]
        );
        $peranList = array_filter(array_map('trim', explode("\n", $card->peran ?? '')));
        if (!empty($peranList)) {
            foreach ($peranList as $p) {
                $peranCell->addText("● {$p}", ['size' => 9, 'color' => '334155'], ['spaceAfter' => 15]);
            }
        } else {
            $peranCell->addText('-', ['size' => 9, 'color' => '64748B']);
        }

        // Right Column: Diskusi
        $diskusiCell = $innerTable->addCell(5000, ['bgColor' => 'F8FAFC']);
        $diskusiCell->addText(
            'DISKUSIKAN:',
            ['bold' => true, 'size' => 9, 'color' => '006D2C'],
            ['spaceAfter' => 30]
        );
        $diskusiList = array_filter(array_map('trim', explode("\n", $card->diskusi ?? '')));
        if (!empty($diskusiList)) {
            foreach ($diskusiList as $d) {
                $diskusiCell->addText("● {$d}", ['size' => 9, 'color' => '334155'], ['spaceAfter' => 15]);
            }
        } else {
            $diskusiCell->addText('-', ['size' => 9, 'color' => '64748B']);
        }

        // Row 5: Footer Note
        $table->addRow();
        $footerCell = $table->addCell(10000, ['bgColor' => 'FFFFFF']);
        $footerCell->addText(
            "LENTERA LMS • Topik {$module->urutan} • Tahap 2: Role Playing",
            ['italic' => true, 'size' => 8, 'color' => '94A3B8'],
            ['alignment' => Jc::CENTER, 'spaceAfter' => 0]
        );
    }
}
