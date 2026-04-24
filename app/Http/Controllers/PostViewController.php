<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostViewController extends Controller
{
    public function show(string $slug)
    {
        $post = Post::with([
                'category', 
                'author', 
                'tags',
                'comments' => function($q) {
                    $q->whereNull('parent_id')->with(['user', 'replies.user'])->latest();
                }
            ])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment view count
        $post->increment('views_count');

        // Artikel terkait: kategori sama, exclude current
        $related = Post::with(['category', 'author'])
            ->published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('post.show', compact('post', 'related'));
    }
}
