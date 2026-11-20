<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Film extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'original_title',
        'genre',
        'role',
        'released_at',
        'short_description',
        'description',
        'poster_path',
        'accent_color',
    ];

    public function awards(): HasMany
    {
        return $this->hasMany(Award::class)->orderBy('award_year');
    }


    protected function title(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => trim(preg_replace('/\s+/u', ' ', (string) $value)),
        );
    }

    protected function releasedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Carbon::parse($value) : null,
            set: fn ($value) => $value ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    protected function releaseYear(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => Carbon::parse($attributes['released_at'])->year,
        );
    }

    protected function posterUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => asset('storage/' . $attributes['poster_path']),
        );
    }

    protected function accentTextColor(): Attribute
    {
        return Attribute::make(
            get: function ($value, array $attributes) {
                $hex = ltrim($attributes['accent_color'] ?? '#3b4cca', '#');
                [$r, $g, $b] = array_map('hexdec', str_split($hex, 2));
                $luma = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;

                return $luma > 0.6 ? '#212529' : '#ffffff';
            },
        );
    }
}
