<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LandingBlock extends Model
{
    protected $fillable = [
        'section_code',
        'block_key',
        'block_type',
        'label',
        'badge',
        'title',
        'subtitle',
        'body',
        'button_text',
        'button_url',
        'sort_order',
        'is_visible',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
        'is_visible' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeSection(Builder $query, string $sectionCode): Builder
    {
        return $query->where('section_code', $sectionCode);
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_visible', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
