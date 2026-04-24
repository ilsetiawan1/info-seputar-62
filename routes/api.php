<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PostWorkflowController;
use Illuminate\Support\Facades\Route;

// ─── Auth (Public) ─────────────────────────────────────────
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login',    [AuthController::class, 'login']);
});

// ─── Public Endpoints ──────────────────────────────────────
Route::get('posts',              [PostController::class, 'index']);
Route::get('posts/{post}',       [PostController::class, 'show']);
Route::get('categories',         [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);

// ─── Protected (semua role yang login) ─────────────────────
Route::middleware('auth:sanctum')->group(function () {

    Route::get('auth/me',     [AuthController::class, 'me']);
    Route::post('auth/logout', [AuthController::class, 'logout']);

    // ─── Penulis: buat & edit artikel sendiri ──────────────
    Route::middleware('role:admin,editor,writer')->group(function () {
        Route::post('posts',       [PostController::class, 'store']);
        Route::put('posts/{post}', [PostController::class, 'update']);
        Route::patch('posts/{post}', [PostController::class, 'update']);
    });

    // ─── Workflow: penulis submit, editor approve/reject ───
    Route::prefix('posts/{post}/workflow')->group(function () {
        Route::post('submit',  [PostWorkflowController::class, 'submitForReview'])
            ->middleware('role:admin,editor,writer');

        Route::post('publish', [PostWorkflowController::class, 'publish'])
            ->middleware('role:admin,editor');

        Route::post('reject',  [PostWorkflowController::class, 'reject'])
            ->middleware('role:admin,editor');

        Route::post('archive', [PostWorkflowController::class, 'archive'])
            ->middleware('role:admin');
    });

    // ─── Admin: manajemen kategori & hapus artikel ─────────
    Route::middleware('role:admin')->group(function () {
        Route::delete('posts/{post}',           [PostController::class, 'destroy']);
        Route::post('categories',               [CategoryController::class, 'store']);
        Route::put('categories/{category}',     [CategoryController::class, 'update']);
        Route::delete('categories/{category}',  [CategoryController::class, 'destroy']);
    });

    // ─── Admin & Editor: akses daftar semua status post ────
    Route::middleware('role:admin,editor')->group(function () {
        // Filter posts semua status (draft, review, dll)
        Route::get('admin/posts', [PostController::class, 'index']);
    });
});
