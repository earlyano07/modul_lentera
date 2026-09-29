<?php

namespace Tests\Feature\Counselor;

use App\Models\Konselor;
use App\Models\Role;
use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CounselorProfileTest extends TestCase
{
    use RefreshDatabase;

    private User $counselorUser;
    private Konselor $konselor;
    private School $school;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['id' => Role::ADMIN], ['nama' => 'admin']);
        Role::firstOrCreate(['id' => Role::KONSELOR], ['nama' => 'konselor']);
        Role::firstOrCreate(['id' => Role::SISWA], ['nama' => 'siswa']);

        $this->school = School::create(['nama' => 'SMP Negeri 1 Model', 'status' => true]);

        $this->counselorUser = User::create([
            'role_id' => Role::KONSELOR,
            'nama' => 'Dra. Novia Hendratno, M.Pd.',
            'username' => 'novia_bk',
            'email' => 'novia@lentera.test',
            'password' => bcrypt('password123'),
            'status' => true,
        ]);

        $this->konselor = Konselor::create([
            'user_id' => $this->counselorUser->id,
            'nip' => '198503152010012021',
            'no_hp' => '081234567890',
        ]);
        $this->konselor->schools()->attach($this->school->id);
    }

    public function test_counselor_can_view_profile_page(): void
    {
        $response = $this->actingAs($this->counselorUser)
            ->get(route('counselor.profile.edit'));

        $response->assertStatus(200);
        $response->assertSee('Pengaturan Profil Konselor');
        $response->assertSee('Dra. Novia Hendratno, M.Pd.');
        $response->assertSee('198503152010012021');
        $response->assertSee('novia_bk');
        $response->assertSee('SMP Negeri 1 Model');
    }

    public function test_guest_cannot_view_counselor_profile_page(): void
    {
        $response = $this->get(route('counselor.profile.edit'));
        $response->assertRedirect(route('login'));
    }

    public function test_counselor_settings_redirects_to_profile(): void
    {
        $response = $this->actingAs($this->counselorUser)
            ->get(route('counselor.settings'));

        $response->assertRedirect(route('counselor.profile.edit'));
    }

    public function test_counselor_can_update_profile_information(): void
    {
        $response = $this->actingAs($this->counselorUser)
            ->put(route('counselor.profile.update'), [
                'nama' => 'Dr. Novia Hendratno, S.Pd., M.Pd.',
                'email' => 'novia.updated@lentera.test',
                'nip' => '198503152010012999',
                'no_hp' => '089876543210',
            ]);

        $response->assertRedirect(route('counselor.profile.edit'));
        $response->assertSessionHas('success');

        $this->counselorUser->refresh();
        $this->konselor->refresh();

        $this->assertEquals('Dr. Novia Hendratno, S.Pd., M.Pd.', $this->counselorUser->nama);
        $this->assertEquals('novia.updated@lentera.test', $this->counselorUser->email);
        $this->assertEquals('198503152010012999', $this->konselor->nip);
        $this->assertEquals('089876543210', $this->konselor->no_hp);
    }

    public function test_counselor_cannot_update_email_to_another_users_email(): void
    {
        User::create([
            'role_id' => Role::ADMIN,
            'nama' => 'Admin Lain',
            'username' => 'admin_lain',
            'email' => 'existing@lentera.test',
            'password' => bcrypt('password'),
            'status' => true,
        ]);

        $response = $this->actingAs($this->counselorUser)
            ->put(route('counselor.profile.update'), [
                'nama' => 'Dra. Novia Hendratno, M.Pd.',
                'email' => 'existing@lentera.test',
                'nip' => '198503152010012021',
                'no_hp' => '081234567890',
            ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_counselor_can_update_username(): void
    {
        $response = $this->actingAs($this->counselorUser)
            ->put(route('counselor.profile.update-username'), [
                'username' => 'novia_konselor_baru',
            ]);

        $response->assertRedirect(route('counselor.profile.edit'));
        $response->assertSessionHas('success');

        $this->counselorUser->refresh();
        $this->assertEquals('novia_konselor_baru', $this->counselorUser->username);
    }

    public function test_counselor_cannot_update_username_to_duplicate(): void
    {
        User::create([
            'role_id' => Role::SISWA,
            'nama' => 'User Lain',
            'username' => 'user_lain',
            'email' => 'userlain@test.com',
            'password' => bcrypt('password'),
            'status' => true,
        ]);

        $response = $this->actingAs($this->counselorUser)
            ->put(route('counselor.profile.update-username'), [
                'username' => 'user_lain',
            ]);

        $response->assertSessionHasErrors('username');
    }

    public function test_counselor_can_update_password(): void
    {
        $response = $this->actingAs($this->counselorUser)
            ->put(route('counselor.profile.update-password'), [
                'current_password' => 'password123',
                'password' => 'newpassword456',
                'password_confirmation' => 'newpassword456',
            ]);

        $response->assertRedirect(route('counselor.profile.edit'));
        $response->assertSessionHas('success');

        $this->counselorUser->refresh();
        $this->assertTrue(Hash::check('newpassword456', $this->counselorUser->password));
    }

    public function test_counselor_cannot_update_password_with_wrong_current_password(): void
    {
        $response = $this->actingAs($this->counselorUser)
            ->put(route('counselor.profile.update-password'), [
                'current_password' => 'salah_password',
                'password' => 'newpassword456',
                'password_confirmation' => 'newpassword456',
            ]);

        $response->assertSessionHasErrors('current_password');
    }
}
