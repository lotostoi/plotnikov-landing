<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\LandingBlock;
use App\Models\LandingPageContent;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;

class BlogController extends Controller
{
    public function index(): View
    {
        $faviconUrl = LandingPageContent::query()->first()?->faviconResolvedUrl();

        if (! Schema::hasTable('articles')) {
            $articles = new LengthAwarePaginator([], 0, 9, 1, [
                'path' => request()->url(),
                'query' => request()->query(),
            ]);

            return view('blog.index', compact('articles', 'faviconUrl'));
        }

        $articles = Article::published()
            ->latest('published_at')
            ->paginate(9);

        return view('blog.index', compact('articles', 'faviconUrl'));
    }

    public function show(string $slug): View|Response
    {
        if (! Schema::hasTable('articles')) {
            abort(404);
        }

        $article = Article::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Article::published()
            ->where('id', '!=', $article->id)
            ->when($article->category, fn ($q) => $q->where('category', $article->category))
            ->latest('published_at')
            ->limit(3)
            ->get();

        $contacts = LandingPageContent::query()->first();

        $ctaMax = LandingBlock::where('section_code', 'contacts')
            ->where('block_key', 'cta_max')
            ->first();

        $maxUrl  = $ctaMax?->button_url  ?: 'https://max.ru/u/f9LHodD0cOIZh45J-Dg2owlXzPWe-IUg2R7DDGo-yx1QdDAdLYK1SUWEHxM';
        $maxText = $ctaMax?->button_text ?: 'MAX';

        $ctaTelegramChannel = LandingBlock::where('section_code', 'contacts')
            ->where('block_key', 'telegram_channel')
            ->first();

        $channelUrl = $ctaTelegramChannel?->button_url ?: 'https://t.me/plotnikov_aleksander';

        $faviconUrl = $contacts?->faviconResolvedUrl();

        return view('blog.show', compact('article', 'related', 'contacts', 'maxUrl', 'maxText', 'channelUrl', 'faviconUrl'));
    }
}
