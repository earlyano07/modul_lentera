<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['module_id', 'judul', 'jenis', 'max_skor', 'urutan'])]
class Assessment extends Model
{
    public const JENIS_PRE_TEST = 'pre_test';
    public const JENIS_POST_TEST = 'post_test';
    public const JENIS_LKPD = 'lkpd';

    public const JENIS_OPTIONS = [
        self::JENIS_PRE_TEST => 'Pre Test',
        self::JENIS_POST_TEST => 'Post Test',
        self::JENIS_LKPD => 'Lembar Kerja Peserta Didik (LKPD)',
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
