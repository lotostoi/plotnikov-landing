<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class LandingPageContent extends Model
{
    protected $fillable = [
        // Контент
        'hero_badge',
        'hero_title',
        'hero_description',
        'contact_handle',
        'telegram_url',
        'whatsapp_url',
        'location_text',

        // SEO meta
        'seo_title',
        'seo_description',
        'seo_keywords',
        'canonical_url',
        'robots',
        'og_image_path',
        'og_image_url',
        'favicon_path',
        'apple_touch_icon_path',
        'h1_text',

        // Person
        'person_name',
        'person_full_name',
        'person_job_title',
        'person_bio',
        'person_image_url',
        'person_phone',
        'person_email',

        // Address / LocalBusiness
        'address_locality',
        'address_region',
        'address_country',
        'address_postal',
        'address_street',
        'geo_lat',
        'geo_lng',
        'opening_hours',
        'price_range',

        // Pricing
        'price_regular',
        'price_promo',
        'price_currency',

        // Аналитика и Webmaster
        'yandex_metrika_id',
        'google_analytics_id',
        'google_tag_manager_id',
        'yandex_verification',
        'google_site_verification',
        'bing_site_verification',

        // Соцсети дополнительно
        'vk_url',
        'youtube_url',
        'instagram_url',

        // Aggregate rating
        'aggregate_rating_value',
        'aggregate_rating_count',

        // Section visibility
        'show_header',
        'show_hero',
        'show_about',
        'show_services',
        'show_education',
        'show_reviews',
        'show_blog',
        'show_faq',
        'show_contacts',
        'show_footer',
    ];

    protected $casts = [
        'geo_lat' => 'float',
        'geo_lng' => 'float',
        'price_regular' => 'integer',
        'price_promo' => 'integer',
        'aggregate_rating_value' => 'float',
        'aggregate_rating_count' => 'integer',
        'show_header' => 'boolean',
        'show_hero' => 'boolean',
        'show_about' => 'boolean',
        'show_services' => 'boolean',
        'show_education' => 'boolean',
        'show_reviews' => 'boolean',
        'show_blog' => 'boolean',
        'show_faq' => 'boolean',
        'show_contacts' => 'boolean',
        'show_footer' => 'boolean',
    ];

    public function blocks()
    {
        return LandingBlock::query();
    }

    public function ogImageResolvedUrl(?string $fallback = null): ?string
    {
        if (! empty($this->og_image_url)) {
            return $this->og_image_url;
        }

        if (! empty($this->og_image_path)) {
            return Storage::disk('public')->url($this->og_image_path);
        }

        return $fallback;
    }

    public function faviconResolvedUrl(): ?string
    {
        return ! empty($this->favicon_path)
            ? Storage::disk('public')->url($this->favicon_path)
            : null;
    }

    public function appleTouchIconResolvedUrl(): ?string
    {
        return ! empty($this->apple_touch_icon_path)
            ? Storage::disk('public')->url($this->apple_touch_icon_path)
            : null;
    }
}
