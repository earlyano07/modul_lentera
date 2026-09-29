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
        $response->assertSee('filteredCreateClasses');
        $response->assertSee('filteredEditClasses');
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

    public function test_admin_can_view_create_student_page_with_schools_and_classes()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.students.create'));

        $response->assertStatus(200);
        $response->assertSee('Sekolah *');
        $response->assertSee('Kelas *');
        $response->assertSee($this->school->nama);
    }

    public function test_admin_can_store_student_with_school_and_class()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.students.store'), [
            'nama' => 'Siswa Baru',
            'username' => 'siswabaru1',
            'email' => 'siswa@sekolah.sch.id',
            'password' => 'password123',
            'school_id' => $this->school->id,
            'kelas_id' => $this->kelas->id,
            'nis' => '998877',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '2009-05-15',
        ]);

        $response->assertRedirect(route('admin.students.index'));
        $this->assertDatabaseHas('users', [
            'nama' => 'Siswa Baru',
            'username' => 'siswabaru1',
            'email' => 'siswa@sekolah.sch.id',
        ]);
        $this->assertDatabaseHas('students', [
            'kelas_id' => $this->kelas->id,
            'nis' => '998877',
        ]);
    }

    public function test_admin_can_view_edit_student_page()
    {
        $user = User::factory()->create([
            'role_id' => Role::SISWA,
            'nama' => 'Siswa Edit',
        ]);

        $student = Student::create([
            'user_id' => $user->id,
            'kelas_id' => $this->kelas->id,
            'nis' => '112233',
            'jenis_kelamin' => 'P',
            'tanggal_lahir' => '2008-04-10',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.students.edit', $student));

        $response->assertStatus(200);
        $response->assertSee('Sekolah *');
        $response->assertSee('Kelas *');
        $response->assertSee($this->school->nama);
    }

    public function test_admin_can_view_import_student_page()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.students.import.form'));

        $response->assertStatus(200);
        $response->assertSee('Pilih Sekolah *');
        $response->assertSee('Pilih Kelas *');
        $response->assertSee($this->school->nama);
    }

    public function test_admin_can_filter_students_by_school()
    {
        $school2 = School::create([
            'nama' => 'SMP Negeri 2 Lain',
            'status' => true,
        ]);
        $kelas2 = Kelas::create([
            'school_id' => $school2->id,
            'nama_kelas' => 'VII B',
            'tingkat' => 'VII',
            'tahun_ajaran' => '2025/2026',
        ]);

        $user1 = User::factory()->create(['role_id' => Role::SISWA, 'nama' => 'Siswa Sekolah 1']);
        Student::create([
            'user_id' => $user1->id,
            'kelas_id' => $this->kelas->id,
            'nis' => '11111',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '2008-01-01',
        ]);

        $user2 = User::factory()->create(['role_id' => Role::SISWA, 'nama' => 'Siswa Sekolah 2']);
        Student::create([
            'user_id' => $user2->id,
            'kelas_id' => $kelas2->id,
            'nis' => '22222',
            'jenis_kelamin' => 'P',
            'tanggal_lahir' => '2008-02-02',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.students.index', [
            'school_id' => $this->school->id,
        ]));

        $response->assertStatus(200);
        $response->assertSee('Filter Data Siswa');
        $response->assertSee('Siswa Sekolah 1');
        $response->assertDontSee('Siswa Sekolah 2');
    }

    public function test_admin_can_filter_students_by_class()
    {
        $kelas2 = Kelas::create([
            'school_id' => $this->school->id,
            'nama_kelas' => 'VIII B',
            'tingkat' => 'VIII',
            'tahun_ajaran' => '2025/2026',
        ]);

        $user1 = User::factory()->create(['role_id' => Role::SISWA, 'nama' => 'Siswa Kelas A']);
        Student::create([
            'user_id' => $user1->id,
            'kelas_id' => $this->kelas->id,
            'nis' => '33333',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '2008-03-03',
        ]);

        $user2 = User::factory()->create(['role_id' => Role::SISWA, 'nama' => 'Siswa Kelas B']);
        Student::create([
            'user_id' => $user2->id,
            'kelas_id' => $kelas2->id,
            'nis' => '44444',
            'jenis_kelamin' => 'P',
            'tanggal_lahir' => '2008-04-04',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.students.index', [
            'school_id' => $this->school->id,
            'kelas_id' => $kelas2->id,
        ]));

        $response->assertStatus(200);
        $response->assertSee('Siswa Kelas B');
        $response->assertDontSee('Siswa Kelas A');
    }
}
