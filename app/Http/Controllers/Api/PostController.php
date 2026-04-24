<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StorePostRequest;
use App\Http\Requests\Api\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * List published posts dengan filter kategori, status, dan pencarian.
     */
    public function index(Request $request)
    {
        $query = Post::with(['category', 'author', 'tags'])
            ->withCount('approvedComments');

        // Filter status (default: published untuk publik)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->published();
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        // Pencarian judul
        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        // Featured
        if ($request->boolean('featured')) {
            $query->featured();
        }

        $posts = $query->latest('published_at')->paginate($request->integer('per_page', 10));

        return PostResource::collection($posts);
    }

    /**
     * Simpan artikel baru.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']);

        // Jika status publish, set published_at
        if (($data['status'] ?? 'draft') === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $post = Post::create($data);

        // Sync tags jika ada
        if (!empty($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        $post->load(['category', 'author', 'tags']);

        return (new PostResource($post))->response()->setStatusCode(201);
    }

    /**
     * Tampilkan satu artikel (increment view jika published).
     */
    public function show(Post $post)
    {
        $post->load(['category', 'author', 'tags']);

        // Increment views_count
        if ($post->status === 'published') {
            $post->increment('views_count');
        }

        return new PostResource($post);
    }

    /**
     * Update artikel.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->validated();

        if (isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Auto set published_at saat pertama publish
        if (isset($data['status']) && $data['status'] === 'published' && !$post->published_at) {
            $data['published_at'] = now();
        }

        $post->update($data);

        // Sync tags
        if (array_key_exists('tags', $data)) {
            $post->tags()->sync($data['tags'] ?? []);
        }

        $post->load(['category', 'author', 'tags']);

        return new PostResource($post);
    }

    /**
     * Soft-delete artikel.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['message' => 'Artikel berhasil dihapus.'], 200);
    }
}
