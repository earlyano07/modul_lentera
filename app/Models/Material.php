<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['module_id', 'judul', 'jenis', 'isi', 'video', 'file_path', 'situasi', 'peran', 'diskusi', 'urutan'])]
class Material extends Model
{
    public const JENIS_VIDEO = 'video';
    public const JENIS_KARTU_SITUASI = 'kartu_situasi';

    public const JENIS_OPTIONS = [
        self::JENIS_VIDEO => 'Video / Ilustrasi Kejadian',
        self::JENIS_KARTU_SITUASI => 'Kartu Situasi',
    ];

    public const JENIS_ICONS = [
        self::JENIS_VIDEO => 'play_circle',
        self::JENIS_KARTU_SITUASI => 'style',
    ];
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Check if video is a YouTube embed URL
     */
    public function isYoutubeVideo(): bool
    {
        if (!$this->video) return false;
        return str_contains($this->video, 'youtube.com') || str_contains($this->video, 'youtu.be');
    }

    /**
     * Get YouTube embed URL from various YouTube URL formats
     */
    public function getYoutubeEmbedUrl(): ?string
    {
        if (!$this->isYoutubeVideo()) return null;

        $videoId = null;
        if (preg_match('/(?:youtube\.com\/(?:watch\?.*v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $this->video, $matches)) {
            $videoId = $matches[1];
        }

        return $videoId ? "https://www.youtube.com/embed/{$videoId}" : null;
    }
}
