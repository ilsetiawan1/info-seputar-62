<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

/**
 * Mengelola workflow status artikel:
 * draft → review → published → archived
 */
class PostWorkflowController extends Controller
{
    /*
     * Penulis mengajukan artikel ke tahap review.
     * Hanya penulis artikel itu sendiri yang bisa.
     */
    public function submitForReview(Request $request, Post $post)
    {
        $this->ensureOwnerOrEditor($request, $post);

        if ($post->status !== 'draft') {
            return response()->json(['message' => 'Artikel harus berstatus draft untuk diajukan ke review.'], 422);
        }

        $post->update(['status' => 'review']);

        return response()->json([
            'message' => 'Artikel berhasil diajukan ke editor untuk review.',
            'post'    => new PostResource($post),
        ]);
    }

    /*
     * Editor / Admin menyetujui (publish) artikel.
     */
    public function publish(Request $request, Post $post)
    {
        if ($post->status !== 'review') {
            return response()->json(['message' => 'Artikel harus berstatus review untuk dipublish.'], 422);
        }

        $post->update([
            'status'       => 'published',
            'published_at' => $post->published_at ?? now(),
        ]);

        return response()->json([
            'message' => 'Artikel berhasil dipublish.',
            'post'    => new PostResource($post),
        ]);
    }

    /*
     * Editor / Admin mengembalikan artikel ke draft (revisi).
     */
    public function reject(Request $request, Post $post)
    {
        if ($post->status !== 'review') {
            return response()->json(['message' => 'Artikel harus berstatus review untuk ditolak.'], 422);
        }

        $post->update(['status' => 'draft']);

        return response()->json([
            'message' => 'Artikel dikembalikan ke draft untuk direvisi.',
            'post'    => new PostResource($post),
        ]);
    }

    /*
     * Admin mengarsipkan artikel.
     */
    public function archive(Request $request, Post $post)
    {
        if ($post->status !== 'published') {
            return response()->json(['message' => 'Hanya artikel published yang bisa diarsipkan.'], 422);
        }

        $post->update(['status' => 'archived']);

        return response()->json([
            'message' => 'Artikel berhasil diarsipkan.',
            'post'    => new PostResource($post),
        ]);
    }

    // ─── Helper ─────────────────────────────────────────────
    private function ensureOwnerOrEditor(Request $request, Post $post): void
    {
        $user = $request->user();

        if ($user->isWriter() && $post->author_id !== $user->id) {
            abort(403, 'Anda hanya bisa mengajukan artikel milik Anda sendiri.');
        }
    }
}
