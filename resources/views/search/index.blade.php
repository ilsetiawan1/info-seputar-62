@extends('layouts.app')

@section('title', $q ? 'Hasil: "' . $q . '"' : 'Semua Berita')
@section('meta_description', $q ? 'Hasil pencarian untuk "' . $q . '" di Info Seputar +62.' : 'Semua berita terkini di Info Seputar +62.')

@section('content')

{{-- ══ Search Header ══ --}}
<section style="background:linear-gradient(135deg,var(--color-dark-800),var(--color-dark-700));padding:2rem 0 1.75rem;border-bottom:1px solid var(--color-dark-600);">
    <div class="container-site">
        <div class="section-label" style="margin-bottom:0.75rem;">
            @if($q) 🔍 Hasil Pencarian @else 📰 Semua Berita @endif
        </div>

        {{-- Search bar --}}
        <form action="{{ route('search') }}" method="GET" style="margin-bottom:1.25rem;" aria-label="Form pencarian">
            @if($categorySlug)
            <input type="hidden" name="kategori" value="{{ $categorySlug }}">
            @endif
            @if($tagSlug)
            <input type="hidden" name="tag" value="{{ $tagSlug }}">
            @endif
            <input type="hidden" name="sort" value="{{ $sort }}">
            <div class="search-hero">
                <input type="text" name="q"
                       id="search-input"
                       placeholder="Cari judul, topik, atau kata kunci…"
                       value="{{ $q }}"
                       aria-label="Kata kunci pencarian"
                       autocomplete="off">
                <button type="submit" style="display:flex;align-items:center;gap:0.375rem;">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
                    Cari
                </button>
            </div>
        </form>

        {{-- Result summary --}}
        @if($q)
        <p style="font-size:0.875rem;color:var(--color-dark-200);margin-bottom:1rem;">
            Ditemukan <strong style="color:white;">{{ $results->total() }}</strong> artikel
            untuk <strong style="color:var(--color-brand-400);">"{{ $q }}"</strong>
            @if($categorySlug)
            di kategori <strong style="color:white;">{{ $categorySlug }}</strong>
            @endif
        </p>
        @endif

        {{-- Active filter pills --}}
        @if($categorySlug || $tagSlug)
        <div style="display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap;margin-bottom:0.875rem;">
            <span style="font-size:0.75rem;color:var(--color-dark-300);">Filter aktif:</span>
            @if($categorySlug)
            @php $removeCategory = array_merge(request()->query(), ['kategori' => null]); @endphp
            <a href="{{ route('search', $removeCategory) }}" class="filter-chip active" style="display:inline-flex;align-items:center;gap:0.375rem;">
                {{ $categorySlug }}
                <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </a>
            @endif
            @if($tagSlug)
            @php $removeTag = array_merge(request()->query(), ['tag' => null]); @endphp
            <a href="{{ route('search', $removeTag) }}" class="filter-chip active" style="display:inline-flex;align-items:center;gap:0.375rem;">
                #{{ $tagSlug }}
                <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </a>
            @endif
        </div>
        @endif

        {{-- Sort + Category filter row --}}
        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:0.75rem;flex-wrap:wrap;">
            {{-- Category pills (horizontal scroll on mobile) --}}
            <div style="display:flex;gap:0.375rem;overflow-x:auto;padding-bottom:0.25rem;-ms-overflow-style:none;scrollbar-width:none;flex:1;min-width:0;">
                @php $qAll = array_merge(request()->query(), ['kategori' => null]); @endphp
                <a href="{{ route('search', $qAll) }}"
                   class="filter-chip {{ !$categorySlug ? 'active' : '' }}"
                   style="flex-shrink:0;">Semua</a>
                @foreach($categories as $cat)
                @php $qCat = array_merge(request()->query(), ['kategori' => $cat->slug]); @endphp
                <a href="{{ route('search', $qCat) }}"
                   class="filter-chip {{ $categorySlug === $cat->slug ? 'active' : '' }}"
                   style="flex-shrink:0;">{{ $cat->name }}</a>
                @endforeach
            </div>

            {{-- Sort form --}}
            <form action="{{ route('search') }}" method="GET" style="flex-shrink:0;" aria-label="Urutan">
                @if($q)
                <input type="hidden" name="q" value="{{ $q }}">
                @endif
                @if($categorySlug)
                <input type="hidden" name="kategori" value="{{ $categorySlug }}">
                @endif
                @if($tagSlug)
                <input type="hidden" name="tag" value="{{ $tagSlug }}">
                @endif
                <select name="sort" class="sort-select" onchange="this.form.submit()" aria-label="Urutkan">
                    <option value="terbaru" @selected($sort === 'terbaru')>Terbaru</option>
                    <option value="populer" @selected($sort === 'populer')>Terpopuler</option>
                </select>
            </form>
        </div>
    </div>
