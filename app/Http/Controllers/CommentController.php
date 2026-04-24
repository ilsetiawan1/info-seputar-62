<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $comment = new Comment();
        $comment->post_id = $post->id;
        $comment->user_id = auth()->id();
        $comment->content = $request->content;
        $comment->status = 'approved'; // Opsional: auto approve untuk saat ini

        if ($request->parent_id) {
            // Cek batasan nested max 2 level (parent -> child)
            $parent = Comment::find($request->parent_id);
            if ($parent && $parent->parent_id) {
                // Jika parent sudah merupakan child dari comment lain, jadikan child sejajar.
                $comment->parent_id = $parent->parent_id;
            } else {
                $comment->parent_id = $request->parent_id;
            }
        }

        $comment->save();

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
    }
}
