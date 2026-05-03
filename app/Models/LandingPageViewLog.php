<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LandingPageViewLog extends Model
{
    protected $fillable = [
        'landing_page_content_id',
        'page',
        'viewed_at',
        'ip',
        'user_agent',
        'device',
        'referrer',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
    ];

    protected function casts(): array
    {
        return [
            'viewed_at' => 'datetime',
        ];
    }

    public function content(): BelongsTo
    {
        return $this->belongsTo(LandingPageContent::class, 'landing_page_content_id');
    }

    /**
     * Определяет тип устройства по строке User-Agent.
     * Возвращает: desktop | mobile | tablet | bot
     */
    public static function detectDevice(string $ua): string
    {
        if ($ua === '') {
            return 'desktop';
        }

        if (preg_match('/bot|crawl|spider|slurp|facebookexternalhit|yandexbot|bingbot|googlebot/i', $ua)) {
            return 'bot';
        }

        if (preg_match('/ipad|tablet|kindle|silk|playbook|nexus\s?(?:7|9|10)/i', $ua)) {
            return 'tablet';
        }

        if (preg_match('/mobile|android|iphone|ipod|blackberry|windows phone|opera mini|iemobile/i', $ua)) {
            return 'mobile';
        }

        return 'desktop';
    }

    /** Возвращает emoji-иконку типа устройства. */
    public static function deviceIcon(string $device): string
    {
        return match ($device) {
            'mobile'  => '📱',
            'tablet'  => '💻',
            'bot'     => '🤖',
            default   => '🖥',
        };
    }
}
