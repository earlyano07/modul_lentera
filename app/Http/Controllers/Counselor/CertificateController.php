<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Konselor;
use App\Models\Student;
use App\Services\CertificateService;
use App\Services\ProgressService;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function __construct(
        protected CertificateService $certificateService,
        protected ProgressService $progressService
    ) {}

    public function show(Student $student)
    {
        $user = auth()->user();
        $konselor = $user->konselor;
        if (!$konselor) {
            $konselor = Konselor::firstOrCreate(
                ['user_id' => $user->id],
                ['nip' => '-', 'no_hp' => '-']
            );
        }

        $student->load('kelas.school');
        $schoolId = $student->kelas?->school_id;

        if (!$schoolId || !$konselor->schools()->where('schools.id', $schoolId)->exists()) {
            abort(403, 'Anda tidak memiliki akses ke siswa dari sekolah ini.');
        }

        $certificateData = $this->certificateService->getCertificateData($student);
        $certificateData['back_url'] = route('counselor.monitoring.student.detail', $student);

        return view('certificate.printable', $certificateData);
    }

    public function downloadDocx(Student $student)
    {
        $user = auth()->user();
        $konselor = $user->konselor;
        if (!$konselor) {
            $konselor = Konselor::firstOrCreate(
                ['user_id' => $user->id],
                ['nip' => '-', 'no_hp' => '-']
            );
        }

        $student->load('kelas.school');
        $schoolId = $student->kelas?->school_id;

        if (!$schoolId || !$konselor->schools()->where('schools.id', $schoolId)->exists()) {
            abort(403, 'Anda tidak memiliki akses ke siswa dari sekolah ini.');
        }

        $certificateData = $this->certificateService->getCertificateData($student);
        $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $certificateData['student_name'] ?? 'Siswa');
        $outputFilename = "Sertifikat_{$cleanName}.docx";
        $filePath = $this->certificateService->generateDocx($certificateData, $outputFilename);

        return response()->download($filePath, $outputFilename)->deleteFileAfterSend(true);
    }
}
