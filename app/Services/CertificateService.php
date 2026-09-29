<?php

namespace App\Services;

use App\Models\CertificateTemplate;
use App\Models\Module;
use App\Models\Student;
use App\Models\StudentEvaluation;
use App\Models\StudentProgress;
use Carbon\Carbon;

class CertificateService
{
    public function getTemplate(): CertificateTemplate
    {
        return CertificateTemplate::getActive();
    }

    public function getCertificateData(Student $student): array
    {
        $student->load(['user', 'kelas.school.konselors.user']);
        $template = $this->getTemplate();

        // 1. Signer (Guru BK / Konselor) resolution
        $signerMode = $template->signer_mode ?? 'school_counselor';
        if ($signerMode === 'custom' && !empty($template->default_signer_name)) {
            $signerName = $template->default_signer_name;
            $signerNip = $template->default_signer_nip 
                ? (str_starts_with($template->default_signer_nip, 'NIP') ? $template->default_signer_nip : "NIP. {$template->default_signer_nip}") 
                : '';
        } else {
            $counselor = $student->kelas?->school?->konselors->first();
            if ($counselor) {
                $signerName = $counselor->user?->nama ?? ($counselor->nama ?? 'Guru BK / Konselor');
                $signerNip = ($counselor->nip && $counselor->nip !== '-') ? "NIP. {$counselor->nip}" : '';
            } else {
                $signerName = !empty($template->default_signer_name) ? $template->default_signer_name : 'Guru BK / Konselor';
                $signerNip = !empty($template->default_signer_nip) 
                    ? (str_starts_with($template->default_signer_nip, 'NIP') ? $template->default_signer_nip : "NIP. {$template->default_signer_nip}") 
                    : '';
            }
        }

        // Load modules 1 to 5
        $modules = Module::where('status', true)
            ->where('urutan', '>=', 1)
            ->where('urutan', '<=', 5)
            ->orderBy('urutan')
            ->get();

        $evaluations = StudentEvaluation::where('student_id', $student->id)
            ->get()
            ->keyBy('module_id');

        $progresses = StudentProgress::where('student_id', $student->id)
            ->where('status', 'selesai')
            ->get()
            ->groupBy('module_id');

        $topicScores = [];
        $totalPct = 0;
        $countedModules = 0;

        foreach ($modules as $module) {
            $eval = $evaluations->get($module->id);
            $modProgress = $progresses->get($module->id, collect());

            $percentage = null;
            $category = null;

            if ($eval && $eval->self_score !== null && $eval->lkpd_score !== null && $eval->commitment_score !== null) {
                $details = $eval->getOverallDetails();
                $percentage = (float) $details['percentage'];
                $category = $details['category'];
            } elseif ($modProgress->isNotEmpty()) {
                $avg = (float) $modProgress->avg('nilai');
                $percentage = round($avg, 1);
                $cat = StudentEvaluation::getCategoryFromPercentage($percentage);
                $category = $cat['category'];
            } elseif ($eval) {
                // If some scores exist
                $scores = array_filter([$eval->self_score, $eval->lkpd_score, $eval->commitment_score], fn($v) => $v !== null);
                if (!empty($scores)) {
                    $details = $eval->getOverallDetails();
                    $percentage = (float) ($details['percentage'] ?? 80.0);
                    $category = $details['category'] ?? 'Baik';
                }
            }

            // Fallback to default passing grade if student completed but raw score missing
            if ($percentage === null) {
                $percentage = 80.0;
                $category = 'Baik';
            }

            $totalPct += $percentage;
            $countedModules++;

            // Clean topic title (e.g. remove "Topik X: " if present)
            $cleanTitle = preg_replace('/^Topik\s*\d+\s*:\s*/i', '', $module->judul);

            $topicScores[] = [
                'module_id' => $module->id,
                'urutan' => $module->urutan,
                'title' => $cleanTitle,
                'percentage' => $percentage,
                'percentage_formatted' => number_format($percentage, 0, ',', '') . '%',
                'category' => $category,
                'label' => number_format($percentage, 0, ',', '') . '% — ' . $category,
            ];
        }

        $overallPct = $countedModules > 0 ? round($totalPct / $countedModules, 1) : 0.0;
        $overallCat = StudentEvaluation::getCategoryFromPercentage($overallPct);

        // 2. Format Certificate Number
        $certNumber = $this->formatCertificateNumber($template, $student);

        // 3. Issue Date resolution
        $dateType = $template->date_type ?? 'completion_date';
        if ($dateType === 'fixed_date' && !empty($template->fixed_date)) {
            $issueDate = Carbon::parse($template->fixed_date)->locale('id')->translatedFormat('d F Y');
        } elseif ($dateType === 'current_date') {
            $issueDate = Carbon::now()->locale('id')->translatedFormat('d F Y');
        } else {
            $lastFinished = StudentProgress::where('student_id', $student->id)
                ->where('status', 'selesai')
                ->max('finished_at');

            $issueDate = $lastFinished 
                ? Carbon::parse($lastFinished)->locale('id')->translatedFormat('d F Y')
                : Carbon::now()->locale('id')->translatedFormat('d F Y');
        }

        return [
            'template' => $template,
            'student' => $student,
            'student_name' => $student->user->nama ?? $student->nama,
            'student_nis' => $student->nis ?? '-',
            'class_name' => $student->kelas->nama_kelas ?? 'Kelas',
            'school_name' => $student->kelas->school->nama ?? 'Sekolah',
            'signer_name' => $signerName,
            'signer_nip' => $signerNip,
            'signer_title' => $template->signer_title,
            'cert_number' => $certNumber,
            'issue_date' => $issueDate,
            'topic_scores' => $topicScores,
            'overall_percentage' => $overallPct,
            'overall_percentage_formatted' => number_format($overallPct, 1, ',', '.') . '%',
            'overall_category' => $overallCat['category'],
            'overall_label' => number_format($overallPct, 1, ',', '.') . '% — ' . $overallCat['category'],
            'is_sample' => false,
        ];
    }

