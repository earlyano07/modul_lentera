<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'student_id',
    'module_id',
    'assessment_id',
    'status',
    'nilai',
    'answers',
    'started_at',
    'finished_at',
])]
class StudentProgress extends Model
{
    protected $table = 'student_progress';

    protected function casts(): array
    {
        return [
            'nilai' => 'decimal:2',
            'answers' => 'array',
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    public function isCompleted(): bool
    {
        return $this->status === 'selesai';
    }

    public function isInProgress(): bool
    {
        return $this->status === 'sedang_mengerjakan';
    }
}
