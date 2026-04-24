@props(['post', 'rank'])

<div class="trending-item">
    <span class="trending-num">{{ str_pad($rank, 2, '0', STR_PAD_LEFT) }}</span>
    <div style="flex:1;min-width:0;">
        @if($post->category)
        <a href="{{ route('category.show', $post->category->slug) }}" class="badge" style="margin-bottom:0.375rem;display:inline-block;">
            {{ $post->category->name }}
        </a>
        @endif
        <h4 style="font-size:0.875rem;font-weight:700;color:white;line-height:1.35;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
            <a href="{{ route('post.show', $post->slug) }}" style="color:inherit;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='var(--color-brand-400)'" onmouseout="this.style.color='inherit'">{{ $post->title }}</a>
        </h4>
        <p style="font-size:0.75rem;color:var(--color-dark-400);margin-top:0.25rem;display:flex;align-items:center;gap:3px;">
            <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            {{ number_format($post->views_count) }}
        </p>
    </div>
</div>
