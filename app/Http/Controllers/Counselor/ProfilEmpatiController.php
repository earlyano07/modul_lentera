<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;

class ProfilEmpatiController extends Controller
{
    public function index()
    {
        return view('counselor.profil-empati.index');
    }
}
