@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

<style>
    /* Mengoptimalkan kartu agar lebih simetris */
    .stat-card {
        background: #141414;
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 20px;
        padding: 1.75rem; /* Ditambah dari 1.5rem agar lebih lega */
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        border-color: rgba(249,115,22,0.3);
        box-shadow: 0 12px 30px rgba(0,0,0,0.5);
    }
    
    .stat-icon-wrap {
        width: 52px; height: 52px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 1.25rem; /* Memberi jarak konsisten ke teks bawah */
    }

    .table-container {
        background: #141414;
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 20px;
        overflow: hidden;
        margin-top: 1rem; /* Jarak dari elemen di atasnya */
    }
    
    .table-row {
        transition: background 0.2s;
    }

    /* Padding baris tabel agar tidak sesak saat dibaca */
.table-row td {
    padding-top: 1.25rem;
    padding-bottom: 1.25rem;
    padding-left: 2rem;   /* setara px-8 */
    padding-right: 2rem;
}
    
    .btn-review {
        background: rgba(249,115,22,0.1);
        color: #fb923c;
        border: 1px solid rgba(249,115,22,0.2);
        padding: 0.5rem 1.25rem; /* Padding tombol dibuat lebih lebar (horizontal) */
        border-radius: 10px;
        font-size: 0.8125rem;
        font-weight: 700;
        transition: all 0.2s;
    }

    .main-content-wrapper {
        padding-left: 2.5rem;  /* Ini untuk renggang bagian kiri */
        padding-right: 1.5rem; /* Ini agar simetris di kanan */
        padding-top: 1.5rem;
        padding-bottom: 2rem;
    }
    
    /* Memastikan grid card punya gap yang cukup */
    .stats-grid {
        display: grid;
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .table-container {
        background: #141414;
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 20px;
        overflow: hidden;
        margin-top: 1rem; /* Jarak dari elemen di atasnya */
    }

    .table-row td {
        padding: 1.25rem 2rem;
    }

    .table-container thead th {
        padding: 1.25rem 2rem;
    }
</style>

<div class="main-content-wrapper">
    <div class="mb-10">
        <h1 class="text-2xl font-bold text-white font-display mb-1">Ikhtisar Platform</h1>
        <p class="text-sm text-gray-400">Ringkasan statistik portal berita Info Seputar +62</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="stat-card group">
            <div class="flex items-start justify-between">
                <div class="stat-icon-wrap bg-blue-500/10 text-blue-400 group-hover:bg-blue-500 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
                <span class="flex items-center text-xs font-bold text-green-400 bg-green-500/10 px-2.5 py-1 rounded-md">
                    +12% <svg class="w-3 h-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                </span>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-400 mb-1">Total Artikel</p>
                <p class="text-3xl font-bold text-white tracking-tight">{{ number_format($totalArticles) }}</p>
            </div>
        </div>

        <div class="stat-card group">
            <div class="stat-icon-wrap bg-green-500/10 text-green-400 group-hover:bg-green-500 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-400 mb-1">Artikel Terbit</p>
                <p class="text-3xl font-bold text-white tracking-tight">{{ number_format($publishedArticles) }}</p>
            </div>
        </div>

        <div class="stat-card group">
            <div class="flex items-start justify-between">
                <div class="stat-icon-wrap bg-yellow-500/10 text-yellow-400 group-hover:bg-yellow-500 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                @if($pendingReviews > 0)
                <span class="text-[10px] font-bold text-yellow-400 bg-yellow-500/10 px-2 py-1 rounded-md uppercase tracking-wider">
                    Perlu Review
                </span>
                @endif
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-400 mb-1">Menunggu Review</p>
                <p class="text-3xl font-bold text-white tracking-tight">{{ number_format($pendingReviews) }}</p>
            </div>
        </div>

        <div class="stat-card group">
            <div class="flex items-start justify-between">
                <div class="stat-icon-wrap bg-purple-500/10 text-purple-400 group-hover:bg-purple-500 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <span class="flex items-center text-xs font-bold text-green-400 bg-green-500/10 px-2.5 py-1 rounded-md">
                    +4% <svg class="w-3 h-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                </span>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-400 mb-1">Total Pengguna</p>
                <p class="text-3xl font-bold text-white tracking-tight">{{ number_format($totalUsers) }}</p>
            </div>
        </div>
    </div>

    {{-- Recent Pending Reviews Section --}}
    <div class="table-container shadow-lg">
        <div class="px-8  py-6 border-b border-white/5 flex flex-col sm:flex-row gap-4 sm:items-center justify-between bg-white/2">
            <div>
                <h2 class="text-lg font-bold text-white">Antrean Review</h2>
                <p class="text-sm text-gray-500 mt-1">Daftar artikel masuk yang perlu divalidasi</p>
            </div>
            <a href="{{ route('admin.posts.index') }}" class="inline-flex items-center text-sm font-bold text-orange-400 hover:text-orange-300 transition-colors group">
                Lihat Semua Antrean 
                <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-black/20 text-gray-500 text-[11px] font-black uppercase tracking-widest">
                        <th class="px-8 py-5">Artikel Info</th>
                        <th class="px-8 py-5">Penulis</th>
                        <th class="px-8 py-5 text-center">Kategori</th>
                        <th class="px-8 py-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($recentPendingPosts as $post)
                    <tr class="table-row hover:bg-white/[0.03]">
                        <td class="px-8">
                            <p class="text-sm font-bold text-white mb-1.5">{{ $post->title }}</p>
                            <div class="flex items-center gap-2 text-[11px] text-gray-500">
                                <svg class="w-3.5 h-3.5 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Diajukan {{ $post->created_at->diffForHumans() }}</span>
                            </div>
                        </td>
                        <td class="px-8">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-[11px] font-bold text-white border border-white/5">
                                    {{ substr($post->author?->name ?? '?', 0, 1) }}
                                </div>
                                <span class="text-sm font-medium text-gray-300">{{ $post->author?->name }}</span>
                            </div>
                        </td>
                        <td class="px-8 text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-white/5 text-gray-400 border border-white/10 uppercase tracking-tighter">
                                {{ $post->category?->name }}
                            </span>
                        </td>
                        <td class="px-8 text-right">
                            <a href="{{ route('admin.posts.show', $post->id) }}" class="btn-review inline-flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Review
                            </a>
                        </td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection