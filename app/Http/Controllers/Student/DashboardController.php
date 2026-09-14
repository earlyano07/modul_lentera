<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\ProgressService;

class DashboardController extends Controller
{
    public function __construct(protected ProgressService $progressService) {}

    public function index()
    {
        return redirect()->route('student.roadmap');
    }
}
