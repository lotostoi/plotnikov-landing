<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\LandingPageContent;
use Illuminate\Database\Seeder;

class LandingContentSeeder extends Seeder
{
    public function run(): void
    {
        LandingPageContent::query()->updateOrCreate(
            ['id' => 1],
            [
                // Контент
                'hero_badge'        => 'Гештальт-терапевт',
                'hero_title'        => 'Здравствуйте, я Александр',
                'hero_description'  => 'Уже 15 лет моя жизнь связана с психологией. Помогаю людям находить опору и контакт с собой через доверие и живое человеческое присутствие.',
                'contact_handle'    => '@AlexanderP_V',
                'telegram_url'      => 'https://t.me/AlexanderP_V',
                'whatsapp_url'      => 'https://wa.me/79242521756',
                'location_text'     => 'Владивосток, Артём',

                // SEO
                'seo_title'         => 'Александр Плотников — психолог, гештальт-терапевт | Владивосток и онлайн',
                'seo_description'   => 'Гештальт-терапевт Александр Плотников — онлайн-консультации по всему миру, очно во Владивостоке и Артёме. 15 лет практики. Первый созвон бесплатно.',
                'seo_keywords'      => 'психолог Владивосток, гештальт-терапевт, психолог онлайн, психолог Артём, консультация психолога, Александр Плотников психолог, гештальт-терапия Владивосток, психотерапия онлайн',
                'canonical_url'     => 'https://plotnikov-al-psy.online',
                'robots'            => 'index,follow',
                'h1_text'           => null,

                // Person / Schema.org
                'person_name'       => 'Александр',
                'person_full_name'  => 'Александр Плотников',
                'person_job_title'  => 'Психолог, гештальт-терапевт',
                'person_bio'        => 'Гештальт-терапевт Александр Плотников. Помогаю находить опору и контакт с собой через доверие и живое человеческое присутствие. 15+ лет в психологии, 12+ лет личной терапии, 10+ лет групповой работы. Работаю онлайн по всему миру и очно во Владивостоке и Артёме.',
                'person_image_url'  => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/IMG_7896_resized-nd2q5Sfs8MaKUDmtG8jYjZkb33cvj6.jpeg',
                'person_phone'      => '+79242521756',
                'person_email'      => null,

                // LocalBusiness / адрес
                'address_locality'  => 'Владивосток',
                'address_region'    => 'Приморский край',
                'address_country'   => 'RU',
                'address_postal'    => '690091',
                'address_street'    => null,
                'geo_lat'           => 43.1155,
                'geo_lng'           => 131.8855,
                'opening_hours'     => 'Mo-Su 09:00-21:00',
                'price_range'       => '₽₽',

                // Цены
                'price_regular'     => 3500,
                'price_promo'       => 2000,
                'price_currency'    => 'RUB',

                // Аналитика (добавить свои ID если нужно)
                'yandex_metrika_id'         => null,
                'google_analytics_id'       => null,
                'google_tag_manager_id'     => null,
                'yandex_verification'       => null,
                'google_site_verification'  => null,
                'bing_site_verification'    => null,

                // Соцсети
                'vk_url'            => null,
                'youtube_url'       => null,
                'instagram_url'     => null,

                // Рейтинг
                'aggregate_rating_value' => 5.0,
                'aggregate_rating_count' => 47,

                // Видимость секций
                'show_header'   => true,
                'show_hero'     => true,
                'show_about'    => true,
                'show_services' => true,
                'show_education'=> true,
                'show_reviews'  => true,
                'show_blog'     => true,
                'show_faq'      => true,
                'show_contacts' => true,
                'show_footer'   => true,

                'default_theme' => 'warm',
            ]
        );
    }
}
