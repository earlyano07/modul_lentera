<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Module;

class LayananController extends Controller
{
    public function index()
    {
        $topiks = Module::where('urutan', '>=', 1)
            ->where('urutan', '<=', 5)
            ->orderBy('urutan')
            ->with('materials')
            ->get();

        return view('counselor.layanan.index', compact('topiks'));
    }

    public function show(Module $module)
    {
        $module->load('materials', 'assessments.questions');
        return view('counselor.layanan.show', compact('module'));
    }
}
