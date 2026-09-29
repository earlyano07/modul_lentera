<?php

namespace Tests\Feature\Student;

use App\Models\Assessment;
use App\Models\Kelas;
use App\Models\Module;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Role;
use App\Models\School;
use App\Models\Student;
use App\Models\StudentEvaluation;
use App\Models\StudentProgress;
use App\Models\User;
use App\Services\ProgressService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssessmentScoringTest extends TestCase
{
    use RefreshDatabase;

    private User $studentUser;
    private Student $student;
    private Module $module;
    private Assessment $assessment;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['id' => Role::ADMIN], ['nama' => 'admin']);
        Role::firstOrCreate(['id' => Role::KONSELOR], ['nama' => 'konselor']);
        Role::firstOrCreate(['id' => Role::SISWA], ['nama' => 'siswa']);

        $school = School::create(['nama' => 'SMP Test', 'status' => true]);
        $kelas = Kelas::create([
            'school_id' => $school->id,
            'nama_kelas' => 'VIII A',
            'tingkat' => 'VIII',
            'tahun_ajaran' => '2025/2026',
        ]);

        $this->studentUser = User::create([
            'role_id' => Role::SISWA,
            'nama' => 'Budi Santoso',
            'email' => 'budi@test.com',
            'password' => bcrypt('password'),
        ]);

        $this->student = Student::create([
            'user_id' => $this->studentUser->id,
            'kelas_id' => $kelas->id,
            'nis' => '10001',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '2010-01-01',
        ]);

        $this->module = Module::create([
            'judul' => 'Topik 1: Emotional Empathy',
            'urutan' => 1,
            'status' => true,
        ]);

        $this->assessment = Assessment::create([
            'module_id' => $this->module->id,
            'judul' => 'Penilaian Diri',
            'jenis' => 'penilaian_diri',
            'max_skor' => 8,
            'urutan' => 1,
        ]);

        // Add 2 questions with Likert options: SS(4), S(3), KS(2), TS(1)
        for ($i = 1; $i <= 2; $i++) {
            $q = Question::create([
                'assessment_id' => $this->assessment->id,
                'question' => "Pernyataan {$i}",
                'type' => 'multiple_choice',
                'score' => 4,
                'urutan' => $i,
            ]);

            QuestionOption::create(['question_id' => $q->id, 'label' => 'SS', 'option' => 'Sangat Sesuai', 'score' => 4]);
            QuestionOption::create(['question_id' => $q->id, 'label' => 'S', 'option' => 'Sesuai', 'score' => 3]);
            QuestionOption::create(['question_id' => $q->id, 'label' => 'KS', 'option' => 'Kurang Sesuai', 'score' => 2]);
            QuestionOption::create(['question_id' => $q->id, 'label' => 'TS', 'option' => 'Tidak Sesuai', 'score' => 1]);
        }
    }

    public function test_assessment_calculates_weighted_score_and_syncs_raw_score_to_evaluation(): void
    {
        $this->assessment->load('questions.options');
        $questions = $this->assessment->questions;

        // Q1 answer: S (score 3)
        // Q2 answer: SS (score 4)
        // Total raw score = 7 out of max 8
        // Percentage = round((7 / 8) * 100, 1) = 87.5%
        $answers = [
            $questions[0]->id => $questions[0]->options->firstWhere('label', 'S')->id,
            $questions[1]->id => $questions[1]->options->firstWhere('label', 'SS')->id,
        ];

        $service = app(ProgressService::class);
        $service->completeAssessment($this->student, $this->assessment, $answers);

        // Verify StudentProgress
        $progress = StudentProgress::where('student_id', $this->student->id)
            ->where('assessment_id', $this->assessment->id)
            ->first();

        $this->assertNotNull($progress);
        $this->assertEquals('selesai', $progress->status);
        $this->assertEquals(87.5, (float)$progress->nilai);

        // Verify StudentEvaluation
        $evaluation = StudentEvaluation::where('student_id', $this->student->id)
            ->where('module_id', $this->module->id)
            ->first();

        $this->assertNotNull($evaluation);
        $this->assertEquals(7, $evaluation->self_score);
    }

    public function test_adding_new_assessment_to_module_does_not_cause_redirect_loop_when_student_has_prior_evaluation(): void
    {
        // 1. Student completed first assessment (Penilaian Diri) and evaluation has self_score
        StudentEvaluation::create([
            'student_id' => $this->student->id,
            'module_id' => $this->module->id,
            'self_score' => 15,
            'lkpd_score' => 18,
            'commitment_score' => 5,
        ]);

        // 2. Admin adds a new assessment (e.g. Refleksi Diri) to the same module
        $newAssessment = Assessment::create([
            'module_id' => $this->module->id,
            'judul' => 'Refleksi Diri Kasus Baru',
            'jenis' => 'refleksi_diri',
            'urutan' => 2,
        ]);

        // 3. Student visits show page for the newly added assessment
        $response = $this->actingAs($this->studentUser)
            ->get(route('student.assessment.show', $newAssessment->id));

        // It must NOT redirect in an infinite loop; it must render show view with 200 OK
        $response->assertStatus(200);
        $response->assertSee('Refleksi Diri Kasus Baru');

        // 4. Visiting result before submitting should redirect cleanly to show without looping
        $resultResponse = $this->actingAs($this->studentUser)
            ->get(route('student.assessment.result', $newAssessment->id));

        $resultResponse->assertRedirect(route('student.assessment.show', $newAssessment->id));
    }
}
