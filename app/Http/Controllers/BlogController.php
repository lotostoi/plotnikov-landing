<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;

class BlogController extends Controller
{
    public function index(): View
    {
        if (! Schema::hasTable('articles')) {
            $articles = new LengthAwarePaginator([], 0, 9, 1, [
                'path' => request()->url(),
                'query' => request()->query(),
            ]);

            return view('blog.index', compact('articles'));
        }

        $articles = Article::published()
            ->latest('published_at')
            ->paginate(9);

        return view('blog.index', compact('articles'));
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

        return view('blog.show', compact('article', 'related'));
    }
}
