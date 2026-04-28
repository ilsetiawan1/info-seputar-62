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
    
    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
        Route::resource('tags', \App\Http\Controllers\Admin\TagController::class)->except(['show']);
        
        Route::get('posts', [\App\Http\Controllers\Admin\PostController::class, 'index'])->name('posts.index');
        Route::get('posts/{post}', [\App\Http\Controllers\Admin\PostController::class, 'show'])->name('posts.show');
        Route::post('posts/{post}/approve', [\App\Http\Controllers\Admin\PostController::class, 'approve'])->name('posts.approve');
        Route::post('posts/{post}/reject', [\App\Http\Controllers\Admin\PostController::class, 'reject'])->name('posts.reject');
        
        // Kelola User
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->except(['show']);
    });
    
    // Internal Profile Route (Admin, Editor, Writer)
    Route::prefix('admin/profile')->name('admin.profile.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('update');
        Route::delete('/', [\App\Http\Controllers\Admin\ProfileController::class, 'destroy'])->name('destroy');
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
