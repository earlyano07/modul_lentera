<?php

namespace Tests\Feature;

use App\Models\Kelas;
use App\Models\Role;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class StudentProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    private function createStudentUser(string $name = 'Budi Santoso', string $username = 'budi123', string $password = 'Secret123!'): User
    {
        $school = School::create([
            'nama' => 'SMP Negeri 1 Model',
            'status' => true,
        ]);

        $kelas = Kelas::create([
            'school_id' => $school->id,
            'nama_kelas' => 'VIII A',
            'tingkat' => 'VIII',
            'tahun_ajaran' => '2025/2026',
        ]);

        $user = User::create([
            'nama' => $name,
            'username' => $username,
            'password' => Hash::make($password),
            'role_id' => Role::SISWA,
            'status' => true,
        ]);

        Student::create([
            'user_id' => $user->id,
            'kelas_id' => $kelas->id,
            'nis' => '10001',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '2010-01-01',
        ]);

        return $user;
    }

    public function test_student_can_view_profile_page(): void
    {
        $student = $this->createStudentUser();

        $response = $this->actingAs($student)->get(route('student.profile.edit'));

        $response->assertStatus(200);
        $response->assertSee('Profil Akun');
        $response->assertSee($student->username);
    }

    public function test_student_can_update_username(): void
    {
        $student = $this->createStudentUser('Budi', 'budi_awal');

        $response = $this->actingAs($student)->put(route('student.profile.update-username'), [
            'username' => 'budi_baru_123',
        ]);

        $response->assertSessionHas('success');
        $response->assertRedirect(route('student.profile.edit'));
        $this->assertDatabaseHas('users', [
            'id' => $student->id,
            'username' => 'budi_baru_123',
        ]);
    }

    public function test_student_cannot_use_existing_username(): void
    {
        $student1 = $this->createStudentUser('Budi', 'user_pertama');

        $student2 = User::create([
            'nama' => 'Siti',
            'username' => 'user_kedua',
            'password' => Hash::make('Secret123!'),
            'role_id' => Role::SISWA,
            'status' => true,
        ]);

        $response = $this->actingAs($student2)->put(route('student.profile.update-username'), [
            'username' => 'user_pertama',
        ]);

        $response->assertSessionHasErrors('username');
        $this->assertDatabaseHas('users', [
            'id' => $student2->id,
            'username' => 'user_kedua',
        ]);
    }

    public function test_student_can_update_password(): void
    {
        $student = $this->createStudentUser('Budi', 'budi_pw', 'OldPass123!');

        $response = $this->actingAs($student)->put(route('student.profile.update-password'), [
            'current_password' => 'OldPass123!',
            'password' => 'NewSecretPassword123!',
            'password_confirmation' => 'NewSecretPassword123!',
        ]);

        $response->assertSessionHas('success');
        $response->assertRedirect(route('student.profile.edit'));
        $this->assertTrue(Hash::check('NewSecretPassword123!', $student->fresh()->password));
    }

    public function test_student_cannot_update_password_with_wrong_current_password(): void
    {
        $student = $this->createStudentUser('Budi', 'budi_pw2', 'OldPass123!');

        $response = $this->actingAs($student)->put(route('student.profile.update-password'), [
            'current_password' => 'WrongPassword123!',
            'password' => 'NewSecretPassword123!',
            'password_confirmation' => 'NewSecretPassword123!',
        ]);

        $response->assertSessionHasErrors('current_password');
        $this->assertTrue(Hash::check('OldPass123!', $student->fresh()->password));
    }
}
