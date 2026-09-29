<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Module;
use App\Services\KartuSituasiDocxService;
use Illuminate\Http\Request;

class KartuSituasiController extends Controller
{
    public function __construct(
        protected KartuSituasiDocxService $docxService
    ) {}

    /**
     * Display printable view for all kartu situasi in a module
     */
    public function printModule(Request $request, Module $module)
    {
        $cards = $module->materials()
            ->where('jenis', Material::JENIS_KARTU_SITUASI)
            ->orderBy('urutan')
            ->get();

        $docxUrl = route('kartu-situasi.docx', $module);
        $backUrl = $this->determineBackUrl($module);

        return view('kartu-situasi.printable', compact('module', 'cards', 'docxUrl', 'backUrl'));
    }

    /**
     * Download Word (.docx) file containing all kartu situasi in a module
     */
    public function downloadDocxModule(Module $module)
    {
        $cards = $module->materials()
            ->where('jenis', Material::JENIS_KARTU_SITUASI)
            ->orderBy('urutan')
            ->get();

        $cleanTitle = preg_replace('/[^A-Za-z0-9_\-]/', '_', $module->judul);
        $filename = "Kartu_Situasi_Topik_{$module->urutan}_{$cleanTitle}.docx";

        $filePath = $this->docxService->generateDocx($module, $cards, $filename);

        return response()->download($filePath, $filename)->deleteFileAfterSend(true);
    }

    /**
     * Display printable view for a single kartu situasi
     */
    public function printSingle(Request $request, Material $material)
    {
        if ($material->jenis !== Material::JENIS_KARTU_SITUASI) {
            abort(404, 'Materi bukan merupakan kartu situasi.');
        }

        $module = $material->module;
        $cards = collect([$material]);
        $docxUrl = route('kartu-situasi.docx-single', $material);
        $backUrl = $this->determineBackUrl($module);

        return view('kartu-situasi.printable', compact('module', 'cards', 'docxUrl', 'backUrl'));
    }

    /**
     * Download Word (.docx) file for a single kartu situasi
     */
    public function downloadDocxSingle(Material $material)
    {
        if ($material->jenis !== Material::JENIS_KARTU_SITUASI) {
            abort(404, 'Materi bukan merupakan kartu situasi.');
        }

        $module = $material->module;
        $cleanTitle = preg_replace('/[^A-Za-z0-9_\-]/', '_', $material->judul);
        $filename = "Kartu_Situasi_{$cleanTitle}.docx";

        $filePath = $this->docxService->generateDocx($module, collect([$material]), $filename);

        return response()->download($filePath, $filename)->deleteFileAfterSend(true);
    }

    /**
     * Determine contextual back URL based on current user role
     */
    protected function determineBackUrl(Module $module): string
    {
        $user = auth()->user();
        if (!$user) {
            return url()->previous();
        }

        if ($user->isAdmin()) {
            return route('admin.modules.show', ['module' => $module, 'step' => 2]);
        }

        if ($user->isKonselor()) {
            return route('counselor.layanan.show', ['module' => $module, 'step' => 2]);
        }

        return route('student.module', $module);
    }
}
