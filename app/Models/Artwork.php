<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Artwork extends Model
{
    protected $fillable = [
        'title',
        'description_fr',
        'description_en',
        'description_wo',
        'artist',
        'creation_year',
        'medium',
        'dimensions',
        'image_path',
        'audio_path_fr',
        'audio_path_en',
        'audio_path_wo',
        'video_path',
        'qr_code',
        'historical_context',
        'cultural_significance',
        'category_id',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'historical_context' => 'array',
        'cultural_significance' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getDescriptionAttribute(): string
    {
        $locale = app()->getLocale();
        return match($locale) {
            'en' => $this->description_en ?? $this->description_fr,
            'wo' => $this->description_wo ?? $this->description_fr,
            default => $this->description_fr,
        };
    }

    public function getAudioPathAttribute(): ?string
    {
        $locale = app()->getLocale();
        return match($locale) {
            'en' => $this->audio_path_en,
            'wo' => $this->audio_path_wo,
            default => $this->audio_path_fr,
        };
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
