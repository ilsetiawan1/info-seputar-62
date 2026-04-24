<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        // Headline: 1 artikel featured terbaru
        $headline = Post::with(['category', 'author'])
            ->published()
            ->featured()
            ->latest('published_at')
            ->first();

        // Hero carousel: 5 artikel featured (termasuk headline)
        $heroSlides = Post::with(['category', 'author'])
            ->published()
            ->featured()
            ->latest('published_at')
            ->take(5)
            ->get();

        // Latest articles (exclude headline)
        $latestPosts = Post::with(['category', 'author'])
            ->published()
            ->when($headline, fn($q) => $q->where('id', '!=', $headline->id))
            ->latest('published_at')
            ->take(9)
            ->get();

        // Trending: tertinggi views_count 7 hari terakhir
        $trendingPosts = Post::with(['category'])
            ->published()
            ->where('published_at', '>=', now()->subDays(7))
            ->orderByDesc('views_count')
            ->take(5)
            ->get();

        // Semua kategori dengan jumlah post
        $categories = Category::withCount(['posts' => fn($q) => $q->published()])
            ->having('posts_count', '>', 0)
            ->orderByDesc('posts_count')
            ->get();

        return view('home', compact(
            'headline', 'heroSlides', 'latestPosts', 'trendingPosts', 'categories'
        ));
    }
}
