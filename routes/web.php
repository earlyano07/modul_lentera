<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\KonselorController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\AssessmentController as AdminAssessmentController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Counselor\DashboardController as CounselorDashboardController;
use App\Http\Controllers\Counselor\MonitoringController;
use App\Http\Controllers\Counselor\ReportController;
use App\Http\Controllers\Counselor\LayananController;
use App\Http\Controllers\Counselor\EvaluasiController;
use App\Http\Controllers\Counselor\ProfilEmpatiController;
use App\Http\Controllers\Counselor\SettingsController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\LearningController;
use App\Http\Controllers\Student\AssessmentController as StudentAssessmentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ===== Landing Page =====
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route(Auth::user()->dashboardRoute());
    }
    return redirect()->route('login');
});

// ===== Admin Routes =====
Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Schools
        Route::resource('schools', SchoolController::class);

        // Kelas
        Route::resource('kelas', KelasController::class);

        // Konselor
        Route::resource('konselor', KonselorController::class);
        Route::post('konselor/{konselor}/assign-schools', [KonselorController::class, 'assignSchools'])->name('konselor.assign-schools');

        // Students
        Route::resource('students', AdminStudentController::class);
        Route::get('students-import', [AdminStudentController::class, 'importForm'])->name('students.import.form');
        Route::post('students-import', [AdminStudentController::class, 'import'])->name('students.import');
        Route::post('students/import', [AdminStudentController::class, 'import'])->name('students.import.store');

        // Modules
        Route::resource('modules', ModuleController::class);

        // Materials (nested under modules)
        Route::resource('modules.materials', MaterialController::class)->shallow();

        // Assessments (nested under modules)
        Route::resource('modules.assessments', AdminAssessmentController::class)->shallow();

        // Questions (nested under assessments)
        Route::resource('assessments.questions', QuestionController::class)->shallow();
    });

// ===== Counselor Routes =====
Route::prefix('counselor')
    ->middleware(['auth', 'role:konselor'])
    ->name('counselor.')
    ->group(function () {
        Route::get('/dashboard', [CounselorDashboardController::class, 'index'])->name('dashboard');

        // Monitoring
        Route::get('/schools', [MonitoringController::class, 'schools'])->name('monitoring.schools');
        Route::get('/schools/{school}/kelas', [MonitoringController::class, 'kelas'])->name('monitoring.kelas');
        Route::get('/kelas/{kelas}/students', [MonitoringController::class, 'students'])->name('monitoring.students');
        Route::get('/students/{student}/progress', [MonitoringController::class, 'studentDetail'])->name('monitoring.student.detail');

        // Reports
        Route::get('/reports/student/{student}', [ReportController::class, 'student'])->name('reports.student');
        Route::get('/reports/student/{student}/pdf', [ReportController::class, 'studentPdf'])->name('reports.student.pdf');
        Route::get('/reports/kelas/{kelas}', [ReportController::class, 'kelas'])->name('reports.kelas');
        Route::get('/reports/kelas/{kelas}/pdf', [ReportController::class, 'kelasPdf'])->name('reports.kelas.pdf');

        // Layanan (Topik 1-5)
        Route::get('/layanan', [LayananController::class, 'index'])->name('layanan');
        Route::get('/layanan/{module}', [LayananController::class, 'show'])->name('layanan.show');

        // Placeholders
        Route::get('/evaluasi', [EvaluasiController::class, 'index'])->name('evaluasi');
        Route::post('/evaluasi', [EvaluasiController::class, 'store'])->name('evaluasi.store');
        Route::get('/profil-empati', [ProfilEmpatiController::class, 'index'])->name('profil-empati');
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    });

// ===== Student Routes =====
Route::prefix('student')
    ->middleware(['auth', 'role:siswa'])
    ->name('student.')
    ->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::get('/roadmap', [LearningController::class, 'roadmap'])->name('roadmap');
        Route::get('/module/{module}', [LearningController::class, 'module'])->name('module');
        Route::get('/material/{material}', [LearningController::class, 'material'])->name('material');

        // Assessment
        Route::get('/assessment/{assessment}', [StudentAssessmentController::class, 'show'])->name('assessment.show');
        Route::post('/assessment/{assessment}/start', [StudentAssessmentController::class, 'start'])->name('assessment.start');
        Route::post('/assessment/{assessment}/submit', [StudentAssessmentController::class, 'submit'])->name('assessment.submit');
        Route::get('/assessment/{assessment}/result', [StudentAssessmentController::class, 'result'])->name('assessment.result');
    });

// ===== Profile Routes (Breeze) =====
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===== Dashboard Redirect =====
Route::get('/dashboard', function () {
    return redirect()->route(Auth::user()->dashboardRoute());
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
