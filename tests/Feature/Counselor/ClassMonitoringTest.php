<?php

namespace Tests\Feature\Counselor;

use App\Models\Assessment;
use App\Models\Kelas;
use App\Models\Konselor;
use App\Models\Module;
use App\Models\Role;
use App\Models\School;
use App\Models\Student;
use App\Models\StudentProgress;
use App\Models\User;
use App\Services\ProgressService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClassMonitoringTest extends TestCase
{
    use RefreshDatabase;

    private User $counselorUser;
    private Kelas $kelas;
    private Module $module1;
    private Module $module2;
    private Assessment $ass1;
    private Assessment $ass2;
    private Assessment $ass3;
    private Student $student1;
    private Student $student2;
    private Student $student3;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['id' => Role::ADMIN], ['nama' => 'admin']);
        Role::firstOrCreate(['id' => Role::KONSELOR], ['nama' => 'konselor']);
        Role::firstOrCreate(['id' => Role::SISWA], ['nama' => 'siswa']);

        $school = School::create(['nama' => 'SMP Negeri 1 Test', 'status' => true]);
        $this->kelas = Kelas::create([
            'school_id' => $school->id,
            'nama_kelas' => 'VIII A',
            'tingkat' => 'VIII',
            'tahun_ajaran' => '2025/2026',
        ]);

        $this->counselorUser = User::create([
            'role_id' => Role::KONSELOR,
            'nama' => 'Konselor Test',
            'email' => 'konselor.mon@test.com',
            'password' => bcrypt('password'),
        ]);
        $konselor = Konselor::create([
            'user_id' => $this->counselorUser->id,
            'nip' => '987654321',
        ]);
        $konselor->schools()->attach($school->id);

        // Modules (Topik 1 & Topik 2)
        $this->module1 = Module::create([
            'urutan' => 1,
            'judul' => 'Empathy Awareness',
            'status' => true,
        ]);
        $this->module2 = Module::create([
            'urutan' => 2,
            'judul' => 'Emotional Empathy',
            'status' => true,
        ]);

        // Module 1 has 3 assessments
        $this->ass1 = Assessment::create([
            'module_id' => $this->module1->id,
            'judul' => 'Penilaian Diri',
            'jenis' => 'penilaian_diri',
            'urutan' => 1,
        ]);
        $this->ass2 = Assessment::create([
            'module_id' => $this->module1->id,
            'judul' => 'Refleksi Diri',
            'jenis' => 'refleksi_diri',
            'urutan' => 2,
        ]);
        $this->ass3 = Assessment::create([
            'module_id' => $this->module1->id,
            'judul' => 'Lembar Komitmen',
            'jenis' => 'lembar_komitmen',
            'urutan' => 3,
        ]);

        // Module 2 has 1 assessment
        Assessment::create([
            'module_id' => $this->module2->id,
            'judul' => 'Penilaian Diri Topik 2',
            'jenis' => 'penilaian_diri',
            'urutan' => 1,
        ]);

        // Create 3 students in this class
        $u1 = User::create(['role_id' => Role::SISWA, 'nama' => 'Andi', 'email' => 'andi@test.com', 'password' => bcrypt('password')]);
        $this->student1 = Student::create(['user_id' => $u1->id, 'kelas_id' => $this->kelas->id, 'nis' => '101', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '2010-01-01']);

        $u2 = User::create(['role_id' => Role::SISWA, 'nama' => 'Budi', 'email' => 'budi@test.com', 'password' => bcrypt('password')]);
        $this->student2 = Student::create(['user_id' => $u2->id, 'kelas_id' => $this->kelas->id, 'nis' => '102', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '2010-01-01']);

        $u3 = User::create(['role_id' => Role::SISWA, 'nama' => 'Citra', 'email' => 'citra@test.com', 'password' => bcrypt('password')]);
        $this->student3 = Student::create(['user_id' => $u3->id, 'kelas_id' => $this->kelas->id, 'nis' => '103', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '2010-01-01']);
    }

    public function test_counselor_can_view_class_monitoring_with_synchronized_progress(): void
    {
        // Student 1: In progress on Ass 1 (sedang_mengerjakan)
        StudentProgress::create([
            'student_id' => $this->student1->id,
            'module_id' => $this->module1->id,
            'assessment_id' => $this->ass1->id,
            'status' => 'sedang_mengerjakan',
        ]);

        // Student 2: Finished Ass 1 and Ass 2 (selesai)
        StudentProgress::create([
            'student_id' => $this->student2->id,
            'module_id' => $this->module1->id,
            'assessment_id' => $this->ass1->id,
            'status' => 'selesai',
            'nilai' => 80,
            'finished_at' => now(),
        ]);
        StudentProgress::create([
            'student_id' => $this->student2->id,
            'module_id' => $this->module1->id,
            'assessment_id' => $this->ass2->id,
            'status' => 'selesai',
            'nilai' => 90,
            'finished_at' => now(),
        ]);

        $progressService = app(ProgressService::class);

        $budiPct = $progressService->getProgressPercentage($this->student2);
        $this->assertEquals(33.3, $budiPct);

        $budiActiveAss = $progressService->getCurrentActiveAssessment($this->student2);
        $this->assertNotNull($budiActiveAss);
        $this->assertEquals('Lembar Komitmen', $budiActiveAss->judul);

        $this->assertEquals('Sedang Berjalan', $progressService->getCurrentStatusLabel($this->student2));
        $this->assertEquals('Sedang Mengerjakan', $progressService->getCurrentStatusLabel($this->student1));
        $this->assertEquals('Belum Mulai', $progressService->getCurrentStatusLabel($this->student3));

        $response = $this->actingAs($this->counselorUser)
            ->get(route('counselor.monitoring.students', $this->kelas->id));

        $response->assertStatus(200);
        $response->assertSee('Budi');
        $response->assertSee('33.3%');
        $response->assertSee('Lembar Komitmen');
        $response->assertSee('(2/3 Selesai)');
        $response->assertSee('Sedang Berjalan');
        $response->assertSee('Andi');
        $response->assertSee('Sedang Mengerjakan');
        $response->assertSee('Citra');
        $response->assertSee('Belum Mulai');
    }
}
