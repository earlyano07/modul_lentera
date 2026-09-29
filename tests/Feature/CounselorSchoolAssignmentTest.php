<?php

namespace Tests\Feature;

use App\Models\Konselor;
use App\Models\Role;
use App\Models\School;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CounselorSchoolAssignmentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    private function createCounselorUser(): User
    {
        $user = User::create([
            'nama' => 'Konselor Test, S.Pd.',
            'email' => 'konselor_test@lentera.test',
            'password' => Hash::make('password123'),
            'role_id' => Role::KONSELOR,
            'status' => true,
        ]);

        Konselor::create([
            'user_id' => $user->id,
            'nip' => '198501012010011099',
            'no_hp' => '081234567899',
        ]);

        return $user;
    }

    public function test_counselor_can_view_monitoring_schools_page_with_assign_button(): void
    {
        $counselor = $this->createCounselorUser();
        $school1 = School::create(['nama' => 'SMP Negeri 1 Model', 'status' => true]);
        $school2 = School::create(['nama' => 'SMP Negeri 2 Model', 'status' => true]);

        $response = $this->actingAs($counselor)->get(route('counselor.monitoring.schools'));

        $response->assertStatus(200);
        $response->assertSee('Monitoring Sekolah Binaan');
        $response->assertSee('Assign Sekolah');
        $response->assertSee($school1->nama);
        $response->assertSee($school2->nama);
    }

    public function test_counselor_can_assign_schools(): void
    {
        $counselor = $this->createCounselorUser();
        $school1 = School::create(['nama' => 'SMP Negeri 1 Model', 'status' => true]);
        $school2 = School::create(['nama' => 'SMP Negeri 2 Model', 'status' => true]);
        $school3 = School::create(['nama' => 'SMP Negeri 3 Model', 'status' => true]);

        $response = $this->actingAs($counselor)->post(route('counselor.monitoring.schools.assign'), [
            'schools' => [$school1->id, $school3->id],
        ]);

        $response->assertRedirect(route('counselor.monitoring.schools'));
        $response->assertSessionHas('success');

        $konselor = $counselor->fresh()->konselor;
        $this->assertCount(2, $konselor->schools);
        $this->assertTrue($konselor->schools->contains($school1->id));
        $this->assertTrue($konselor->schools->contains($school3->id));
        $this->assertFalse($konselor->schools->contains($school2->id));
    }

    public function test_counselor_can_update_or_remove_assigned_schools(): void
    {
        $counselor = $this->createCounselorUser();
        $school1 = School::create(['nama' => 'SMP Negeri 1 Model', 'status' => true]);
        $counselor->konselor->schools()->attach([$school1->id]);

        $this->assertCount(1, $counselor->fresh()->konselor->schools);

        // Deselect / empty assignment
        $response = $this->actingAs($counselor)->post(route('counselor.monitoring.schools.assign'), [
            'schools' => [],
        ]);

        $response->assertRedirect(route('counselor.monitoring.schools'));
        $this->assertCount(0, $counselor->fresh()->konselor->schools);
    }

    public function test_student_cannot_assign_schools(): void
    {
        $student = User::create([
            'nama' => 'Siswa Test',
            'username' => 'siswa_test',
            'password' => Hash::make('password123'),
            'role_id' => Role::SISWA,
            'status' => true,
        ]);

        $school = School::create(['nama' => 'SMP Negeri 1 Model', 'status' => true]);

        $response = $this->actingAs($student)->post(route('counselor.monitoring.schools.assign'), [
            'schools' => [$school->id],
        ]);

        // Student should be forbidden (403) by role middleware
        $response->assertStatus(403);
    }
}
