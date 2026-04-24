@extends('layouts.app')

@section('title', 'Tag: #' . $tag->name)
@section('meta_description', 'Artikel dengan tag #' . $tag->name . ' di Info Seputar +62.')

@section('content')

{{-- Header --}}
<section style="background:linear-gradient(135deg,var(--color-dark-800),var(--color-dark-700));padding:2.5rem 0 2rem;border-bottom:1px solid var(--color-dark-600);">
    <div class="container-site">
        <nav style="display:flex;align-items:center;gap:0.375rem;font-size:0.75rem;color:var(--color-dark-300);margin-bottom:1rem;" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" style="color:inherit;text-decoration:none;" onmouseover="this.style.color='var(--color-brand-400)'" onmouseout="this.style.color='inherit'">Beranda</a>
            <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
            <span style="color:var(--color-dark-200);">Tag</span>
        </nav>
        <span class="badge badge-dark" style="margin-bottom:0.625rem;display:inline-block;">Tag</span>
        <h1 class="font-display" style="font-size:clamp(1.75rem,5vw,2.5rem);font-weight:700;color:white;margin-bottom:0.375rem;">
            #{{ $tag->name }}
        </h1>
        <p style="font-size:0.875rem;color:var(--color-dark-300);">{{ $posts->total() }} artikel dengan tag ini</p>
    </div>
</section>

{{-- Content --}}
<div class="container-site" style="padding-top:2rem;padding-bottom:3rem;">
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

        <section class="lg:col-span-2" aria-label="Artikel dengan tag {{ $tag->name }}">
            @if($posts->isEmpty())
            <div class="empty-state">
                <p>Belum ada artikel dengan tag ini.</p>
                <a href="{{ route('home') }}" class="btn btn-primary" style="margin-top:1rem;">← Beranda</a>
            </div>
            @else
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                @foreach($posts as $post)
                <x-article-card :post="$post" />
                @endforeach
            </div>
            @if($posts->hasPages())
            <div style="margin-top:2.5rem;">{{ $posts->links('components.pagination') }}</div>
            @endif
            @endif
        </section>

        <aside style="display:flex;flex-direction:column;gap:1.25rem;" aria-label="Sidebar">
            <div class="sidebar-widget">
                <div class="section-label">Tag Populer</div>
                <div class="tag-cloud">
                    @foreach($popularTags as $t)
                    <a href="{{ route('tag.show', $t->slug) }}"
                       class="badge {{ $t->id === $tag->id ? '' : 'badge-dark' }}">
                        #{{ $t->name }}
                        <span style="opacity:0.7;margin-left:0.25rem;">({{ $t->posts_count }})</span>
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="sidebar-widget">
                <div class="section-label">Kategori</div>
                @foreach($categories as $cat)
                <a href="{{ route('category.show', $cat->slug) }}"
                   style="display:flex;align-items:center;justify-content:space-between;padding:0.5rem 0.625rem;border-radius:0.5rem;text-decoration:none;margin-bottom:0.125rem;transition:background 0.2s;"
                   onmouseover="this.style.background='rgba(249,115,22,0.08)'" onmouseout="this.style.background='transparent'">
                    <span style="font-size:0.875rem;font-weight:500;color:var(--color-dark-100);">{{ $cat->name }}</span>
                    <span style="font-size:0.75rem;padding:0.125rem 0.5rem;border-radius:999px;background:var(--color-dark-600);color:var(--color-dark-200);font-weight:700;">{{ $cat->posts_count }}</span>
                </a>
                @endforeach
            </div>
        </aside>
    </div>
</div>

@endsection
