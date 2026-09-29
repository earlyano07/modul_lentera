<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CertificateTemplate;
use App\Services\CertificateService;
use Illuminate\Http\Request;

class CertificateTemplateController extends Controller
{
    public function __construct(protected CertificateService $certificateService) {}

    public function index()
    {
        $template = $this->certificateService->getTemplate();
        return view('admin.certificate-template.index', compact('template'));
    }

    public function updateMetadata(Request $request)
    {
        $validated = $request->validate([
            'signer_mode' => 'required|in:school_counselor,custom',
            'default_signer_name' => 'nullable|string|max:255',
            'default_signer_nip' => 'nullable|string|max:100',
            'signer_title' => 'required|string|max:255',
            'cert_number_prefix' => 'required|string|max:50',
            'cert_number_format' => 'required|string|max:255',
            'date_type' => 'required|in:completion_date,current_date,fixed_date',
            'fixed_date' => 'nullable|required_if:date_type,fixed_date|date',
        ]);

        $template = $this->certificateService->getTemplate();
        $template->update($validated);

        return redirect()->route('admin.certificate-template.index')
            ->with('success', 'Pengaturan data sertifikat (Penandatangan, Nomor, & Tanggal) berhasil diperbarui.');
    }

    public function reset()
    {
        $template = $this->certificateService->getTemplate();
        
        // Remove uploaded custom file if exists
        if ($template->docx_template_path && file_exists(storage_path('app/' . $template->docx_template_path))) {
            @unlink(storage_path('app/' . $template->docx_template_path));
        }

        $template->update([
            'docx_template_path' => null,
        ]);

        return redirect()->route('admin.certificate-template.index')
            ->with('success', 'Template sertifikat Word berhasil di-reset ke template standar.');
    }

    public function uploadDocx(Request $request)
    {
        $request->validate([
            'docx_template' => 'required|file|max:10240', // 10MB max
        ]);

        $file = $request->file('docx_template');
        $ext = strtolower($file->getClientOriginalExtension());
        if (!in_array($ext, ['docx', 'zip'])) {
            return redirect()->route('admin.certificate-template.index')
                ->withErrors(['docx_template' => 'File harus berekstensi .docx (Microsoft Word)']);
        }

        $filename = 'custom_template_' . time() . '.docx';
        $file->storeAs('templates', $filename);

        $fullPath = storage_path('app/templates/' . $filename);
        $this->certificateService->enforceA4Landscape($fullPath);

        $template = $this->certificateService->getTemplate();
        $template->update([
            'docx_template_path' => 'templates/' . $filename,
        ]);

        return redirect()->route('admin.certificate-template.index')
            ->with('success', 'Template Word (.docx) kustom berhasil diunggah dan dijadikan template aktif.');
    }

    public function downloadDocxTemplate()
    {
        $templatePath = $this->certificateService->getDocxTemplatePath();
        if (!file_exists($templatePath)) {
            abort(404, 'File template Word tidak ditemukan.');
        }

        $this->certificateService->enforceA4Landscape($templatePath);

        return response()->download($templatePath, 'Template_Sertifikat_Lentera.docx');
    }

    public function downloadDefaultDocxTemplate()
    {
        $defaultPath = storage_path('app/templates/certificate_template_default.docx');
        if (!file_exists($defaultPath)) {
            $defaultPath = public_path('templates/certificate_template_default.docx');
        }

        if (!file_exists($defaultPath)) {
            abort(404, 'File template standar tidak ditemukan.');
        }

        $this->certificateService->enforceA4Landscape($defaultPath);

        return response()->download($defaultPath, 'Template_Sertifikat_Lentera_Standar.docx');
    }

    public function previewDocx()
    {
        $sampleData = $this->certificateService->getSampleData();
        $outputPath = $this->certificateService->generateDocx($sampleData, 'Pratinjau_Sertifikat_Contoh.docx');

        return response()->download($outputPath, 'Pratinjau_Sertifikat_Contoh.docx')->deleteFileAfterSend(true);
    }
}
