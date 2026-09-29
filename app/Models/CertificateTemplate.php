<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'title',
    'sub_title',
    'caption',
    'body_text',
    'topics_list',
    'signer_title',
    'signer_mode',
    'default_signer_name',
    'default_signer_nip',
    'cert_number_prefix',
    'cert_number_format',
    'date_type',
    'fixed_date',
    'recap_title',
    'disclaimer',
    'commitment_title',
    'commitment_intro',
    'commitment_points',
    'commitment_personal_prompt',
    'commitment_personal_subprompt',
    'logo_path',
    'docx_template_path',
    'is_active',
])]
class CertificateTemplate extends Model
{
    protected function casts(): array
    {
        return [
            'topics_list' => 'array',
            'commitment_points' => 'array',
            'is_active' => 'boolean',
            'fixed_date' => 'date',
        ];
    }

    public static function getDefaultAttributes(): array
    {
        return [
            'title' => 'SERTIFIKAT',
            'sub_title' => 'PENYELESAIAN LAYANAN MODEL LENTERA',
            'caption' => 'Latihan Empati Terstruktur untuk Atasi Perundungan',
            'body_text' => 'atas partisipasi dan penyelesaian rangkaian layanan Model LENTERA dalam mengembangkan empati dan perilaku positif untuk menciptakan lingkungan pertemanan yang aman, nyaman, dan saling menghargai.',
            'topics_list' => [
                '01 Menyadari Masalah',
                '02 Memahami Emosi',
                '03 Mengambil Perspektif',
                '04 Bertindak Empatik',
                '05 Membudayakan Perilaku Anti-Perundungan',
            ],
            'signer_title' => 'Guru Bimbingan dan Konseling',
            'signer_mode' => 'school_counselor',
            'default_signer_name' => 'Guru Bimbingan dan Konseling',
            'default_signer_nip' => '',
            'cert_number_prefix' => 'LTR',
            'cert_number_format' => 'No: {PREFIX}/{YEAR}/{CLASS}/{ID}',
            'date_type' => 'completion_date',
            'fixed_date' => null,
            'recap_title' => 'REKAP CAPAIAN LAYANAN',
            'disclaimer' => 'Hasil ini merupakan gambaran capaian peserta didik selama mengikuti layanan LENTERA dan bukan merupakan diagnosis psikologis.',
            'commitment_title' => 'KOMITMEN SAYA',
            'commitment_intro' => 'Setelah mengikuti rangkaian LENTERA, saya berkomitmen untuk:',
            'commitment_points' => [
                'menghargai perasaan dan keberadaan orang lain;',
                'tidak ikut melakukan atau menyebarkan perundungan;',
                'berusaha memahami sudut pandang orang lain;',
                'menunjukkan kepedulian ketika melihat teman mengalami kesulitan;',
                'ikut menciptakan lingkungan pertemanan yang aman dan saling menghargai.',
            ],
            'commitment_personal_prompt' => 'Komitmen pribadi saya:',
            'commitment_personal_subprompt' => '“Mulai sekarang, saya akan...”',
            'logo_path' => 'images/certificate/lentera_logo.png',
            'docx_template_path' => null,
            'is_active' => true,
        ];
    }

    public static function getActive(): self
    {
        $template = self::where('is_active', true)->first();
        if (!$template) {
            $template = self::create(self::getDefaultAttributes());
        }
        return $template;
    }
}
