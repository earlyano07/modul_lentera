<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['module_id', 'judul', 'deskripsi', 'jenis', 'max_skor', 'catatan', 'urutan'])]
class Assessment extends Model
{
    public const JENIS_PENILAIAN_DIRI = 'penilaian_diri';
    public const JENIS_REFLEKSI_DIRI = 'refleksi_diri';
    public const JENIS_LEMBAR_KOMITMEN = 'lembar_komitmen';

    // Aliases for compatibility
    public const JENIS_LKPD = 'refleksi_diri';
    public const JENIS_PRE_TEST = 'pre_test';
    public const JENIS_POST_TEST = 'post_test';

    public const JENIS_OPTIONS = [
        self::JENIS_PENILAIAN_DIRI => 'Penilaian Diri',
        self::JENIS_REFLEKSI_DIRI => 'Refleksi Diri',
        self::JENIS_LEMBAR_KOMITMEN => 'Lembar Komitmen',
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('urutan');
    }

    public function studentProgress(): HasMany
    {
        return $this->hasMany(StudentProgress::class);
    }

    public function getTotalScore(): int
    {
        return $this->questions()->sum('score');
    }
}
