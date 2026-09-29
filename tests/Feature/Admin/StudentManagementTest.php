<?php

namespace Tests\Feature\Admin;

use App\Models\Kelas;
use App\Models\Role;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $school;
    protected $kelas;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role_id' => Role::ADMIN,
            'nama' => 'Admin Test',
            'email' => 'admin@test.com',
        ]);

        $this->school = School::create([
            'nama' => 'SMP Test',
            'alamat' => 'Jl. Test',
            'telepon' => '08123456789',
            'npsn' => '12345678',
            'status' => true,
        ]);

        $this->kelas = Kelas::create([
            'school_id' => $this->school->id,
            'nama_kelas' => 'VIII A',
            'tingkat' => 'VIII',
            'tahun_ajaran' => '2025/2026',
        ]);
    }

    public function test_admin_can_view_students_list_with_username()
    {
        $user = User::factory()->create([
            'role_id' => Role::SISWA,
            'nama' => 'Budi Siswa',
            'username' => 'budisiswa123',
            'email' => 'budi@test.com',
        ]);

        Student::create([
            'user_id' => $user->id,
            'kelas_id' => $this->kelas->id,
            'nis' => '12345',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '2008-01-01',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.students.index'));

        $response->assertStatus(200);
        $response->assertSee('budisiswa123');
    }

    public function test_admin_can_update_student_username()
    {
        $user = User::factory()->create([
            'role_id' => Role::SISWA,
            'nama' => 'Budi Siswa',
            'username' => 'budi_lama',
            'email' => null,
        ]);

        $student = Student::create([
            'user_id' => $user->id,
            'kelas_id' => $this->kelas->id,
            'nis' => '12345',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '2008-01-01',
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.students.update', $student), [
            'nama' => 'Budi Baru',
            'username' => 'budi_baru',
            'email' => '',
            'kelas_id' => $this->kelas->id,
            'nis' => '12345',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '2008-01-01',
        ]);

        $response->assertRedirect(route('admin.students.index'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'nama' => 'Budi Baru',
            'username' => 'budi_baru',
            'email' => null,
        ]);
    }
}
