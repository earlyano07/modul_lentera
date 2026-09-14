<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama', 'alamat', 'telepon', 'npsn', 'logo', 'status'])]
class School extends Model
{
    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    public function kelas(): HasMany
    {
        return $this->hasMany(Kelas::class);
    }

    public function konselors(): BelongsToMany
    {
        return $this->belongsToMany(Konselor::class, 'konselor_sekolah')
            ->withTimestamps();
    }
}
