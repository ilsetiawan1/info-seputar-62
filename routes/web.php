<?php

use App\Http\Controllers\CategoryViewController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostViewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TagViewController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

// ─── Frontend Routes (Phase 0-4) ─────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/berita/{slug}', [PostViewController::class, 'show'])->name('post.show');
Route::get('/kategori/{slug}', [CategoryViewController::class, 'show'])->name('category.show');
Route::get('/tag/{slug}', [TagViewController::class, 'show'])->name('tag.show');
Route::get('/cari', [SearchController::class, 'index'])->name('search');

// ─── Dashboard Routes ────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    
    // Admin Dashboard
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });

    // Editor Dashboard
    Route::prefix('editor')->middleware('role:editor')->group(function () {
        Route::get('/dashboard', function () {
            return view('editor.dashboard');
        })->name('editor.dashboard');
    });

    // Writer Dashboard
    Route::prefix('writer')->middleware('role:writer')->group(function () {
        Route::get('/dashboard', function () {
            return view('writer.dashboard');
        })->name('writer.dashboard');
    });

    // ─── Engagement (Comments) ──────────────────────────────────
    Route::post('/berita/{post}/comment', [CommentController::class, 'store'])->name('comment.store');

});

// ─── Breeze Profile Routes ───────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
