<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q          = trim($request->get('q', ''));
        $categorySlug = $request->get('kategori');
        $tagSlug    = $request->get('tag');
        $sort       = $request->get('sort', 'terbaru'); // terbaru | populer | relevan

        $query = Post::with(['category', 'author', 'tags'])
            ->published();

        // ─── Filter pencarian teks ──────────────────────────────
        if ($q !== '') {
            $query->where(function ($q2) use ($q) {
                $q2->where('title', 'like', "%{$q}%")
                   ->orWhere('excerpt', 'like', "%{$q}%")
                   ->orWhere('content', 'like', "%{$q}%");
            });
        }

        // ─── Filter kategori ────────────────────────────────────
        if ($categorySlug) {
            $query->whereHas('category', fn($q2) => $q2->where('slug', $categorySlug));
        }

        // ─── Filter tag ─────────────────────────────────────────
        if ($tagSlug) {
            $query->whereHas('tags', fn($q2) => $q2->where('slug', $tagSlug));
        }

        // ─── Sort ───────────────────────────────────────────────
        match ($sort) {
            'populer'  => $query->orderByDesc('views_count'),
            default    => $query->latest('published_at'),
        };

        $results    = $query->paginate(12)->withQueryString();
        $categories = Category::withCount(['posts' => fn($q) => $q->published()])
            ->having('posts_count', '>', 0)
            ->orderByDesc('posts_count')
            ->get();
        $tags       = Tag::has('posts')->withCount('posts')->orderByDesc('posts_count')->get();

        // Jika tidak ada filter apapun, tampilkan semua artikel (latest)
        // Jangan redirect agar URL /cari tetap bisa diakses
        if ($q === '' && !$categorySlug && !$tagSlug) {
            $query->latest('published_at');
        }


        return view('search.index', compact(
            'q', 'results', 'categories', 'tags',
            'categorySlug', 'tagSlug', 'sort'
        ));
    }
}