    /**
     * Format certificate number based on configured pattern
     */
    public function formatCertificateNumber(CertificateTemplate $template, Student|array $studentOrData): string
    {
        $pattern = $template->cert_number_format ?: 'No: {PREFIX}/{YEAR}/{CLASS}/{ID}';
        $prefix = $template->cert_number_prefix ?: 'LTR';
        $year = date('Y');
        $month = date('m');
        $romanMonths = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        $monthRoman = $romanMonths[(int)date('n')] ?? 'I';

        if ($studentOrData instanceof Student) {
            $class = strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', $studentOrData->kelas->nama_kelas ?? 'VIII'));
            $id = sprintf('%04d', $studentOrData->id);
        } else {
            $class = strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', $studentOrData['class_name'] ?? 'VIII'));
            $id = sprintf('%04d', $studentOrData['id'] ?? 1);
        }

        return strtr($pattern, [
            '{PREFIX}' => $prefix,
            '{YEAR}' => $year,
            '{MONTH}' => $month,
            '{MONTH_ROMAN}' => $monthRoman,
            '{CLASS}' => $class ?: 'VIII',
            '{ID}' => $id,
            '{STUDENT_ID}' => $id,
        ]);
    }

    public function getSampleData(): array
    {
        $template = $this->getTemplate();

        $sampleTopics = [
            ['urutan' => 1, 'title' => 'Menyadari Masalah', 'percentage' => 82.0, 'percentage_formatted' => '82%', 'category' => 'Baik', 'label' => '82% — Baik'],
            ['urutan' => 2, 'title' => 'Memahami Emosi', 'percentage' => 85.0, 'percentage_formatted' => '85%', 'category' => 'Sangat Baik', 'label' => '85% — Sangat Baik'],
            ['urutan' => 3, 'title' => 'Mengambil Perspektif', 'percentage' => 78.0, 'percentage_formatted' => '78%', 'category' => 'Baik', 'label' => '78% — Baik'],
            ['urutan' => 4, 'title' => 'Bertindak Empatik', 'percentage' => 88.0, 'percentage_formatted' => '88%', 'category' => 'Sangat Baik', 'label' => '88% — Sangat Baik'],
            ['urutan' => 5, 'title' => 'Membudayakan Anti-Perundungan', 'percentage' => 90.0, 'percentage_formatted' => '90%', 'category' => 'Sangat Baik', 'label' => '90% — Sangat Baik'],
        ];

        $signerMode = $template->signer_mode ?? 'school_counselor';
        if ($signerMode === 'custom' && !empty($template->default_signer_name)) {
            $sampleSigner = $template->default_signer_name;
            $sampleNip = $template->default_signer_nip 
                ? (str_starts_with($template->default_signer_nip, 'NIP') ? $template->default_signer_nip : "NIP. {$template->default_signer_nip}") 
                : '';
        } else {
            $sampleSigner = !empty($template->default_signer_name) ? $template->default_signer_name : 'Novia Hendratno, M.Pd.';
            $sampleNip = !empty($template->default_signer_nip) 
                ? (str_starts_with($template->default_signer_nip, 'NIP') ? $template->default_signer_nip : "NIP. {$template->default_signer_nip}") 
                : 'NIP. 19850315 201001 2 021';
        }

        $certNumber = $this->formatCertificateNumber($template, [
            'class_name' => 'VIIIA',
            'id' => 2,
        ]);

        $dateType = $template->date_type ?? 'completion_date';
        if ($dateType === 'fixed_date' && !empty($template->fixed_date)) {
            $issueDate = Carbon::parse($template->fixed_date)->locale('id')->translatedFormat('d F Y');
        } else {
            $issueDate = Carbon::now()->locale('id')->translatedFormat('d F Y');
        }

        return [
            'template' => $template,
            'student' => null,
            'student_name' => 'Budi Setiawan',
            'student_nis' => '10002',
            'class_name' => 'Kelas VIII A',
            'school_name' => 'SMP Negeri Model Blitar',
            'signer_name' => $sampleSigner,
            'signer_nip' => $sampleNip,
            'signer_title' => $template->signer_title,
            'cert_number' => $certNumber,
            'issue_date' => $issueDate,
            'topic_scores' => $sampleTopics,
            'overall_percentage' => 84.6,
            'overall_percentage_formatted' => '84,6%',
            'overall_category' => 'Baik',
            'overall_label' => '84,6% — Baik',
            'is_sample' => true,
        ];
    }

