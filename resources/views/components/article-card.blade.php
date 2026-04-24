@props(['post'])

<article class="card" itemscope itemtype="https://schema.org/Article">
    {{-- Thumbnail --}}
    <a href="{{ route('post.show', $post->slug) }}" class="card-thumb" aria-label="{{ $post->title }}" tabindex="-1">
        <div class="card-thumb-inner {{ $post->thumbnail ? '' : 'no-img' }}">
            @if($post->thumbnail)
                <img src="{{ asset('storage/' . $post->thumbnail) }}"
                     alt="{{ $post->title }}"
                     loading="lazy" decoding="async">
            @else
                <svg width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1" opacity="0.4">
                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                    <circle cx="8.5" cy="8.5" r="1.5"/>
                    <path d="m21 15-5-5L5 21"/>
                </svg>
            @endif
        </div>
        @if($post->is_featured)
        <span class="badge badge-featured" style="position:absolute;top:0.625rem;left:0.625rem;z-index:1;">★ Featured</span>
        @endif
    </a>

    {{-- Body --}}
    <div class="card-body">
        @if($post->category)
        <a href="{{ route('category.show', $post->category->slug) }}" class="badge" style="align-self:flex-start;" itemprop="articleSection">
            {{ $post->category->name }}
        </a>
        @endif

        <h3 class="card-title" itemprop="headline">
            <a href="{{ route('post.show', $post->slug) }}" style="color:inherit;text-decoration:none;">{{ $post->title }}</a>
        </h3>

        @if($post->excerpt)
        <p class="card-excerpt">{{ $post->excerpt }}</p>
        @endif

        <div class="card-meta">
            <span class="card-meta-author" itemprop="author">{{ $post->author?->name ?? 'Redaksi' }}</span>
            <div class="card-meta-right">
                <span data-relative-time="{{ $post->published_at?->toIso8601String() }}">
                    {{ $post->published_at?->diffForHumans() }}
                </span>
                <span style="display:flex;align-items:center;gap:2px;">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    {{ number_format($post->views_count) }}
                </span>
            </div>
        </div>
    </div>
</article>
