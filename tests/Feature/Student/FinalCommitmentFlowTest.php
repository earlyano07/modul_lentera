<?php

namespace Tests\Feature\Student;

use App\Models\Assessment;
use App\Models\Kelas;
use App\Models\Konselor;
use App\Models\Module;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Role;
use App\Models\School;
use App\Models\Student;
use App\Models\StudentProgress;
use App\Models\User;
use App\Services\ProgressService;
use Database\Seeders\FinalCommitmentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FinalCommitmentFlowTest extends TestCase
{
    use RefreshDatabase;

    private User $studentUser;
    private Student $student;
    private User $counselorUser;
    private array $modules = [];
    private Module $commitmentModule;
    private Assessment $commitmentAssessment;
    private Question $qChecklist;
    private Question $qEssay;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['id' => Role::ADMIN], ['nama' => 'admin']);
        Role::firstOrCreate(['id' => Role::KONSELOR], ['nama' => 'konselor']);
        Role::firstOrCreate(['id' => Role::SISWA], ['nama' => 'siswa']);

        $school = School::create(['nama' => 'SMP Negeri 1 Blitar', 'status' => true]);
        $kelas = Kelas::create([
            'school_id' => $school->id,
            'nama_kelas' => 'VIII A',
            'tingkat' => 'VIII',
            'tahun_ajaran' => '2025/2026',
        ]);

        $this->counselorUser = User::create([
            'role_id' => Role::KONSELOR,
            'nama' => 'Guru BK LENTERA',
            'email' => 'counselor@test.com',
            'password' => bcrypt('password'),
        ]);
        $konselor = Konselor::create(['user_id' => $this->counselorUser->id, 'nip' => '198501012010011001']);
        $konselor->schools()->attach($school->id);

        $this->studentUser = User::create([
            'role_id' => Role::SISWA,
            'nama' => 'Ahmad Siswa',
            'email' => 'ahmad@test.com',
            'password' => bcrypt('password'),
        ]);

        $this->student = Student::create([
            'user_id' => $this->studentUser->id,
            'kelas_id' => $kelas->id,
            'nis' => '10001',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '2010-01-01',
        ]);

        // Create Topics 1 to 5
        for ($i = 1; $i <= 5; $i++) {
            $mod = Module::create([
                'urutan' => $i,
                'judul' => "Topik $i",
                'subtitle' => "Subtitle $i",
                'status' => true,
            ]);
            $ass = Assessment::create([
                'module_id' => $mod->id,
                'judul' => "Penilaian Diri Topik $i",
                'jenis' => 'penilaian_diri',
                'urutan' => 1,
            ]);
            $this->modules[$i] = ['module' => $mod, 'assessment' => $ass];
        }

        // Seed Final Commitment Module (Module 6)
        $this->seed(FinalCommitmentSeeder::class);
        $this->commitmentModule = Module::where('urutan', 6)->first();
        $this->commitmentAssessment = $this->commitmentModule->assessments()->first();
        $this->qChecklist = $this->commitmentAssessment->questions()->where('type', 'checklist')->first();
        $this->qEssay = $this->commitmentAssessment->questions()->where('type', 'essay')->first();
    }

    public function test_commitment_module_is_locked_when_topics_are_incomplete(): void
    {
        $progressService = app(ProgressService::class);

        $this->assertFalse($progressService->hasCompletedAllTopics($this->student));
        $this->assertFalse($progressService->canAccessModule($this->student, $this->commitmentModule));
        $this->assertFalse($progressService->isProgramCompleted($this->student));

        // Attempting to access module route redirects back
        $response = $this->actingAs($this->studentUser)
            ->get(route('student.module', $this->commitmentModule->id));

        $response->assertRedirect(route('student.roadmap'));
        $response->assertSessionHas('error');
    }

    public function test_commitment_module_unlocks_when_all_5_topics_are_completed(): void
    {
        $progressService = app(ProgressService::class);

        // Complete all 5 topics
        foreach ($this->modules as $item) {
            StudentProgress::create([
                'student_id' => $this->student->id,
                'module_id' => $item['module']->id,
                'assessment_id' => $item['assessment']->id,
                'status' => 'selesai',
                'nilai' => 85,
                'finished_at' => now(),
            ]);
        }

        $this->assertTrue($progressService->hasCompletedAllTopics($this->student));
        $this->assertTrue($progressService->canAccessModule($this->student, $this->commitmentModule));
        // Program not yet completed because final commitment sheet is not submitted
        $this->assertFalse($progressService->isProgramCompleted($this->student));

        // Roadmap displays the final commitment as available
        $response = $this->actingAs($this->studentUser)
            ->get(route('student.roadmap'));

        $response->assertStatus(200);
        $response->assertSee('Tahap Akhir: Lembar Komitmen Siswa');
        $response->assertSee('Tersedia — Silakan Isi Komitmen Anda');
        $response->assertSee('Isi Lembar Komitmen');
    }

    public function test_student_completes_final_commitment_and_unlocks_certificate(): void
    {
        $progressService = app(ProgressService::class);

        // 1. Complete topics 1 to 5
        foreach ($this->modules as $item) {
            StudentProgress::create([
                'student_id' => $this->student->id,
                'module_id' => $item['module']->id,
                'assessment_id' => $item['assessment']->id,
                'status' => 'selesai',
                'nilai' => 90,
                'finished_at' => now(),
            ]);
        }

        // 2. Submit Final Commitment
        $options = $this->qChecklist->options;
        $selectedOptionIds = [$options[0]->id, $options[1]->id, $options[4]->id];
        $myEssay = 'Mulai sekarang, saya berjanji akan aktif membela teman yang diejek dan tidak menjadi bystander pasif.';

        $answers = [
            $this->qChecklist->id => $selectedOptionIds,
            $this->qEssay->id => $myEssay,
        ];

        $progressService->completeAssessment($this->student, $this->commitmentAssessment, $answers);

        // 3. Verify program completion
        $this->assertTrue($progressService->hasCompletedFinalCommitment($this->student));
        $this->assertTrue($progressService->isProgramCompleted($this->student));
        $this->assertEquals(100.0, $progressService->getProgressPercentage($this->student));

        // 4. Check Roadmap displays completion banner
        $roadmapRes = $this->actingAs($this->studentUser)
            ->get(route('student.roadmap'));

        $roadmapRes->assertStatus(200);
        $roadmapRes->assertSee('Selamat! Anda Telah Menyelesaikan Layanan Model LENTERA');
        $roadmapRes->assertSee('Lembar Komitmen Selesai');

        // 5. Check Certificate page contains student's selected commitment points and essay
        $certRes = $this->actingAs($this->studentUser)
            ->get(route('student.certificate'));

        $certRes->assertStatus(200);
        $certRes->assertSee('KOMITMEN SAYA');
        $certRes->assertSee($options[0]->option);
        $certRes->assertSee($options[1]->option);
        $certRes->assertSee($options[4]->option);
        $certRes->assertSee($myEssay);

        // 6. Check Counselor can view student's final commitment in student detail
        $counselorRes = $this->actingAs($this->counselorUser)
            ->get(route('counselor.monitoring.student.detail', $this->student->id));

        $counselorRes->assertStatus(200);
        $counselorRes->assertSee('Tahap Akhir Layanan Model LENTERA');
        $counselorRes->assertSee('Lembar Komitmen Siswa');
        $counselorRes->assertSee($options[0]->option);
        $counselorRes->assertSee($myEssay);
    }

    public function test_final_commitment_all_checked_yields_100_percent_score(): void
    {
        $progressService = app(ProgressService::class);
        $options = $this->qChecklist->options;
        $allOptionIds = $options->pluck('id')->toArray();

        // When ALL options are checked
        $answersAll = [
            $this->qChecklist->id => $allOptionIds,
            $this->qEssay->id => 'Ikrar komitmen pribadi saya.',
        ];

        $scoreAll = $progressService->calculateScore($this->commitmentAssessment, $answersAll);
        $this->assertEquals(100.0, $scoreAll);

        // When 3 out of 5 options are checked (3/5 = 60%)
        $answersThree = [
            $this->qChecklist->id => [$allOptionIds[0], $allOptionIds[1], $allOptionIds[2]],
            $this->qEssay->id => 'Ikrar komitmen pribadi saya.',
        ];

        $scoreThree = $progressService->calculateScore($this->commitmentAssessment, $answersThree);
        $this->assertEquals(60.0, $scoreThree);

        // Verify StudentProgress record saves 100%
        $progress = $progressService->completeAssessment($this->student, $this->commitmentAssessment, $answersAll);
        $this->assertEquals(100.0, (float)$progress->nilai);
    }
}
