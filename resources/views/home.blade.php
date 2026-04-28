<!-- resources\views\home.blade.php -->



@extends('layouts.app')

@section('title', 'Beranda')
@section('meta_description', 'Portal berita digital terpercaya tentang Indonesia. Temukan berita terkini tentang teknologi, politik, olahraga, dan lebih banyak lagi.')

@section('content')

{{-- ══════════════════ HERO ══════════════════ --}}
@if($headline)
<section class="hero" aria-label="Berita utama">
    <div class="hero-bg">
        @if($headline->thumbnail)
            <img src="{{ $headline->thumbnail_url }}" alt="{{ $headline->title }}" loading="eager">
        @else
            <div style="background:linear-gradient(135deg,#1a1a24,#2e2e3d);width:100%;height:100%;"></div>
        @endif
        <div class="hero-bg-gradient"></div>
    </div>

    <div class="hero-content">
        <div class="container-site" style="width:100%;">
            <div style="max-width:42rem;">
                @if($headline->category)
                <a href="{{ route('category.show', $headline->category->slug) }}" class="badge" style="margin-bottom:0.75rem;display:inline-block;">
                    {{ $headline->category->name }}
                </a>
                @endif

                <h1 class="hero-title" style="margin-bottom:0.875rem;">
                    <a href="{{ route('post.show', $headline->slug) }}" style="color:inherit;text-decoration:none;transition:color 0.2s;"
                       onmouseover="this.style.color='var(--color-brand-300)'" onmouseout="this.style.color='inherit'">
                        {{ $headline->title }}
                    </a>
                </h1>

                @if($headline->excerpt)
                <p style="color:var(--color-dark-100);font-size:0.9375rem;line-height:1.6;margin-bottom:1.25rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                    {{ $headline->excerpt }}
                </p>
                @endif

                <div style="display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap;">
                    <a href="{{ route('post.show', $headline->slug) }}" class="btn btn-primary">
                        Baca Selengkapnya
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5m5-5H6"/></svg>
                    </a>
                    <span style="display:flex;align-items:center;gap:0.3rem;font-size:0.8125rem;color:var(--color-dark-200);">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        {{ number_format($headline->views_count) }}
                    </span>
                    <span style="font-size:0.8125rem;color:var(--color-dark-300);"
                          data-relative-time="{{ $headline->published_at?->toIso8601String() }}">
                        {{ $headline->published_at?->diffForHumans() }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    @if($heroSlides->count() > 1)
    <div class="hero-dots" aria-hidden="true">
        @foreach($heroSlides as $i => $slide)
        <a href="{{ route('post.show', $slide->slug) }}" class="hero-dot {{ $i === 0 ? 'active' : '' }}" title="{{ $slide->title }}"></a>
        @endforeach
    </div>
    @endif
</section>
@endif

{{-- ══════════════════ MAIN GRID ══════════════════ --}}
<div class="container-site" style="padding-top:2rem;padding-bottom:3rem;">

    {{-- Mobile: trending pills (horizontal scroll) --}}
    <div style="display:flex;gap:0.5rem;overflow-x:auto;padding-bottom:0.5rem;margin-bottom:1.75rem;scrollbar-width:none;" class="lg:hidden">
        <a href="{{ route('search') }}" class="filter-chip" style="flex-shrink:0;">🔍 Semua</a>
        @foreach($categories->take(6) as $cat)
        <a href="{{ route('category.show', $cat->slug) }}" class="filter-chip" style="flex-shrink:0;">{{ $cat->name }}</a>
        @endforeach
    </div>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

        {{-- ── Latest Articles (main column) ── --}}
        <section class="lg:col-span-2" aria-label="Berita terbaru">
            <div class="section-label">Berita Terbaru</div>

            @if($latestPosts->isEmpty())
            <div class="empty-state">
                <svg width="44" height="44" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                <p>Belum ada artikel.</p>
            </div>
            @else
            {{-- 2 columns on tablet+ --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                @foreach($latestPosts->take(2) as $post)
                <x-article-card :post="$post" />
                @endforeach
            </div>
            @if($latestPosts->count() > 2)
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3" style="margin-top:1rem;">
                @foreach($latestPosts->skip(2) as $post)
                <x-article-card :post="$post" />
                @endforeach
            </div>
            @endif
            <div style="text-align:center;margin-top:1.75rem;">
                <a href="{{ route('search') }}" class="btn btn-outline">
                    Lihat Semua Berita
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5m5-5H6"/></svg>
                </a>
            </div>
            @endif
        </section>

        {{-- ── Sidebar ── --}}
        <aside style="display:flex;flex-direction:column;gap:1.25rem;" aria-label="Sidebar">

            {{-- Trending --}}
            <div class="sidebar-widget">
                <div class="section-label">🔥 Trending</div>
                @if($trendingPosts->isEmpty())
                <p style="font-size:0.875rem;color:var(--color-dark-300);">Belum ada data trending.</p>
                @else
                @foreach($trendingPosts as $i => $post)
                <x-trending-item :post="$post" :rank="$i + 1" />
                @endforeach
                @endif
            </div>

            {{-- Kategori --}}
            <div class="sidebar-widget">
                <div class="section-label">Kategori</div>
                @foreach($categories as $cat)
                <a href="{{ route('category.show', $cat->slug) }}"
                   style="display:flex;align-items:center;justify-content:space-between;padding:0.5rem 0.625rem;border-radius:0.5rem;text-decoration:none;transition:background 0.2s;border:1px solid transparent;"
                   onmouseover="this.style.background='rgba(249,115,22,0.08)';this.style.borderColor='rgba(249,115,22,0.2)'"
                   onmouseout="this.style.background='transparent';this.style.borderColor='transparent'">
                    <span style="font-size:0.875rem;font-weight:600;color:var(--color-dark-100);">{{ $cat->name }}</span>
                    <span style="font-size:0.75rem;font-weight:700;padding:0.125rem 0.5rem;border-radius:999px;background:var(--color-dark-600);color:var(--color-dark-200);">{{ $cat->posts_count }}</span>
                </a>
                @endforeach
            </div>

        </aside>
    </div>
</div>

@endsection
