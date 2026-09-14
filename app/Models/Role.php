<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama'])]
class Role extends Model
{
    public const ADMIN = 1;
    public const KONSELOR = 2;
    public const SISWA = 3;

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
