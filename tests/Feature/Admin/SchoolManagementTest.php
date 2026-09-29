<?php

namespace Tests\Feature\Admin;

use App\Models\Role;
use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchoolManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $school;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role_id' => Role::ADMIN,
            'nama' => 'Admin Test',
            'email' => 'admin@test.com',
        ]);

        $this->school = School::create([
            'nama' => 'SMP Negeri 1 Lentera',
            'alamat' => 'Jl. Pendidikan No. 10',
            'telepon' => '021-1234567',
            'npsn' => '20102030',
            'status' => true,
        ]);
    }

    public function test_admin_can_view_school_detail_page_with_edit_modal()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.schools.show', $this->school));

        $response->assertStatus(200);
        $response->assertSee('Detail Sekolah: SMP Negeri 1 Lentera');
        $response->assertSee('schoolDetailManager');
        $response->assertSee('openEditModal()');
        $response->assertSee('Edit Detail Sekolah');
        $response->assertSee(route('admin.schools.update', $this->school));
        $response->assertSee('showEditModal');
        $response->assertDontSee('"{this.$refs');
    }

    public function test_admin_can_update_school_from_show_page_modal_and_redirect_back()
    {
        $response = $this->actingAs($this->admin)->put(route('admin.schools.update', $this->school), [
            'nama' => 'SMP Negeri 1 Lentera Updated',
            'alamat' => 'Jl. Baru No. 20',
            'telepon' => '021-7654321',
            'npsn' => '20102031',
            'status' => '1',
            '_redirect_to' => route('admin.schools.show', $this->school),
        ]);

        $response->assertRedirect(route('admin.schools.show', $this->school));
        $response->assertSessionHas('success', 'Sekolah berhasil diperbarui.');

        $this->assertDatabaseHas('schools', [
            'id' => $this->school->id,
            'nama' => 'SMP Negeri 1 Lentera Updated',
            'alamat' => 'Jl. Baru No. 20',
            'telepon' => '021-7654321',
            'npsn' => '20102031',
        ]);
    }

    public function test_admin_updates_school_without_redirect_to_redirects_to_index()
    {
        $response = $this->actingAs($this->admin)->put(route('admin.schools.update', $this->school), [
            'nama' => 'SMP Negeri 1 Lentera Updated Index',
            'status' => '1',
        ]);

        $response->assertRedirect(route('admin.schools.index'));
        $response->assertSessionHas('success', 'Sekolah berhasil diperbarui.');
    }

    public function test_admin_can_view_school_detail_with_add_class_and_add_student_buttons()
    {
        $kelas = \App\Models\Kelas::create([
            'school_id' => $this->school->id,
            'nama_kelas' => 'VII A',
            'tingkat' => 'VII',
            'tahun_ajaran' => '2025/2026',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.schools.show', $this->school));

        $response->assertStatus(200);
        $response->assertSee('openCreateClassModal()');
        $response->assertSee('Tambah Kelas Baru');
        $response->assertSee('openCreateStudentModal(' . $kelas->id);
        $response->assertSee('Tambah Siswa');
        $response->assertSee('Tambah Siswa Baru');
    }

    public function test_admin_can_create_class_from_school_show_modal_and_redirect_back()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.kelas.store'), [
            'school_id' => $this->school->id,
            'nama_kelas' => 'VIII B',
            'tingkat' => 'VIII',
            'tahun_ajaran' => '2025/2026',
            '_redirect_to' => route('admin.schools.show', $this->school),
        ]);

        $response->assertRedirect(route('admin.schools.show', $this->school));
        $response->assertSessionHas('success', 'Kelas berhasil ditambahkan.');

        $this->assertDatabaseHas('kelas', [
            'school_id' => $this->school->id,
            'nama_kelas' => 'VIII B',
            'tingkat' => 'VIII',
            'tahun_ajaran' => '2025/2026',
        ]);
    }

    public function test_admin_can_create_student_from_school_show_modal_and_redirect_back()
    {
        $kelas = \App\Models\Kelas::create([
            'school_id' => $this->school->id,
            'nama_kelas' => 'IX C',
            'tingkat' => 'IX',
            'tahun_ajaran' => '2025/2026',
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.students.store'), [
            'school_id' => $this->school->id,
            'kelas_id' => $kelas->id,
            'nama' => 'Siswa Baru Sekolah',
            'username' => 'siswaschool123',
            'email' => 'siswaschool@test.com',
            'password' => 'password123',
            'nis' => '889900',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '2009-08-17',
            '_redirect_to' => route('admin.schools.show', $this->school),
        ]);

        $response->assertRedirect(route('admin.schools.show', $this->school));
        $response->assertSessionHas('success', 'Siswa berhasil ditambahkan.');

        $this->assertDatabaseHas('users', [
            'nama' => 'Siswa Baru Sekolah',
            'username' => 'siswaschool123',
            'email' => 'siswaschool@test.com',
        ]);
        $this->assertDatabaseHas('students', [
            'kelas_id' => $kelas->id,
            'nis' => '889900',
            'jenis_kelamin' => 'L',
        ]);
    }
}
