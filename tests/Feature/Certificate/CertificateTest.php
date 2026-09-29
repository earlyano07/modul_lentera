<?php

namespace Tests\Feature\Certificate;

use App\Models\Assessment;
use App\Models\CertificateTemplate;
use App\Models\Kelas;
use App\Models\Konselor;
use App\Models\Module;
use App\Models\Role;
use App\Models\School;
use App\Models\Student;
use App\Models\StudentProgress;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CertificateTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;
    private User $counselorUser;
    private User $studentUser;
    private Student $student;
    private School $school;
    private Kelas $kelas;
    private Module $module;
    private Assessment $assessment;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['id' => Role::ADMIN], ['nama' => 'admin']);
        Role::firstOrCreate(['id' => Role::KONSELOR], ['nama' => 'konselor']);
        Role::firstOrCreate(['id' => Role::SISWA], ['nama' => 'siswa']);

        $this->school = School::create(['nama' => 'SMP Test Model', 'status' => true]);
        $this->kelas = Kelas::create([
            'school_id' => $this->school->id,
            'nama_kelas' => 'VIII B',
            'tingkat' => 'VIII',
            'tahun_ajaran' => '2025/2026',
        ]);

        $this->adminUser = User::create([
            'role_id' => Role::ADMIN,
            'nama' => 'Admin Sistem',
            'email' => 'admin.cert@test.com',
            'password' => bcrypt('password'),
        ]);

        $this->counselorUser = User::create([
            'role_id' => Role::KONSELOR,
            'nama' => 'Guru BK Test',
            'email' => 'counselor.cert@test.com',
            'password' => bcrypt('password'),
        ]);
        $konselor = Konselor::create([
            'user_id' => $this->counselorUser->id,
            'nip' => '198001012005011001',
        ]);
        $konselor->schools()->attach($this->school->id);

        $this->studentUser = User::create([
            'role_id' => Role::SISWA,
            'nama' => 'Rian Pratama',
            'email' => 'rian@test.com',
            'password' => bcrypt('password'),
        ]);
        $this->student = Student::create([
            'user_id' => $this->studentUser->id,
            'kelas_id' => $this->kelas->id,
            'nis' => '10293',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '2010-05-12',
        ]);

        $this->module = Module::create([
            'urutan' => 1,
            'judul' => 'Topik 1: Menyadari Masalah',
            'status' => true,
        ]);
        $this->assessment = Assessment::create([
            'module_id' => $this->module->id,
            'judul' => 'Penilaian Diri',
            'jenis' => 'penilaian_diri',
            'urutan' => 1,
        ]);
    }

    public function test_admin_can_view_certificate_template_page(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.certificate-template.index'));

        $response->assertStatus(200);
        $response->assertSee('Template Sertifikat (Microsoft Word)');
    }

    public function test_admin_can_reset_certificate_template(): void
    {
        // First set custom docx
        $template = CertificateTemplate::getActive();
        $template->update(['docx_template_path' => 'templates/custom.docx']);

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.certificate-template.reset'));

        $response->assertRedirect(route('admin.certificate-template.index'));
        $this->assertDatabaseHas('certificate_templates', [
            'id' => $template->id,
            'docx_template_path' => null,
        ]);
    }

    public function test_incomplete_student_cannot_view_certificate(): void
    {
        $response = $this->actingAs($this->studentUser)
            ->get(route('student.certificate'));

        $response->assertRedirect(route('student.roadmap'));
        $response->assertSessionHas('warning');
    }

    public function test_completed_student_can_view_certificate(): void
    {
        // Complete the single assessment
        StudentProgress::create([
            'student_id' => $this->student->id,
            'module_id' => $this->module->id,
            'assessment_id' => $this->assessment->id,
            'status' => 'selesai',
            'nilai' => 90.0,
            'finished_at' => now(),
        ]);

        $response = $this->actingAs($this->studentUser)
            ->get(route('student.certificate'));

        $response->assertStatus(200);
        $response->assertSee($this->studentUser->nama);
        $response->assertSee('REKAP CAPAIAN LAYANAN');
    }

    public function test_counselor_can_view_completed_student_certificate(): void
    {
        StudentProgress::create([
            'student_id' => $this->student->id,
            'module_id' => $this->module->id,
            'assessment_id' => $this->assessment->id,
            'status' => 'selesai',
            'nilai' => 88.0,
            'finished_at' => now(),
        ]);

        $response = $this->actingAs($this->counselorUser)
            ->get(route('counselor.monitoring.student.certificate', $this->student->id));

        $response->assertStatus(200);
        $response->assertSee($this->studentUser->nama);
    }

    public function test_counselor_cannot_view_certificate_for_unassigned_school(): void
    {
        $otherSchool = School::create(['nama' => 'Sekolah Lain', 'status' => true]);
        $otherKelas = Kelas::create([
            'school_id' => $otherSchool->id,
            'nama_kelas' => 'VIII C',
            'tingkat' => 'VIII',
            'tahun_ajaran' => '2025/2026',
        ]);
        $otherUser = User::create([
            'role_id' => Role::SISWA,
            'nama' => 'Doni',
            'email' => 'doni@test.com',
            'password' => bcrypt('password'),
        ]);
        $otherStudent = Student::create([
            'user_id' => $otherUser->id,
            'kelas_id' => $otherKelas->id,
            'nis' => '10294',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '2010-05-12',
        ]);

        $response = $this->actingAs($this->counselorUser)
            ->get(route('counselor.monitoring.student.certificate', $otherStudent->id));

        $response->assertStatus(403);
    }

    public function test_admin_can_download_default_docx_template(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.certificate-template.download-default-docx-template'));

        $response->assertStatus(200);
        $response->assertHeader('content-disposition', 'attachment; filename=Template_Sertifikat_Lentera_Standar.docx');
    }

    public function test_admin_can_download_active_docx_template(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.certificate-template.download-docx-template'));

        $response->assertStatus(200);
        $response->assertHeader('content-disposition', 'attachment; filename=Template_Sertifikat_Lentera.docx');
    }

    public function test_admin_can_preview_sample_docx(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.certificate-template.preview-docx'));

        $response->assertStatus(200);
        $response->assertHeader('content-disposition', 'attachment; filename=Pratinjau_Sertifikat_Contoh.docx');
    }

    public function test_admin_can_upload_custom_docx_template(): void
    {
        \Illuminate\Support\Facades\Storage::fake('local');
        $file = \Illuminate\Http\UploadedFile::fake()->create('custom_sertifikat.docx', 100, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.certificate-template.upload-docx'), [
                'docx_template' => $file,
            ]);

        $response->assertRedirect(route('admin.certificate-template.index'));
        $response->assertSessionHas('success');

        $template = CertificateTemplate::getActive();
        $this->assertNotNull($template->docx_template_path);
    }

    public function test_completed_student_can_download_docx(): void
    {
        StudentProgress::create([
            'student_id' => $this->student->id,
            'module_id' => $this->module->id,
            'assessment_id' => $this->assessment->id,
            'status' => 'selesai',
            'nilai' => 95.0,
            'finished_at' => now(),
        ]);

        $response = $this->actingAs($this->studentUser)
            ->get(route('student.certificate.docx'));

        $response->assertStatus(200);
        $this->assertStringContainsString('.docx', $response->headers->get('content-disposition'));
    }

    public function test_incomplete_student_cannot_download_docx(): void
    {
        $response = $this->actingAs($this->studentUser)
            ->get(route('student.certificate.docx'));

        $response->assertRedirect(route('student.roadmap'));
        $response->assertSessionHas('warning');
    }

    public function test_counselor_can_download_student_docx(): void
    {
        StudentProgress::create([
            'student_id' => $this->student->id,
            'module_id' => $this->module->id,
            'assessment_id' => $this->assessment->id,
            'status' => 'selesai',
            'nilai' => 88.0,
            'finished_at' => now(),
        ]);

        $response = $this->actingAs($this->counselorUser)
            ->get(route('counselor.monitoring.student.certificate.docx', $this->student->id));

        $response->assertStatus(200);
        $this->assertStringContainsString('.docx', $response->headers->get('content-disposition'));
    }

    public function test_counselor_can_view_certificate_for_incomplete_student(): void
    {
        // Student has 0 progress
        $response = $this->actingAs($this->counselorUser)
            ->get(route('counselor.monitoring.student.certificate', $this->student->id));

        $response->assertStatus(200);
        $response->assertSee($this->studentUser->nama);
    }

    public function test_counselor_can_download_docx_for_incomplete_student(): void
    {
        // Student has 0 progress
        $response = $this->actingAs($this->counselorUser)
            ->get(route('counselor.monitoring.student.certificate.docx', $this->student->id));

        $response->assertStatus(200);
        $this->assertStringContainsString('.docx', $response->headers->get('content-disposition'));
    }

    public function test_admin_can_update_certificate_metadata(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->put(route('admin.certificate-template.update-metadata'), [
                'signer_mode' => 'custom',
                'default_signer_name' => 'Dra. Hj. Siti Nurjanah, M.Pd.',
                'default_signer_nip' => '19750812 200212 2 001',
                'signer_title' => 'Koordinator Guru BK',
                'cert_number_prefix' => 'SERTIF',
                'cert_number_format' => 'No: {PREFIX}/{YEAR}/{CLASS}/{ID}',
                'date_type' => 'fixed_date',
                'fixed_date' => '2026-10-15',
            ]);

        $response->assertRedirect(route('admin.certificate-template.index'));
        $response->assertSessionHas('success');

        $template = CertificateTemplate::getActive();
        $this->assertEquals('custom', $template->signer_mode);
        $this->assertEquals('Dra. Hj. Siti Nurjanah, M.Pd.', $template->default_signer_name);
        $this->assertEquals('SERTIF', $template->cert_number_prefix);
        $this->assertEquals('fixed_date', $template->date_type);
    }

    public function test_certificate_data_respects_custom_metadata(): void
    {
        $template = CertificateTemplate::getActive();
        $template->update([
            'signer_mode' => 'custom',
            'default_signer_name' => 'Dr. Bambang Sutopo, M.Si.',
            'default_signer_nip' => '196803201994031002',
            'cert_number_prefix' => 'LTR-CUSTOM',
            'cert_number_format' => 'No: {PREFIX}/{YEAR}/{CLASS}/{ID}',
            'date_type' => 'fixed_date',
            'fixed_date' => '2026-12-31',
        ]);

        $service = app(\App\Services\CertificateService::class);
        $data = $service->getCertificateData($this->student);

        $this->assertEquals('Dr. Bambang Sutopo, M.Si.', $data['signer_name']);
        $this->assertStringContainsString('196803201994031002', $data['signer_nip']);
        $this->assertStringContainsString('LTR-CUSTOM', $data['cert_number']);
        $this->assertStringContainsString('31 Desember 2026', $data['issue_date']);
    }
}