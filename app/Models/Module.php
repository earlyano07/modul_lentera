<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['judul', 'subtitle', 'deskripsi', 'fokus_utama', 'ilustrasi', 'urutan', 'status', 'guide_modeling', 'guide_role_playing', 'guide_feedback', 'guide_transfer'])]
class Module extends Model
{
    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    public function materials(): HasMany
    {
        return $this->hasMany(Material::class)->orderBy('urutan');
    }

    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class)->orderBy('urutan');
    }

    public function studentProgress(): HasMany
    {
        return $this->hasMany(StudentProgress::class);
    }

}
