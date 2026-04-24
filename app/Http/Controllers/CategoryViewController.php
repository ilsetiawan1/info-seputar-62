<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryViewController extends Controller
{
    public function show(Request $request, string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = Post::with(['category', 'author'])
            ->published()
            ->where('category_id', $category->id)
            ->latest('published_at')
            ->paginate(12);

        $categories = Category::withCount(['posts' => fn($q) => $q->published()])
            ->having('posts_count', '>', 0)
            ->orderByDesc('posts_count')
            ->get();

        return view('category.show', compact('category', 'posts', 'categories'));
    }
}
