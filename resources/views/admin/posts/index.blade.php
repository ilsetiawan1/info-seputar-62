@extends('layouts.admin')

@section('title', 'Manajemen Artikel')

@section('content')
<style>
    /* Mengoptimalkan tampilan tabel dan filter */
    .admin-card {
        background: #141414;
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 20px;
        overflow: hidden;
        margin-top: 1rem;
    }
    
    .table-row {
        transition: background 0.2s;
    }
    .table-row:hover {
        background: rgba(255,255,255,0.03);
    }

    /* Padding baris tabel agar tidak sesak saat dibaca */
    .table-row td {
        padding-top: 1.25rem;
        padding-bottom: 1.25rem;
        padding-left: 2rem;
        padding-right: 2rem;
    }

    .admin-card thead th {
        padding-top: 1.25rem;
        padding-bottom: 1.25rem;
        padding-left: 2rem;
        padding-right: 2rem;
    }
    
    .filter-btn {
        padding: 0.5rem 1.25rem;
        border-radius: 10px;
        font-size: 0.8125rem;
        font-weight: 700;
        transition: all 0.2s;
        border: 1px solid transparent;
    }
    .filter-btn.active-all { background: rgba(255,255,255,0.1); color: white; border-color: rgba(255,255,255,0.2); }
    .filter-btn.active-review { background: rgba(234,179,8,0.15); color: #eab308; border-color: rgba(234,179,8,0.3); }
    .filter-btn.active-published { background: rgba(34,197,94,0.15); color: #4ade80; border-color: rgba(34,197,94,0.3); }
    .filter-btn.active-draft { background: rgba(255,255,255,0.1); color: white; border-color: rgba(255,255,255,0.2); }
    .filter-btn:not([class*="active-"]):hover { background: rgba(255,255,255,0.05); color: white; }

    .badge-status {
        display: inline-flex;
        align-items: center;
        padding: 0.35rem 0.85rem;
        border-radius: 999px;
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }
    .badge-published { background: rgba(34,197,94,0.1); color: #4ade80; border: 1px solid rgba(34,197,94,0.2); }
    .badge-review { background: rgba(234,179,8,0.1); color: #eab308; border: 1px solid rgba(234,179,8,0.2); }
    .badge-archived { background: rgba(239,68,68,0.1); color: #f87171; border: 1px solid rgba(239,68,68,0.2); }
    .badge-draft { background: rgba(255,255,255,0.1); color: #e5e5e5; border: 1px solid rgba(255,255,255,0.2); }

    .btn-action {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1.25rem;
        border-radius: 10px;
        font-size: 0.8125rem;
        font-weight: 700;
        background: rgba(249,115,22,0.1);
        color: #fb923c;
        border: 1px solid rgba(249,115,22,0.2);
        transition: all 0.2s;
    }
    .btn-action:hover {
        background: #f97316;
        color: white;
        border-color: #f97316;
        box-shadow: 0 4px 12px rgba(249,115,22,0.3);
    }

    .main-content-wrapper {
        padding-left: 2.5rem;
        padding-right: 1.5rem;
        padding-top: 1.5rem;
        padding-bottom: 2rem;
    }
</style>

<div class="main-content-wrapper">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white font-display mb-1">Manajemen Artikel</h1>
            <p class="text-sm text-gray-500">Kelola dan tinjau semua artikel di portal</p>
        </div>
        
        <div class="flex flex-wrap items-center gap-2 p-1.5 bg-[#141414] rounded-xl border border-white/5 shadow-lg">
            <a href="{{ route('admin.posts.index') }}" class="filter-btn {{ $status === 'all' ? 'active-all' : 'text-gray-400' }}">
                Semua
            </a>
            <a href="{{ route('admin.posts.index', ['status' => 'review']) }}" class="filter-btn {{ $status === 'review' ? 'active-review' : 'text-gray-400' }}">
                Perlu Review
            </a>
            <a href="{{ route('admin.posts.index', ['status' => 'published']) }}" class="filter-btn {{ $status === 'published' ? 'active-published' : 'text-gray-400' }}">
                Terbit
            </a>
            <a href="{{ route('admin.posts.index', ['status' => 'draft']) }}" class="filter-btn {{ $status === 'draft' ? 'active-draft' : 'text-gray-400' }}">
                Draft
            </a>
        </div>
    </div>

    <div class="admin-card shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-black/20 text-gray-500 text-[11px] font-black uppercase tracking-widest border-b border-white/5">
                        <th>Informasi Artikel</th>
                        <th>Status</th>
                        <th class="text-center">Views</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($posts as $post)
                    <tr class="table-row">
                        <td>
                            <p class="font-bold text-white mb-1.5 line-clamp-1 text-base">{{ $post->title }}</p>
                            <div class="flex items-center gap-3 text-[11px] text-gray-500 font-medium">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    {{ $post->author?->name }}
                                </div>
                                <span>•</span>
                                <div class="flex items-center gap-1.5 text-orange-400/80">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                    {{ $post->category?->name }}
                                </div>
                                <span>•</span>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $post->created_at->format('d M Y') }}
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($post->status === 'published')
                            <span class="badge-status badge-published">Published</span>
                            @elseif($post->status === 'review')
                            <span class="badge-status badge-review">Review</span>
                            @elseif($post->status === 'archived')
                            <span class="badge-status badge-archived">Archived</span>
                            @else
                            <span class="badge-status badge-draft">Draft</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="inline-flex items-center justify-center bg-white/5 text-gray-300 font-bold text-[11px] px-3.5 py-1.5 rounded-lg border border-white/5">
                                {{ number_format($post->views_count) }}
                            </span>
                        </td>
                        <td class="text-right">
                            <a href="{{ route('admin.posts.show', $post->id) }}" class="btn-action">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 mb-4 rounded-full bg-white/5 flex items-center justify-center text-gray-500">
                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                </div>
                                <h3 class="text-lg font-bold text-white mb-1">Data Kosong</h3>
                                <p class="text-sm text-gray-500">Belum ada artikel yang ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($posts->hasPages())
        <div class="px-8 py-5 border-t border-white/5 bg-black/20">
            {{ $posts->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
