<?php

namespace Tests\Feature\Auth;

use App\Models\Kelas;
use App\Models\Role;
use App\Models\School;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_students_can_register_with_default_credentials(): void
    {
        $this->seed(RoleSeeder::class);

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

        $today = now()->format('d');
        $expectedUsername = 'bud10025' . $today;

        $response = $this->post('/register', [
            'nama' => 'Budi Pratama',
            'nis' => '10025',
            'kelas_id' => $kelas->id,
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '2010-05-15',
        ]);

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'nama' => 'Budi Pratama',
            'username' => $expectedUsername,
            'role_id' => Role::SISWA,
        ]);
        $this->assertDatabaseHas('students', [
            'nis' => '10025',
            'kelas_id' => $kelas->id,
            'jenis_kelamin' => 'L',
        ]);
        $student = \App\Models\Student::where('nis', '10025')->first();
        $this->assertNotNull($student);
        $this->assertSame('2010-05-15', $student->tanggal_lahir->format('Y-m-d'));
        $response->assertRedirect(route('register.success'));
        $response->assertSessionHas('registered_credentials');
    }
}
