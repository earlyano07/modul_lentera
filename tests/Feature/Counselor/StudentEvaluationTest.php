<?php

namespace Tests\Feature\Counselor;

use App\Models\Module;
use App\Models\Role;
use App\Models\School;
use App\Models\Kelas;
use App\Models\Student;
use App\Models\Konselor;
use App\Models\User;
use App\Models\StudentEvaluation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentEvaluationTest extends TestCase
{
    use RefreshDatabase;

    private User $counselorUser;
    private Student $student;
    private Module $module;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Roles
        Role::firstOrCreate(['id' => Role::ADMIN], ['nama' => 'admin']);
        Role::firstOrCreate(['id' => Role::KONSELOR], ['nama' => 'konselor']);
        Role::firstOrCreate(['id' => Role::SISWA], ['nama' => 'siswa']);

        // 2. School & Kelas
        $school = School::create([
            'nama' => 'SMP Negeri Test',
            'status' => true
        ]);
        $kelas = Kelas::create([
            'school_id' => $school->id,
            'nama_kelas' => 'VIII A',
            'tingkat' => 'VIII',
            'tahun_ajaran' => '2025/2026'
        ]);

        // 3. Users: Counselor & Student
        $this->counselorUser = User::create([
            'role_id' => Role::KONSELOR,
            'nama' => 'Konselor Test',
            'email' => 'konselor@test.com',
            'password' => bcrypt('password')
        ]);
        $konselor = Konselor::create([
            'user_id' => $this->counselorUser->id,
            'nip' => '123456789'
        ]);
        $konselor->schools()->attach($school->id);

        $studentUser = User::create([
            'role_id' => Role::SISWA,
            'nama' => 'Siswa Test',
            'email' => 'siswa@test.com',
            'password' => bcrypt('password')
        ]);
        $this->student = Student::create([
            'user_id' => $studentUser->id,
            'kelas_id' => $kelas->id,
            'nis' => '10001',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '2010-01-01'
        ]);

        // 4. Module
        $this->module = Module::create([
            'judul' => 'Topik Test 1',
            'urutan' => 1,
            'status' => true
        ]);
    }

    public function test_unauthenticated_user_cannot_access_evaluasi(): void
    {
        $response = $this->get('/counselor/evaluasi');
        $response->assertRedirect('/login');
    }

    public function test_student_cannot_access_evaluasi(): void
    {
        $studentUser = $this->student->user;
        $response = $this->actingAs($studentUser)->get('/counselor/evaluasi');
        $response->assertStatus(403);
    }

    public function test_counselor_can_access_evaluasi(): void
    {
        $response = $this->actingAs($this->counselorUser)->get('/counselor/evaluasi');
        $response->assertStatus(200);
        $response->assertSee('Evaluasi Peserta Didik');
        $response->assertSee('Siswa Test');
    }

    public function test_counselor_can_store_evaluation_scores(): void
    {
        $response = $this->actingAs($this->counselorUser)
            ->post('/counselor/evaluasi', [
                'student_id' => $this->student->id,
                'module_id' => $this->module->id,
                'lkpd_score' => 18,
                'lkpd_note' => 'Kerja LKPD sangat bagus.',
                'self_score' => 16,
                'self_note' => 'Penilaian diri jujur.',
                'commitment_score' => 5,
                'commitment_note' => 'Komitmen tinggi.'
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/counselor/evaluasi?student_id=' . $this->student->id . '&module_id=' . $this->module->id);

        $this->assertDatabaseHas('student_evaluations', [
            'student_id' => $this->student->id,
            'module_id' => $this->module->id,
            'lkpd_score' => 18,
            'self_score' => 16,
            'commitment_score' => 5
        ]);

        // Verify the dynamic classification mapping
        $evaluation = StudentEvaluation::first();
        $this->assertEquals('Berkembang Sangat Baik', $evaluation->getLkpdDetails()['category']);
        $this->assertEquals('Berkembang Baik', $evaluation->getSelfDetails()['category']);
        $this->assertEquals('Berkembang Sangat Baik', $evaluation->getCommitmentDetails()['category']);
        $this->assertEquals(3.67, $evaluation->getOverallDetails()['average_code']);
        $this->assertEquals('Berkembang Sangat Baik', $evaluation->getOverallDetails()['category']);
    }

    public function test_store_validation_errors(): void
    {
        // Test score above max limit
        $response = $this->actingAs($this->counselorUser)
            ->post('/counselor/evaluasi', [
                'student_id' => $this->student->id,
                'module_id' => $this->module->id,
                'lkpd_score' => 25, // Max 20
                'self_score' => 16,
                'commitment_score' => 5
            ]);

        $response->assertSessionHasErrors(['lkpd_score']);
    }
}