</section>

{{-- ══ Results + Sidebar ══ --}}
<div class="container-site" style="padding-top:2rem;padding-bottom:3rem;">
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

        {{-- Results --}}
        <section class="lg:col-span-2" aria-label="Hasil pencarian">
            @if($results->isEmpty())
            <div class="empty-state">
                <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/>
                </svg>
                <p style="margin-bottom:0.5rem;">
                    @if($q) Tidak ada artikel untuk "<strong>{{ $q }}</strong>" @else Belum ada artikel tersedia @endif
                </p>
                <p style="font-size:0.875rem;margin-bottom:1.25rem;color:var(--color-dark-300);">
                    Coba gunakan kata kunci yang berbeda atau hapus filter.
                </p>
                <a href="{{ route('home') }}" class="btn btn-primary">← Beranda</a>
            </div>
            @else
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                @foreach($results as $post)
                <x-article-card :post="$post" />
                @endforeach
            </div>

            @if($results->hasPages())
            <div style="margin-top:2.5rem;">
                {{ $results->links('components.pagination') }}
            </div>
            @endif
            @endif
        </section>

        {{-- Sidebar --}}
        <aside style="display:flex;flex-direction:column;gap:1.25rem;" aria-label="Filter & tag">

            @if($tags->isNotEmpty())
            <div class="sidebar-widget">
                <div class="section-label">🏷️ Jelajahi Tag</div>
                <div class="tag-cloud">
                    @foreach($tags as $tagItem)
                    @php $qTag = array_merge(request()->query(), ['tag' => $tagItem->slug]); @endphp
                    <a href="{{ route('search', $qTag) }}"
                       class="badge {{ $tagSlug === $tagItem->slug ? '' : 'badge-dark' }}"
                       title="{{ $tagItem->posts_count }} artikel">
                        #{{ $tagItem->name }}
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="sidebar-widget">
                <div class="section-label">💡 Tips Pencarian</div>
                <ul style="list-style:none;display:flex;flex-direction:column;gap:0.625rem;">
                    <li style="display:flex;gap:0.5rem;font-size:0.8125rem;color:var(--color-dark-200);">
                        <span style="color:var(--color-brand-400);flex-shrink:0;">🔑</span>
                        Gunakan kata kunci spesifik, misalnya "teknologi AI" atau "pemilu 2025"
                    </li>
                    <li style="display:flex;gap:0.5rem;font-size:0.8125rem;color:var(--color-dark-200);">
                        <span style="color:var(--color-brand-400);flex-shrink:0;">📂</span>
                        Filter per kategori untuk hasil lebih relevan
                    </li>
                    <li style="display:flex;gap:0.5rem;font-size:0.8125rem;color:var(--color-dark-200);">
                        <span style="color:var(--color-brand-400);flex-shrink:0;">🔥</span>
                        Urutkan "Terpopuler" untuk berita paling banyak dibaca
                    </li>
                </ul>
            </div>

        </aside>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Auto-focus on desktop
if (window.innerWidth >= 768) {
    document.getElementById('search-input')?.focus();
}
</script>
@endpush
