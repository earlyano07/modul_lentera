<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function index()
    {
        return redirect()->route('counselor.profile.edit');
    }
}
