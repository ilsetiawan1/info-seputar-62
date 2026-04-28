@extends('layouts.admin')

@section('title', 'Detail Artikel')

@section('content')

<style>
    .detail-card {
        background: #141414;
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 20px;
        overflow: hidden;
    }
    .meta-box {
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 12px;
        padding: 1rem;
    }
    .badge-status {
        display: inline-flex;
        align-items: center;
        padding: 0.35rem 0.875rem;
        border-radius: 999px;
        font-size: 0.8125rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }
    .badge-published { background: rgba(34,197,94,0.1); color: #4ade80; border: 1px solid rgba(34,197,94,0.2); }
    .badge-review { background: rgba(234,179,8,0.1); color: #eab308; border: 1px solid rgba(234,179,8,0.2); }
    .badge-archived { background: rgba(239,68,68,0.1); color: #f87171; border: 1px solid rgba(239,68,68,0.2); }
    .badge-draft { background: rgba(255,255,255,0.1); color: #e5e5e5; border: 1px solid rgba(255,255,255,0.2); }

    .btn-action-primary {
        background: linear-gradient(135deg, #22c55e, #16a34a);
        color: white;
        border: none;
        box-shadow: 0 4px 15px rgba(34,197,94,0.3);
        transition: all 0.2s;
    }
    .btn-action-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(34,197,94,0.4); }
    
    .btn-action-danger {
        background: transparent;
        color: #f87171;
        border: 1px solid rgba(248,113,113,0.3);
        transition: all 0.2s;
    }
    .btn-action-danger:hover { background: rgba(248,113,113,0.1); border-color: #f87171; }
    
    .btn-action-secondary {
        background: rgba(255,255,255,0.05);
        color: white;
        border: 1px solid rgba(255,255,255,0.1);
        transition: all 0.2s;
    }
    .btn-action-secondary:hover { background: rgba(255,255,255,0.1); }
</style>

<div class="space-y-6">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.posts.index') }}" class="flex items-center justify-center w-10 h-10 rounded-full bg-white/5 text-gray-400 hover:text-white hover:bg-white/10 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white font-display mb-1">Review Artikel</h1>
            <p class="text-sm text-gray-400">Detail dan tindakan untuk artikel ini</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-6">
            <div class="detail-card">
                @if($post->thumbnail)
                <div class="w-full h-[320px] relative overflow-hidden group">
                    <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#141414] via-transparent to-transparent"></div>
                </div>
                @endif
                <div class="p-8 {{ $post->thumbnail ? '-mt-16 relative z-10' : '' }}">
                    <h2 class="text-3xl font-bold text-white font-display leading-tight mb-6" style="text-shadow: 0 2px 10px rgba(0,0,0,0.5);">{{ $post->title }}</h2>
                    
                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-400 mb-8 pb-6 border-b border-white/10">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-white/10 flex items-center justify-center text-xs text-white font-bold">
                                {{ substr($post->author?->name ?? '?', 0, 1) }}
                            </div>
                            <span class="font-medium text-white">{{ $post->author?->name }}</span>
                        </div>
                        <span>•</span>
                        <span class="text-orange-400 font-medium px-2 py-0.5 rounded bg-orange-500/10">{{ $post->category?->name }}</span>
                        <span>•</span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $post->created_at->format('d M Y, H:i') }}
                        </span>
                    </div>

                    <div class="prose prose-invert prose-orange max-w-none text-gray-300 leading-relaxed text-lg">
                        {!! nl2br(e($post->content)) !!}
                    </div>

                    @if($post->tags->isNotEmpty())
                    <div class="mt-10 pt-6 border-t border-white/10 flex flex-wrap gap-2">
                        @foreach($post->tags as $tag)
                        <span class="px-3 py-1.5 text-xs font-semibold bg-white/5 text-gray-300 border border-white/5 rounded-full hover:bg-white/10 transition-colors cursor-default">#{{ $tag->name }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="detail-card p-6">
                <h3 class="text-lg font-bold text-white mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Informasi & Aksi
                </h3>
                
                <div class="space-y-4 mb-8">
                    <div class="meta-box flex flex-col gap-1">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Status Saat Ini</span>
                        <div>
                            @if($post->status === 'published')
                            <span class="badge-status badge-published">Published</span>
                            @elseif($post->status === 'review')
                            <span class="badge-status badge-review">Menunggu Review</span>
                            @elseif($post->status === 'archived')
                            <span class="badge-status badge-archived">Archived</span>
                            @else
                            <span class="badge-status badge-draft">Draft</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="meta-box flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-400">Visibilitas</span>
                        <span class="font-bold text-white flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Publik
                        </span>
                    </div>
                    
                    @if($post->published_at)
                    <div class="meta-box flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-400">Tgl Terbit</span>
                        <span class="font-bold text-white text-sm">{{ $post->published_at->format('d M Y, H:i') }}</span>
                    </div>
                    @endif
                </div>

                @if($post->status === 'review')
                <div class="space-y-3 pt-6 border-t border-white/10">
                    <form action="{{ route('admin.posts.approve', $post->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex justify-center items-center px-4 py-3 btn-action-primary text-sm font-bold rounded-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Setujui & Terbitkan
                        </button>
                    </form>

                    <form action="{{ route('admin.posts.reject', $post->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menolak artikel ini?');">
                        @csrf
                        <button type="submit" class="w-full flex justify-center items-center px-4 py-3 btn-action-danger text-sm font-bold rounded-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            Tolak (Kembali ke Draft)
                        </button>
                    </form>
                </div>
                @elseif($post->status === 'published')
                <div class="pt-6 border-t border-white/10">
                    <a href="{{ route('post.show', $post->slug) }}" target="_blank" class="w-full flex justify-center items-center px-4 py-3 btn-action-secondary text-sm font-bold rounded-xl">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Lihat Artikel Live
                    </a>
                </div>
                @endif
            </div>

            <div class="detail-card p-6">
                <h3 class="text-lg font-bold text-white mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                    SEO & Meta
                </h3>
                <div class="space-y-4">
                    <div class="meta-box">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Meta Title</p>
                        <p class="text-sm font-medium text-gray-300">{{ $post->meta_title ?? '-' }}</p>
                    </div>
                    <div class="meta-box">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Meta Description</p>
                        <p class="text-sm text-gray-400 leading-relaxed">{{ $post->meta_description ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