    public function getDocxTemplatePath(): string
    {
        $template = $this->getTemplate();
        if ($template->docx_template_path && file_exists(storage_path('app/' . $template->docx_template_path))) {
            return storage_path('app/' . $template->docx_template_path);
        }
        if (file_exists(storage_path('app/templates/certificate_template_default.docx'))) {
            return storage_path('app/templates/certificate_template_default.docx');
        }
        return public_path('templates/certificate_template_default.docx');
    }

    public function generateDocx(array $certData, ?string $outputFilename = null): string
    {
        $templatePath = $this->getDocxTemplatePath();
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);

        // Core variables
        $templateProcessor->setValue('nama', $certData['student_name'] ?? '');
        $templateProcessor->setValue('nis', $certData['student_nis'] ?? '-');
        $templateProcessor->setValue('kelas', $certData['class_name'] ?? '');
        $templateProcessor->setValue('sekolah', $certData['school_name'] ?? '');
        $templateProcessor->setValue('no_sertifikat', $certData['cert_number'] ?? '');
        $templateProcessor->setValue('tanggal', $certData['issue_date'] ?? '');
        $templateProcessor->setValue('guru_bk', $certData['signer_name'] ?? '');
        $templateProcessor->setValue('nip_guru_bk', $certData['signer_nip'] ?? '');

        // Topic scores (1 to 5)
        $topics = $certData['topic_scores'] ?? [];
        for ($i = 1; $i <= 5; $i++) {
            $found = null;
            foreach ($topics as $t) {
                if (($t['urutan'] ?? 0) == $i) {
                    $found = $t;
                    break;
                }
            }
            $valPct = $found['percentage_formatted'] ?? '-';
            $valPred = $found['category'] ?? '-';
            $templateProcessor->setValue("nilai_topik_{$i}", $valPct);
            $templateProcessor->setValue("predikat_topik_{$i}", $valPred);
        }

        $templateProcessor->setValue('nilai_akhir', $certData['overall_percentage_formatted'] ?? '');
        $templateProcessor->setValue('predikat_akhir', $certData['overall_category'] ?? '');

        $tempDir = storage_path('app/temp');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $certData['student_name'] ?? 'Lentera');
        $filename = $outputFilename ?: ("Sertifikat_{$cleanName}_" . time() . '.docx');
        $outputPath = $tempDir . '/' . $filename;
        $templateProcessor->saveAs($outputPath);

        // Ensure orientation is landscape and paper size is strictly A4 (297mm x 210mm)
        $this->enforceA4Landscape($outputPath);

        return $outputPath;
    }

    /**
     * Enforce A4 Landscape page setup on a Word .docx file
     * OpenXML: width 16838 twips (297mm), height 11906 twips (210mm), orient="landscape"
     */
    public function enforceA4Landscape(string $docxPath): void
    {
        if (!file_exists($docxPath) || !class_exists('\ZipArchive')) {
            return;
        }

        $zip = new \ZipArchive();
        if ($zip->open($docxPath) === true) {
            $xml = $zip->getFromName('word/document.xml');
            if ($xml !== false) {
                // 16838 twips = 297mm (A4 Landscape Width), 11906 twips = 210mm (A4 Landscape Height)
                $landscapePgSz = '<w:pgSz w:orient="landscape" w:w="16838" w:h="11906"/>';
                if (preg_match('/<w:pgSz\b[^>]*(?:\/>|>.*?<\/w:pgSz>)/is', $xml)) {
                    $xml = preg_replace('/<w:pgSz\b[^>]*(?:\/>|>.*?<\/w:pgSz>)/is', $landscapePgSz, $xml);
                } else {
                    $xml = preg_replace('/<w:sectPr\b([^>]*)>/i', '<w:sectPr$1>' . $landscapePgSz, $xml);
                }
                $zip->addFromString('word/document.xml', $xml);
            }
            $zip->close();
        }
    }
}

