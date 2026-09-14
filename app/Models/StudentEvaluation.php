<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'student_id',
    'module_id',
    'lkpd_score',
    'lkpd_note',
    'self_score',
    'self_note',
    'commitment_score',
    'commitment_note',
])]
class StudentEvaluation extends Model
{
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Get LKPD Category and Code
     */
    public function getLkpdDetails(): array
    {
        $score = $this->lkpd_score;
        if ($score === null) return ['category' => '-', 'code' => 0];

        if ($score >= 16) return ['category' => 'Berkembang Sangat Baik', 'code' => 4, 'simple' => 'sangat baik'];
        if ($score >= 11) return ['category' => 'Berkembang Baik', 'code' => 3, 'simple' => 'baik'];
        if ($score >= 6) return ['category' => 'Mulai Berkembang', 'code' => 2, 'simple' => 'cukup'];
        return ['category' => 'Memerlukan Pendampingan', 'code' => 1, 'simple' => 'kurang'];
    }

    /**
     * Get Penilaian Diri Category and Code
     */
    public function getSelfDetails(): array
    {
        $score = $this->self_score;
        if ($score === null) return ['category' => '-', 'code' => 0];

        if ($score >= 17) return ['category' => 'Berkembang Sangat Baik', 'code' => 4, 'simple' => 'sangat baik'];
        if ($score >= 13) return ['category' => 'Berkembang Baik', 'code' => 3, 'simple' => 'baik'];
        if ($score >= 9) return ['category' => 'Mulai Berkembang', 'code' => 2, 'simple' => 'cukup'];
        return ['category' => 'Memerlukan Pendampingan', 'code' => 1, 'simple' => 'kurang'];
    }

    /**
     * Get Lembar Komitmen Category and Code
     */
    public function getCommitmentDetails(): array
    {
        $score = $this->commitment_score;
        if ($score === null) return ['category' => '-', 'code' => 0];

        if ($score >= 5) return ['category' => 'Berkembang Sangat Baik', 'code' => 4, 'simple' => 'sangat baik'];
        if ($score >= 3) return ['category' => 'Berkembang Baik', 'code' => 3, 'simple' => 'baik'];
        if ($score == 2) return ['category' => 'Mulai Berkembang', 'code' => 2, 'simple' => 'cukup'];
        return ['category' => 'Memerlukan Pendampingan', 'code' => 1, 'simple' => 'kurang'];
    }

    /**
     * Get Topic Overall Progress Details
     */
    public function getOverallDetails(): array
    {
        $lkpd = $this->getLkpdDetails();
        $self = $this->getSelfDetails();
        $commit = $this->getCommitmentDetails();

        if ($lkpd['code'] == 0 || $self['code'] == 0 || $commit['code'] == 0) {
            return [
                'average_code' => 0,
                'category' => 'Belum Lengkap',
                'message' => 'Lengkapi semua nilai untuk melihat ringkasan.',
                'color' => 'slate'
            ];
        }

        $avg = round(($lkpd['code'] + $self['code'] + $commit['code']) / 3, 2);

        if ($avg >= 3.26) {
            return [
                'average_code' => $avg,
                'category' => 'Berkembang Sangat Baik',
                'message' => 'Pertahankan konsistensi dan berikan penguatan agar peserta terus berkembang.',
                'color' => 'emerald'
            ];
        }
        if ($avg >= 2.51) {
            return [
                'average_code' => $avg,
                'category' => 'Berkembang Baik',
                'message' => 'Siswa telah menunjukkan empati yang baik. Berikan motivasi tambahan.',
                'color' => 'blue'
            ];
        }
        if ($avg >= 1.76) {
            return [
                'average_code' => $avg,
                'category' => 'Mulai Berkembang',
                'message' => 'Siswa mulai menunjukkan kepedulian. Terus bimbing dan evaluasi secara berkala.',
                'color' => 'amber'
            ];
        }

        return [
            'average_code' => $avg,
            'category' => 'Memerlukan Pendampingan',
            'message' => 'Siswa memerlukan intervensi khusus dan pendampingan personal lebih lanjut.',
            'color' => 'rose'
        ];
    }
}
