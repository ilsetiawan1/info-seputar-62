<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = Post::with(['author', 'category'])->latest();
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $posts = $query->paginate(15);
        return view('admin.posts.index', compact('posts', 'status'));
    }

    public function show(Post $post)
    {
        $post->load(['author', 'category', 'tags']);
        return view('admin.posts.show', compact('post'));
    }

    public function approve(Post $post)
    {
        $post->update([
            'status' => 'published',
            'published_at' => now(),
        ]);
        
        return redirect()->route('admin.posts.index')->with('success', 'Artikel berhasil diterbitkan.');
    }

    public function reject(Post $post)
    {
        $post->update([
            'status' => 'draft',
        ]);
        
        return redirect()->route('admin.posts.index')->with('success', 'Artikel telah ditolak dan dikembalikan menjadi draft.');
    }
}
