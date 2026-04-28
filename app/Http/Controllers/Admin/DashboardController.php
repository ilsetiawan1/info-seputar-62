<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalArticles = Post::count();
        $publishedArticles = Post::published()->count();
        $pendingReviews = Post::where('status', 'review')->count();
        
        $recentPendingPosts = Post::with(['author', 'category'])
                                ->where('status', 'review')
                                ->latest()
                                ->take(5)
                                ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalArticles', 'publishedArticles', 'pendingReviews', 'recentPendingPosts'
        ));
    }
}
