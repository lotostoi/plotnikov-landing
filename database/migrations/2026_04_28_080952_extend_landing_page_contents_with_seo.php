<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landing_page_contents', function (Blueprint $table): void {
            // SEO basics
            $table->string('canonical_url')->nullable()->after('seo_keywords');
            $table->string('robots')->default('index,follow')->after('canonical_url');
            $table->string('og_image_path')->nullable()->after('robots');
            $table->string('og_image_url')->nullable()->after('og_image_path');
            $table->string('favicon_path')->nullable()->after('og_image_url');
            $table->string('apple_touch_icon_path')->nullable()->after('favicon_path');
            $table->string('h1_text')->nullable()->after('apple_touch_icon_path');

            // Person (для Schema.org Person + AuthorE-E-A-T)
            $table->string('person_name')->nullable()->after('h1_text');
            $table->string('person_full_name')->nullable()->after('person_name');
            $table->string('person_job_title')->nullable()->after('person_full_name');
            $table->text('person_bio')->nullable()->after('person_job_title');
            $table->string('person_image_url')->nullable()->after('person_bio');
            $table->string('person_phone')->nullable()->after('person_image_url');
            $table->string('person_email')->nullable()->after('person_phone');

            // LocalBusiness / адрес
            $table->string('address_locality')->nullable()->after('person_email');
            $table->string('address_region')->nullable()->after('address_locality');
            $table->string('address_country')->default('RU')->after('address_region');
            $table->string('address_postal')->nullable()->after('address_country');
            $table->string('address_street')->nullable()->after('address_postal');
            $table->decimal('geo_lat', 10, 7)->nullable()->after('address_street');
            $table->decimal('geo_lng', 10, 7)->nullable()->after('geo_lat');
            $table->string('opening_hours')->nullable()->after('geo_lng'); // например "Mo-Fr 09:00-21:00"
            $table->string('price_range')->default('₽₽')->after('opening_hours');

            // Цены / Offers
            $table->unsignedInteger('price_regular')->nullable()->after('price_range');
            $table->unsignedInteger('price_promo')->nullable()->after('price_regular');
            $table->string('price_currency')->default('RUB')->after('price_promo');

            // Аналитика и Webmaster
            $table->string('yandex_metrika_id')->nullable()->after('price_currency');
            $table->string('google_analytics_id')->nullable()->after('yandex_metrika_id');
            $table->string('google_tag_manager_id')->nullable()->after('google_analytics_id');
            $table->string('yandex_verification')->nullable()->after('google_tag_manager_id');
            $table->string('google_site_verification')->nullable()->after('yandex_verification');
            $table->string('bing_site_verification')->nullable()->after('google_site_verification');

            // Соцсети дополнительно
            $table->string('vk_url')->nullable()->after('bing_site_verification');
            $table->string('youtube_url')->nullable()->after('vk_url');
            $table->string('instagram_url')->nullable()->after('youtube_url');

            // Aggregate Rating (можно править в админке)
            $table->decimal('aggregate_rating_value', 3, 2)->nullable()->after('instagram_url');
            $table->unsignedInteger('aggregate_rating_count')->nullable()->after('aggregate_rating_value');
        });
    }

    public function down(): void
    {
        Schema::table('landing_page_contents', function (Blueprint $table): void {
            $table->dropColumn([
                'canonical_url', 'robots', 'og_image_path', 'og_image_url', 'favicon_path',
                'apple_touch_icon_path', 'h1_text',
                'person_name', 'person_full_name', 'person_job_title', 'person_bio',
                'person_image_url', 'person_phone', 'person_email',
                'address_locality', 'address_region', 'address_country', 'address_postal',
                'address_street', 'geo_lat', 'geo_lng', 'opening_hours', 'price_range',
                'price_regular', 'price_promo', 'price_currency',
                'yandex_metrika_id', 'google_analytics_id', 'google_tag_manager_id',
                'yandex_verification', 'google_site_verification', 'bing_site_verification',
                'vk_url', 'youtube_url', 'instagram_url',
                'aggregate_rating_value', 'aggregate_rating_count',
            ]);
        });
    }
};
