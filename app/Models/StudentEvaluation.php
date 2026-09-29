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
    'notes',
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
     * Get unified counselor note for this topic
     */
    public function getCounselorNoteAttribute(): ?string
    {
        return $this->notes ?: ($this->lkpd_note ?: ($this->self_note ?: $this->commitment_note));
    }

    /**
     * Get Refleksi Diri (formerly LKPD) Category and Code
     */
    public function getRefleksiDetails(): array
    {
        return $this->getLkpdDetails();
    }

    public function getRefleksiScoreAttribute(): ?int
    {
        return $this->lkpd_score;
    }

    public function setRefleksiScoreAttribute($value): void
    {
        $this->attributes['lkpd_score'] = $value;
    }

    /**
     * Convert percentage into standard category, meaning, code, and color.
     * Persentase:
     * 85 - 100% : Sangat Baik (Capaian sangat baik dan dapat dipertahankan)
     * 75 - 84%  : Baik (Capaian baik, dengan penguatan pada aspek tertentu)
     * 65 - 74%  : Cukup (Memerlukan penguatan dan pendampingan)
     * 55 - 64%  : Kurang (Memerlukan pembinaan lebih lanjut)
     * < 55%     : Sangat Kurang (Memerlukan pembinaan dan pendampingan lebih intensif)
     */
    public static function getCategoryFromPercentage(float $percentage): array
    {
        $pct = round($percentage, 1);
        if ($pct >= 85) {
            return [
                'category' => 'Sangat Baik',
                'meaning' => 'Capaian sangat baik dan dapat dipertahankan',
                'code' => 5,
                'color' => 'emerald',
                'badge' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                'percentage' => $pct,
                'deskripsi' => 'Peserta didik yang memperoleh hasil dalam kategori Sangat Baik menunjukkan capaian yang baik dalam memahami materi, melakukan refleksi, dan membangun komitmen perilaku positif.',
                'tindak_lanjut' => [
                    'Memberikan penguatan positif',
                    'Mempertahankan perilaku yang sudah berkembang',
                    'Memberikan kesempatan untuk menjadi contoh perilaku positif bagi teman',
                    'Mendorong peserta didik untuk menerapkan nilai empati dalam kehidupan sehari-hari',
                ],
                'catatan_penting' => null,
            ];
        }
        if ($pct >= 75) {
            return [
                'category' => 'Baik',
                'meaning' => 'Capaian baik, dengan penguatan pada aspek tertentu',
                'code' => 4,
                'color' => 'blue',
                'badge' => 'bg-blue-100 text-blue-800 border-blue-200',
                'percentage' => $pct,
                'deskripsi' => 'Peserta didik dalam kategori Baik telah menunjukkan capaian yang memadai, tetapi masih terdapat aspek yang dapat dikembangkan.',
                'tindak_lanjut' => [
                    'Memberikan penguatan pada aspek yang belum optimal',
                    'Mendorong penerapan keterampilan empati dalam situasi nyata',
                    'Melakukan pemantauan perkembangan pada kegiatan berikutnya',
                    'Memberikan umpan balik secara positif dan konstruktif',
                ],
                'catatan_penting' => null,
            ];
        }
        if ($pct >= 65) {
            return [
                'category' => 'Cukup',
                'meaning' => 'Memerlukan penguatan dan pendampingan',
                'code' => 3,
                'color' => 'amber',
                'badge' => 'bg-amber-100 text-amber-800 border-amber-200',
                'percentage' => $pct,
                'deskripsi' => 'Peserta didik dalam kategori Cukup memerlukan penguatan agar pemahaman dan keterampilan yang diperoleh dapat diterapkan secara lebih konsisten.',
                'tindak_lanjut' => [
                    'Memberikan penguatan atau pengulangan materi tertentu',
                    'Mengajak peserta didik melakukan refleksi kembali',
                    'Memberikan contoh situasi yang lebih dekat dengan kehidupan peserta didik',
                    'Melakukan pendampingan secara individual atau kelompok kecil apabila diperlukan',
                    'Memantau perkembangan peserta didik pada kegiatan berikutnya',
                ],
                'catatan_penting' => null,
            ];
        }
        if ($pct >= 55) {
            return [
                'category' => 'Kurang',
                'meaning' => 'Memerlukan pembinaan lebih lanjut',
                'code' => 2,
                'color' => 'orange',
                'badge' => 'bg-orange-100 text-orange-800 border-orange-200',
                'percentage' => $pct,
                'deskripsi' => 'Peserta didik dalam kategori Kurang memerlukan pembinaan lebih lanjut. Konselor perlu mengidentifikasi aspek yang menyebabkan capaian peserta didik belum optimal.',
                'tindak_lanjut' => [
                    'Melakukan pembinaan secara terarah',
                    'Memberikan pengulangan atau penguatan pada materi yang belum dipahami',
                    'Melakukan refleksi dan diskusi individual',
                    'Memberikan latihan tambahan yang sesuai dengan kebutuhan peserta didik',
                    'Melakukan pemantauan secara berkala',
                    'Memberikan layanan konseling individual atau kelompok apabila hasil asesmen menunjukkan kebutuhan tersebut',
                ],
                'catatan_penting' => 'Hasil kategori "Kurang" bukan berarti peserta didik adalah pelaku atau korban perundungan. Hasil tersebut menunjukkan bahwa peserta didik membutuhkan penguatan atau pendampingan dalam proses layanan LENTERA.',
            ];
        }
        return [
            'category' => 'Sangat Kurang',
            'meaning' => 'Memerlukan pembinaan dan pendampingan lebih intensif',
            'code' => 1,
            'color' => 'rose',
            'badge' => 'bg-rose-100 text-rose-800 border-rose-200',
            'percentage' => $pct,
            'deskripsi' => 'Peserta didik dalam kategori Sangat Kurang memerlukan pendampingan lebih intensif. Konselor tidak langsung menyimpulkan bahwa peserta didik memiliki masalah perilaku, tetapi perlu melakukan identifikasi lebih lanjut terhadap kondisi dan kebutuhan peserta didik.',
            'tindak_lanjut' => [
                'Melakukan pembinaan dan pendampingan secara lebih intensif',
                'Melakukan asesmen atau identifikasi kebutuhan lebih lanjut',
                'Memberikan layanan konseling individual/kelompok sesuai kebutuhan',
                'Melakukan koordinasi dengan pihak terkait sesuai prinsip kerahasiaan dan kebutuhan peserta didik',
                'Melakukan monitoring perkembangan secara berkala',
            ],
            'catatan_penting' => 'Hasil kategori "Sangat Kurang" bukan berarti peserta didik adalah pelaku atau korban perundungan. Hasil tersebut menunjukkan bahwa peserta didik membutuhkan penguatan atau pendampingan dalam proses layanan LENTERA.',
        ];
    }

    public static function getAllTindakLanjutGuidelines(): array
    {
        return [
            [
                'range' => '85 – 100%',
                'category' => 'Sangat Baik',
                'meaning' => 'Capaian sangat baik dan dapat dipertahankan',
                'badge' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                'deskripsi' => 'Peserta didik yang memperoleh hasil dalam kategori Sangat Baik menunjukkan capaian yang baik dalam memahami materi, melakukan refleksi, dan membangun komitmen perilaku positif.',
                'tindak_lanjut' => [
                    'Memberikan penguatan positif;',
                    'Mempertahankan perilaku yang sudah berkembang;',
                    'Memberikan kesempatan untuk menjadi contoh perilaku positif bagi teman;',
                    'Mendorong peserta didik untuk menerapkan nilai empati dalam kehidupan sehari-hari.',
                ],
                'catatan_penting' => null,
            ],
            [
                'range' => '75 – 84%',
                'category' => 'Baik',
                'meaning' => 'Capaian baik, dengan penguatan pada aspek tertentu',
                'badge' => 'bg-blue-100 text-blue-800 border-blue-200',
                'deskripsi' => 'Peserta didik dalam kategori Baik telah menunjukkan capaian yang memadai, tetapi masih terdapat aspek yang dapat dikembangkan.',
                'tindak_lanjut' => [
                    'Memberikan penguatan pada aspek yang belum optimal;',
                    'Mendorong penerapan keterampilan empati dalam situasi nyata;',
                    'Melakukan pemantauan perkembangan pada kegiatan berikutnya;',
                    'Memberikan umpan balik secara positif dan konstruktif.',
                ],
                'catatan_penting' => null,
            ],
            [
                'range' => '65 – 74%',
                'category' => 'Cukup',
                'meaning' => 'Memerlukan penguatan dan pendampingan',
                'badge' => 'bg-amber-100 text-amber-800 border-amber-200',
                'deskripsi' => 'Peserta didik dalam kategori Cukup memerlukan penguatan agar pemahaman dan keterampilan yang diperoleh dapat diterapkan secara lebih konsisten.',
                'tindak_lanjut' => [
                    'Memberikan penguatan atau pengulangan materi tertentu;',
                    'Mengajak peserta didik melakukan refleksi kembali;',
                    'Memberikan contoh situasi yang lebih dekat dengan kehidupan peserta didik;',
                    'Melakukan pendampingan secara individual atau kelompok kecil apabila diperlukan;',
                    'Memantau perkembangan peserta didik pada kegiatan berikutnya.',
                ],
                'catatan_penting' => null,
            ],
            [
                'range' => '55 – 64%',
                'category' => 'Kurang',
                'meaning' => 'Memerlukan pembinaan lebih lanjut',
                'badge' => 'bg-orange-100 text-orange-800 border-orange-200',
                'deskripsi' => 'Peserta didik dalam kategori Kurang memerlukan pembinaan lebih lanjut. Konselor perlu mengidentifikasi aspek yang menyebabkan capaian peserta didik belum optimal.',
                'tindak_lanjut' => [
                    'Melakukan pembinaan secara terarah;',
                    'Memberikan pengulangan atau penguatan pada materi yang belum dipahami;',
                    'Melakukan refleksi dan diskusi individual;',
                    'Memberikan latihan tambahan yang sesuai dengan kebutuhan peserta didik;',
                    'Melakukan pemantauan secara berkala;',
                    'Memberikan layanan konseling individual atau kelompok apabila hasil asesmen menunjukkan kebutuhan tersebut.',
                ],
                'catatan_penting' => 'Hasil kategori "Kurang" bukan berarti peserta didik adalah pelaku atau korban perundungan. Hasil tersebut menunjukkan bahwa peserta didik membutuhkan penguatan atau pendampingan dalam proses layanan LENTERA.',
            ],
            [
                'range' => '< 55%',
                'category' => 'Sangat Kurang',
                'meaning' => 'Memerlukan pembinaan dan pendampingan lebih intensif',
                'badge' => 'bg-rose-100 text-rose-800 border-rose-200',
                'deskripsi' => 'Peserta didik dalam kategori Sangat Kurang memerlukan pendampingan lebih intensif. Konselor tidak langsung menyimpulkan bahwa peserta didik memiliki masalah perilaku, tetapi perlu melakukan identifikasi lebih lanjut terhadap kondisi dan kebutuhan peserta didik.',
                'tindak_lanjut' => [
                    'Melakukan pembinaan dan pendampingan secara lebih intensif;',
                    'Melakukan asesmen atau identifikasi kebutuhan lebih lanjut;',
                    'Memberikan layanan konseling individual/kelompok sesuai kebutuhan;',
                    'Melakukan koordinasi dengan pihak terkait sesuai prinsip kerahasiaan dan kebutuhan peserta didik;',
                    'Melakukan monitoring perkembangan secara berkala.',
                ],
                'catatan_penting' => 'Hasil kategori "Sangat Kurang" bukan berarti peserta didik adalah pelaku atau korban perundungan. Hasil tersebut menunjukkan bahwa peserta didik membutuhkan penguatan atau pendampingan dalam proses layanan LENTERA.',
            ],
        ];
    }

    public function getMaxScoreForAssessmentType(string $type, int $fallback = 20): int
    {
        if (!$this->relationLoaded('module')) {
            $this->loadMissing('module.assessments.questions.options');
        }

        $assessment = $this->module?->assessments->first(function ($a) use ($type) {
            if ($type === 'self') {
                return $a->jenis === 'penilaian_diri' || str_contains(strtolower($a->judul), 'penilaian diri') || str_contains(strtolower($a->judul), 'self');
            } elseif ($type === 'refleksi' || $type === 'lkpd') {
                return $a->jenis === 'refleksi_diri' || $a->jenis === 'lkpd' || str_contains(strtolower($a->judul), 'refleksi') || str_contains(strtolower($a->judul), 'lkpd');
            } elseif ($type === 'commitment') {
                return $a->jenis === 'lembar_komitmen' || str_contains(strtolower($a->judul), 'komitmen') || str_contains(strtolower($a->judul), 'commitment');
            }
            return false;
        });

        if (!$assessment || $assessment->questions->isEmpty()) {
            return $fallback;
        }

        $totalMax = 0;
        foreach ($assessment->questions as $question) {
            $maxOpt = $question->options->max('score');
            if ($maxOpt !== null && $maxOpt > 0) {
                $totalMax += $maxOpt;
            } elseif ($question->score > 0) {
                $totalMax += $question->score;
            } else {
                $totalMax += ($question->tipe === 'essay' ? 10 : 1);
            }
        }

        return $totalMax > 0 ? (int)$totalMax : $fallback;
    }

    /**
     * Get Refleksi Diri (LKPD) Category and Details
     */
    public function getLkpdDetails(): array
    {
        $score = $this->lkpd_score;
        if ($score === null) {
            return [
                'category' => '-',
                'meaning' => '-',
                'code' => 0,
                'percentage' => 0,
                'color' => 'slate',
                'badge' => 'bg-slate-50 text-slate-700 border-slate-200',
            ];
        }

        $max = $this->getMaxScoreForAssessmentType('refleksi', 16);
        $pct = min(100, max(0, round(($score / $max) * 100, 1)));
        $details = self::getCategoryFromPercentage($pct);
        $details['percentage'] = $pct;
        return $details;
    }

    /**
     * Get Penilaian Diri Category and Details
     */
    public function getSelfDetails(): array
    {
        $score = $this->self_score;
        if ($score === null) {
            return [
                'category' => '-',
                'meaning' => '-',
                'code' => 0,
                'percentage' => 0,
                'color' => 'slate',
                'badge' => 'bg-slate-50 text-slate-700 border-slate-200',
            ];
        }

        $max = $this->getMaxScoreForAssessmentType('self', 24);
        $pct = min(100, max(0, round(($score / $max) * 100, 1)));
        $details = self::getCategoryFromPercentage($pct);
        $details['percentage'] = $pct;
        return $details;
    }

    /**
     * Get Lembar Komitmen Category and Details
     */
    public function getCommitmentDetails(): array
    {
        $score = $this->commitment_score;
        if ($score === null) {
            return [
                'category' => '-',
                'meaning' => '-',
                'code' => 0,
                'percentage' => 0,
                'color' => 'slate',
                'badge' => 'bg-slate-50 text-slate-700 border-slate-200',
            ];
        }

        $max = $this->getMaxScoreForAssessmentType('commitment', 6);
        $pct = min(100, max(0, round(($score / $max) * 100, 1)));
        $details = self::getCategoryFromPercentage($pct);
        $details['percentage'] = $pct;
        return $details;
    }

    /**
     * Get Topic Overall Progress Details
     */
    public function getOverallDetails(): array
    {
        $lkpd = $this->getLkpdDetails();
        $self = $this->getSelfDetails();
        $commit = $this->getCommitmentDetails();

        $maxSelf = $this->getMaxScoreForAssessmentType('self', 24);
        $maxRefleksi = $this->getMaxScoreForAssessmentType('refleksi', 16);
        $maxCommit = $this->getMaxScoreForAssessmentType('commitment', 6);
        $totalMax = $maxSelf + $maxRefleksi + $maxCommit;
        $totalScore = ($this->self_score ?? 0) + ($this->lkpd_score ?? 0) + ($this->commitment_score ?? 0);

        if ($this->lkpd_score === null || $this->self_score === null || $this->commitment_score === null) {
            return [
                'average_code' => 0,
                'percentage' => 0,
                'total_score' => $totalScore,
                'total_max' => $totalMax,
                'category' => 'Belum Lengkap',
                'meaning' => 'Lengkapi semua nilai asesmen untuk melihat kategori capaian topik.',
                'message' => 'Lengkapi semua nilai asesmen untuk melihat kategori capaian topik.',
                'color' => 'slate',
                'badge' => 'bg-slate-100 text-slate-600 border-slate-200',
            ];
        }

        $avgPct = round(($lkpd['percentage'] + $self['percentage'] + $commit['percentage']) / 3, 1);
        $catInfo = self::getCategoryFromPercentage($avgPct);

        return [
            'average_code' => $avgPct,
            'percentage' => $avgPct,
            'total_score' => $totalScore,
            'total_max' => $totalMax,
            'category' => $catInfo['category'],
            'meaning' => $catInfo['meaning'],
            'message' => $catInfo['meaning'], // compatibility alias
            'deskripsi' => $catInfo['deskripsi'] ?? '',
            'tindak_lanjut' => $catInfo['tindak_lanjut'] ?? [],
            'catatan_penting' => $catInfo['catatan_penting'] ?? null,
            'color' => $catInfo['color'],
            'badge' => $catInfo['badge'],
        ];
    }
}
