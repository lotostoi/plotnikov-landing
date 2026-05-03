<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\LandingPageContent;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;

class SeoController extends Controller
{
    /**
     * @return array{base: string, content: ?LandingPageContent}
     */
    private function siteContext(): array
    {
        $content = Schema::hasTable('landing_page_contents')
            ? LandingPageContent::query()->first()
            : null;

        $raw = $content?->canonical_url ?: config('app.url') ?: url('/');
        $base = rtrim((string) $raw, '/');
        if ($base === '') {
            $base = rtrim((string) url('/'), '/');
        }

        return ['base' => $base, 'content' => $content];
    }

    public function sitemap(): Response
    {
        ['base' => $base, 'content' => $content] = $this->siteContext();
        $homeLastmod = $content?->updated_at ?? now();

        // В <loc> нельзя использовать URL с фрагментом (#) — только реальные пути.
        $clusterPaths = [
            '/psiholog-online',
            '/geshtalt-terapevt',
            '/psiholog-vladivostok',
            '/psiholog-artem',
        ];

        $entries = [
            [
                'loc' => $base . '/',
                'lastmod' => $homeLastmod,
                'changefreq' => 'weekly',
                'priority' => '1.0',
            ],
            [
                'loc' => $base . '/blog',
                'lastmod' => $homeLastmod,
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ],
        ];

        foreach ($clusterPaths as $path) {
            $entries[] = [
                'loc' => $base . $path,
                'lastmod' => $homeLastmod,
                'changefreq' => 'monthly',
                'priority' => '0.9',
            ];
        }

        if (Schema::hasTable('articles')) {
            $articles = Article::published()
                ->orderByDesc('updated_at')
                ->get(['slug', 'updated_at', 'published_at']);

            foreach ($articles as $article) {
                $lastmod = $article->updated_at ?? $article->published_at ?? $homeLastmod;
                $entries[] = [
                    'loc' => $base . '/blog/' . $article->slug,
                    'lastmod' => $lastmod,
                    'changefreq' => 'monthly',
                    'priority' => '0.7',
                ];
            }
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
        foreach ($entries as $row) {
            $lastmodStr = $row['lastmod']->toAtomString();
            $xml .= '  <url>' . PHP_EOL;
            $xml .= '    <loc>' . htmlspecialchars($row['loc'], ENT_QUOTES | ENT_XML1, 'UTF-8') . '</loc>' . PHP_EOL;
            $xml .= '    <lastmod>' . $lastmodStr . '</lastmod>' . PHP_EOL;
            $xml .= '    <changefreq>' . $row['changefreq'] . '</changefreq>' . PHP_EOL;
            $xml .= '    <priority>' . $row['priority'] . '</priority>' . PHP_EOL;
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
        ['base' => $base, 'content' => $content] = $this->siteContext();

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
            $lines[] = 'Disallow: /logs';
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
