<?php

namespace App\Http\Controllers;

use App\Models\LandingPageContent;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $content = LandingPageContent::query()->first();
        $base = rtrim($content?->canonical_url ?: config('app.url') ?: url('/'), '/');
        $lastmod = ($content?->updated_at ?: now())->toAtomString();

        $sections = [
            ['loc' => $base . '/',         'priority' => '1.0', 'changefreq' => 'weekly'],
            ['loc' => $base . '/#about',   'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => $base . '/#services','priority' => '0.9', 'changefreq' => 'monthly'],
            ['loc' => $base . '/#education','priority' => '0.7', 'changefreq' => 'yearly'],
            ['loc' => $base . '/#reviews', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => $base . '/#blog',    'priority' => '0.6', 'changefreq' => 'monthly'],
            ['loc' => $base . '/#faq',     'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => $base . '/#contacts','priority' => '0.9', 'changefreq' => 'monthly'],
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
        foreach ($sections as $url) {
            $xml .= '  <url>' . PHP_EOL;
            $xml .= '    <loc>' . htmlspecialchars($url['loc'], ENT_QUOTES | ENT_XML1, 'UTF-8') . '</loc>' . PHP_EOL;
            $xml .= '    <lastmod>' . $lastmod . '</lastmod>' . PHP_EOL;
            $xml .= '    <changefreq>' . $url['changefreq'] . '</changefreq>' . PHP_EOL;
            $xml .= '    <priority>' . $url['priority'] . '</priority>' . PHP_EOL;
            $xml .= '  </url>' . PHP_EOL;
        }
        $xml .= '</urlset>' . PHP_EOL;

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    public function robots(): Response
    {
        $content = LandingPageContent::query()->first();
        $base = rtrim($content?->canonical_url ?: config('app.url') ?: url('/'), '/');
        $robots = $content?->robots ?: 'index,follow';
        $disallowAll = str_contains($robots, 'noindex');

        $lines = [];
        $lines[] = 'User-agent: *';
        if ($disallowAll) {
            $lines[] = 'Disallow: /';
        } else {
            $lines[] = 'Allow: /';
            $lines[] = 'Disallow: /admin';
            $lines[] = 'Disallow: /admin/';
            $lines[] = 'Disallow: /storage/framework/';
            $lines[] = 'Disallow: /vendor/';
        }
        $lines[] = '';
        $lines[] = 'Host: ' . preg_replace('#^https?://#', '', $base);
        $lines[] = 'Sitemap: ' . $base . '/sitemap.xml';

        return response(implode("\n", $lines) . "\n", 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
