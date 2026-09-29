<?php

namespace Tests\Feature;

use App\Models\Material;
use App\Models\Module;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KartuSituasiTest extends TestCase
{
    use RefreshDatabase;

    protected $counselorUser;
    protected $module;
    protected $kartu;

    protected function setUp(): void
    {
        parent::setUp();

        $this->counselorUser = User::factory()->create([
            'role_id' => Role::KONSELOR,
            'nama' => 'Konselor Test',
        ]);

        $this->module = Module::create([
            'judul' => 'Empathy Awareness',
            'subtitle' => 'kesadaran terhadap bullying',
            'deskripsi' => 'Mengenali dan memahami empati.',
            'fokus_utama' => 'Menyadari dampak bullying.',
            'urutan' => 1,
        ]);

        $this->kartu = Material::create([
            'module_id' => $this->module->id,
            'judul' => 'Diam Bukan Berarti Setuju',
            'jenis' => Material::JENIS_KARTU_SITUASI,
            'situasi' => 'Dimas sering diam saat teman-temannya mengejek seseorang.',
            'peran' => "Dimas (siswa)\nDua teman\nSatu pelaku",
            'diskusi' => "Mengapa Dimas diam?\nApa yang bisa dilakukan Dimas?",
            'urutan' => 1,
        ]);
    }

    public function test_guest_cannot_access_kartu_situasi_print()
    {
        $response = $this->get(route('kartu-situasi.print', $this->module));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_printable_kartu_situasi_module()
    {
        $response = $this->actingAs($this->counselorUser)
            ->get(route('kartu-situasi.print', $this->module));

        $response->assertStatus(200);
        $response->assertSee('Diam Bukan Berarti Setuju');
        $response->assertSee('Dimas sering diam');
        $response->assertSee('Cetak / Simpan PDF');
        $response->assertSee('Unduh Word (.docx)');
    }

    public function test_authenticated_user_can_download_docx_module()
    {
        $response = $this->actingAs($this->counselorUser)
            ->get(route('kartu-situasi.docx', $this->module));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    }

    public function test_authenticated_user_can_view_printable_single_kartu()
    {
        $response = $this->actingAs($this->counselorUser)
            ->get(route('kartu-situasi.print-single', $this->kartu));

        $response->assertStatus(200);
        $response->assertSee('Diam Bukan Berarti Setuju');
    }

    public function test_authenticated_user_can_download_docx_single()
    {
        $response = $this->actingAs($this->counselorUser)
            ->get(route('kartu-situasi.docx-single', $this->kartu));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    }
}
