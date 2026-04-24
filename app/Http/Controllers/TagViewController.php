<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagViewController extends Controller
{
    public function show(Request $request, string $slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        $posts = Post::with(['category', 'author'])
            ->published()
            ->whereHas('tags', fn($q) => $q->where('slug', $slug))
            ->latest('published_at')
            ->paginate(12);

        $categories = Category::withCount(['posts' => fn($q) => $q->published()])
            ->having('posts_count', '>', 0)
            ->orderByDesc('posts_count')
            ->get();

        $popularTags = Tag::has('posts')->withCount('posts')->orderByDesc('posts_count')->take(20)->get();

        return view('tag.show', compact('tag', 'posts', 'categories', 'popularTags'));
    }
}
