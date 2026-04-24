@extends('layouts.app')

@section('title', $category->name . ' — Berita ' . $category->name)
@section('meta_description', 'Kumpulan berita terbaru tentang ' . $category->name . ' di Info Seputar +62.')

@section('content')

{{-- Category Header --}}
<section style="background:linear-gradient(135deg,var(--color-dark-800),var(--color-dark-700));padding:2.5rem 0 2rem;border-bottom:1px solid var(--color-dark-600);">
    <div class="container-site">
        {{-- Breadcrumb --}}
        <nav style="display:flex;align-items:center;gap:0.375rem;font-size:0.75rem;color:var(--color-dark-300);margin-bottom:1rem;flex-wrap:wrap;" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" style="color:inherit;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='var(--color-brand-400)'" onmouseout="this.style.color='inherit'">Beranda</a>
            <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
            <span style="color:var(--color-dark-200);">{{ $category->name }}</span>
        </nav>

        <span class="badge" style="margin-bottom:0.625rem;display:inline-block;">Kategori</span>
        <h1 class="font-display" style="font-size:clamp(1.75rem,5vw,2.75rem);font-weight:700;color:white;margin-bottom:0.375rem;">
            {{ $category->name }}
        </h1>
        <p style="font-size:0.875rem;color:var(--color-dark-300);margin-bottom:1.5rem;">{{ $posts->total() }} artikel tersedia</p>

        {{-- Category chips (horizontal scroll on mobile) --}}
        <div style="display:flex;gap:0.5rem;overflow-x:auto;padding-bottom:0.375rem;scrollbar-width:none;-ms-overflow-style:none;">
            @foreach($categories as $cat)
            <a href="{{ route('category.show', $cat->slug) }}"
               class="filter-chip {{ $cat->id === $category->id ? 'active' : '' }}"
               style="flex-shrink:0;">
                {{ $cat->name }}
                <span style="font-size:0.6875rem;opacity:0.7;">({{ $cat->posts_count }})</span>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Articles --}}
<div class="container-site" style="padding-top:2rem;padding-bottom:3rem;">
    @if($posts->isEmpty())
    <div class="empty-state">
        <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
        <p>Belum ada artikel di kategori ini.</p>
        <a href="{{ route('home') }}" class="btn btn-primary" style="margin-top:1.25rem;">← Kembali ke Beranda</a>
    </div>
    @else
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach($posts as $post)
        <x-article-card :post="$post" />
        @endforeach
    </div>

    @if($posts->hasPages())
    <div style="margin-top:2.5rem;">
        {{ $posts->links('components.pagination') }}
    </div>
    @endif
    @endif
</div>

@endsection
