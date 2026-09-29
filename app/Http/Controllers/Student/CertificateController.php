<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\CertificateService;
use App\Services\ProgressService;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function __construct(
        protected CertificateService $certificateService,
        protected ProgressService $progressService
    ) {}

    public function show(Request $request)
    {
        $user = auth()->user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Profil siswa tidak ditemukan.');
        }

        // Verify completion
        if (!$this->progressService->isProgramCompleted($student)) {
            return redirect()->route('student.roadmap')
                ->with('warning', 'Anda belum menyelesaikan seluruh tahapan layanan Model LENTERA untuk mencetak sertifikat.');
        }

        $certificateData = $this->certificateService->getCertificateData($student);
        $certificateData['back_url'] = route('student.roadmap');

        return view('certificate.printable', $certificateData);
    }

    public function downloadDocx()
    {
        $user = auth()->user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Profil siswa tidak ditemukan.');
        }

        if (!$this->progressService->isProgramCompleted($student)) {
            return redirect()->route('student.roadmap')
                ->with('warning', 'Anda belum menyelesaikan seluruh tahapan layanan Model LENTERA untuk mengunduh sertifikat.');
        }

        $certificateData = $this->certificateService->getCertificateData($student);
        $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $certificateData['student_name'] ?? 'Siswa');
        $outputFilename = "Sertifikat_{$cleanName}.docx";
        $filePath = $this->certificateService->generateDocx($certificateData, $outputFilename);

        return response()->download($filePath, $outputFilename)->deleteFileAfterSend(true);
    }
}
