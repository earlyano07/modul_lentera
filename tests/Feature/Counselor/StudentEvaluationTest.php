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
        $response->assertSee('evaluasiHandler()');
    }

    public function test_counselor_can_store_evaluation_scores(): void
    {
        $response = $this->actingAs($this->counselorUser)
            ->post('/counselor/evaluasi', [
                'student_id' => $this->student->id,
                'module_id' => $this->module->id,
                'lkpd_score' => 15,
                'self_score' => 16,
                'commitment_score' => 5,
                'notes' => 'Catatan konselor untuk topik ini.'
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/counselor/evaluasi?student_id=' . $this->student->id . '&module_id=' . $this->module->id);

        $this->assertDatabaseHas('student_evaluations', [
            'student_id' => $this->student->id,
            'module_id' => $this->module->id,
            'lkpd_score' => 15,
            'self_score' => 16,
            'commitment_score' => 5,
            'notes' => 'Catatan konselor untuk topik ini.'
        ]);

        // Verify the dynamic classification mapping
        $evaluation = StudentEvaluation::first();
        $this->assertEquals('Catatan konselor untuk topik ini.', $evaluation->counselor_note);
        $this->assertEquals('Sangat Baik', $evaluation->getLkpdDetails()['category']);
        $this->assertEquals('Cukup', $evaluation->getSelfDetails()['category']);
        $this->assertEquals('Baik', $evaluation->getCommitmentDetails()['category']);
        $this->assertEquals(81.3, $evaluation->getOverallDetails()['average_code']);
        $this->assertEquals('Baik', $evaluation->getOverallDetails()['category']);
        $this->assertEquals('Capaian baik, dengan penguatan pada aspek tertentu', $evaluation->getOverallDetails()['meaning']);
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

    public function test_tindak_lanjut_guidelines_and_details_structure(): void
    {
        $guidelines = StudentEvaluation::getAllTindakLanjutGuidelines();
        $this->assertCount(5, $guidelines);
        $this->assertEquals('Sangat Baik', $guidelines[0]['category']);
        $this->assertNotEmpty($guidelines[0]['tindak_lanjut']);

        // Check category with ethical note
        $sangatKurang = StudentEvaluation::getCategoryFromPercentage(45);
        $this->assertEquals('Sangat Kurang', $sangatKurang['category']);
        $this->assertNotNull($sangatKurang['catatan_penting']);
        $this->assertStringContainsString('bukan berarti peserta didik adalah pelaku atau korban perundungan', $sangatKurang['catatan_penting']);

        // Check counselor monitoring student detail page
        $evaluation = StudentEvaluation::create([
            'student_id' => $this->student->id,
            'module_id' => $this->module->id,
            'lkpd_score' => 10,
            'self_score' => 10,
            'commitment_score' => 2,
            'counselor_note' => 'Perlu bimbingan lanjutan'
        ]);

        $overall = $evaluation->getOverallDetails();
        $this->assertArrayHasKey('tindak_lanjut', $overall);
        $this->assertArrayHasKey('deskripsi', $overall);
        $this->assertArrayHasKey('catatan_penting', $overall);

        $response = $this->actingAs($this->counselorUser)->get('/counselor/students/' . $this->student->id . '/progress');
        $response->assertStatus(200);
        $response->assertSee('Panduan Rekomendasi Tindak Lanjut');
    }

    public function test_refleksi_diri_assessment_structure_and_reversed_scoring(): void
    {
        // Re-run seeder to get the exact Refleksi Diri configuration
        $this->seed(\Database\Seeders\Topik1AssessmentSeeder::class);

        $assessment = \App\Models\Assessment::where('jenis', 'refleksi_diri')->with('questions.options')->first();
        $this->assertNotNull($assessment);
        $this->assertStringContainsString('Raka sering dipanggil', $assessment->deskripsi);
        $this->assertStringContainsString('skornya dibalik', $assessment->catatan);
        $this->assertEquals(16, $assessment->max_skor);
        $this->assertCount(4, $assessment->questions);

        // Verify Question 4 reversed scores
        $q4 = $assessment->questions->where('urutan', 4)->first();
        $this->assertEquals('Pendapat pelaku saja sudah cukup untuk menentukan bahwa tindakan tersebut tidak bermasalah.', $q4->question);
        $q4Options = $q4->options->pluck('score', 'label');
        $this->assertEquals(1, $q4Options['SS']);
        $this->assertEquals(2, $q4Options['S']);
        $this->assertEquals(3, $q4Options['KS']);
        $this->assertEquals(4, $q4Options['TS']);

        // Student visits question page via start POST
        $studentUser = $this->student->user;
        $response = $this->actingAs($studentUser)->post('/student/assessment/' . $assessment->id . '/start');
        $response->assertStatus(200);
        $response->assertSee('Raka sering dipanggil');
        $response->assertSee('Catatan: Butir nomor 4 adalah pernyataan negatif sehingga skornya dibalik.');

        // Student submits answers: Q1: SS (4), Q2: S (3), Q3: KS (2), Q4: TS (4 - reversed!)
        $q1 = $assessment->questions->where('urutan', 1)->first();
        $q2 = $assessment->questions->where('urutan', 2)->first();
        $q3 = $assessment->questions->where('urutan', 3)->first();

        $answers = [
            $q1->id => $q1->options->firstWhere('label', 'SS')->id, // 4
            $q2->id => $q2->options->firstWhere('label', 'S')->id,  // 3
            $q3->id => $q3->options->firstWhere('label', 'KS')->id, // 2
            $q4->id => $q4->options->firstWhere('label', 'TS')->id, // 4 (reversed)
        ];

        $postResponse = $this->actingAs($studentUser)->post('/student/assessment/' . $assessment->id . '/submit', [
            'answers' => $answers,
        ]);
        $postResponse->assertSessionHasNoErrors();

        // Total score earned: 4 + 3 + 2 + 4 = 13. Max: 16. Percentage: 13 / 16 = 81.3%
        $progress = \App\Models\StudentProgress::where('student_id', $this->student->id)
            ->where('assessment_id', $assessment->id)
            ->first();

        $this->assertNotNull($progress);
        $this->assertEquals('selesai', $progress->status);
        $this->assertEquals(81.3, $progress->nilai);

        // Verify counselor evaluation integration
        $eval = StudentEvaluation::where('student_id', $this->student->id)
            ->where('module_id', $assessment->module_id)
            ->first();
        $this->assertNotNull($eval);
        $this->assertEquals(13, $eval->lkpd_score);
    }
}
