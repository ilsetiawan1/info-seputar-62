@extends('layouts.app')

@section('title', $post->meta_title ?? $post->title)
@section('meta_description', $post->meta_description ?? $post->excerpt)
@section('og_title', $post->title)
@section('og_description', $post->excerpt)
@section('og_type', 'article')
@if($post->thumbnail)@section('og_image', asset('storage/' . $post->thumbnail))@endif
@section('show-reading-bar', true)

@section('content')

{{-- Thumbnail hero --}}
@if($post->thumbnail)
<div style="width:100%;max-height:400px;overflow:hidden;">
    <img src="{{ asset('storage/' . $post->thumbnail) }}"
         alt="{{ $post->title }}"
         style="width:100%;max-height:400px;object-fit:cover;display:block;filter:brightness(0.85);"
         loading="eager">
</div>
@endif

<div class="container-site" style="padding-top:1.5rem;padding-bottom:3rem;">
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

        {{-- ══ Main Article ══ --}}
        <article class="lg:col-span-2" itemscope itemtype="https://schema.org/Article">

            {{-- Breadcrumb --}}
            <nav style="display:flex;align-items:center;gap:0.375rem;font-size:0.75rem;color:var(--color-dark-300);margin-bottom:1rem;flex-wrap:wrap;" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" style="color:inherit;text-decoration:none;" onmouseover="this.style.color='var(--color-brand-400)'" onmouseout="this.style.color='inherit'">Beranda</a>
                <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                @if($post->category)
                <a href="{{ route('category.show', $post->category->slug) }}" style="color:inherit;text-decoration:none;" onmouseover="this.style.color='var(--color-brand-400)'" onmouseout="this.style.color='inherit'">{{ $post->category->name }}</a>
                <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                @endif
                <span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:180px;color:var(--color-dark-200);" title="{{ $post->title }}">{{ $post->title }}</span>
            </nav>

            @if($post->category)
            <a href="{{ route('category.show', $post->category->slug) }}" class="badge" style="margin-bottom:0.875rem;display:inline-block;">{{ $post->category->name }}</a>
            @endif

            <h1 class="font-display" style="font-size:clamp(1.5rem,3.5vw,2.25rem);font-weight:700;color:white;line-height:1.25;margin-bottom:1.125rem;" itemprop="headline">
                {{ $post->title }}
            </h1>

            {{-- Meta bar --}}
            <div style="display:flex;flex-wrap:wrap;align-items:center;gap:0.875rem;padding-bottom:1rem;margin-bottom:1.25rem;border-bottom:1px solid var(--color-dark-600);">
                <div style="display:flex;align-items:center;gap:0.5rem;">
                    <div style="width:32px;height:32px;border-radius:50%;background:var(--color-brand-600);display:flex;align-items:center;justify-content:center;font-size:0.8125rem;font-weight:700;color:white;flex-shrink:0;">
                        {{ substr($post->author?->name ?? 'A', 0, 1) }}
                    </div>
                    <div>
                        <p style="font-size:0.8125rem;font-weight:700;color:white;line-height:1;" itemprop="author">{{ $post->author?->name ?? 'Redaksi' }}</p>
                        <p style="font-size:0.6875rem;color:var(--color-dark-300);">Penulis</p>
                    </div>
                </div>
                <time style="display:flex;align-items:center;gap:0.3rem;font-size:0.8125rem;color:var(--color-dark-300);"
                      itemprop="datePublished" datetime="{{ $post->published_at?->toIso8601String() }}"
                      data-relative-time="{{ $post->published_at?->toIso8601String() }}">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    {{ $post->published_at?->isoFormat('D MMMM Y') }}
                </time>
                <span style="display:flex;align-items:center;gap:0.3rem;font-size:0.8125rem;color:var(--color-dark-300);">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    {{ number_format($post->views_count) }}
                </span>
                <button onclick="handleShare()" class="btn btn-outline btn-sm" style="margin-left:auto;" id="btn-share">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><path d="m8.59 13.51 6.83 3.98M15.41 6.51l-6.82 3.98"/></svg>
                    Bagikan
                </button>
            </div>

            {{-- Excerpt highlight --}}
            @if($post->excerpt)
            <p style="font-size:1rem;font-weight:500;line-height:1.7;padding:1rem;border-radius:0.625rem;margin-bottom:1.5rem;background:var(--color-dark-700);border-left:3px solid var(--color-brand-500);color:var(--color-dark-100);">
                {{ $post->excerpt }}
            </p>
            @endif

            {{-- Main content --}}
            <div class="prose-content" itemprop="articleBody">
                {!! nl2br(e($post->content)) !!}
            </div>

            {{-- Tags --}}
            @if($post->tags->isNotEmpty())
            <div style="margin-top:2rem;padding-top:1.25rem;border-top:1px solid var(--color-dark-600);">
                <p style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--color-dark-300);margin-bottom:0.625rem;">Tags:</p>
                <div class="tag-cloud">
                    @foreach($post->tags as $tag)
                    <a href="{{ route('tag.show', $tag->slug) }}" class="badge badge-dark">{{ $tag->name }}</a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ══ Komentar ══ --}}
            <div id="komentar" style="margin-top:3rem;padding-top:2rem;border-top:1px solid var(--color-dark-700);">
                <div class="section-label">Komentar ({{ $post->comments->count() }})</div>
                
                {{-- Form Tambah Komentar --}}
                @auth
                <form action="{{ route('comment.store', $post->id) }}" method="POST" style="margin-bottom:2rem;background:var(--color-dark-800);padding:1.25rem;border-radius:0.75rem;border:1px solid var(--color-dark-600);">
                    @csrf
                    <input type="hidden" name="parent_id" id="parent_id" value="">
                    
                    <div id="reply-to" style="display:none;align-items:center;justify-content:space-between;padding:0.5rem 0.75rem;background:var(--color-dark-700);border-left:3px solid var(--color-brand-500);border-radius:0.375rem;font-size:0.8125rem;color:var(--color-dark-100);margin-bottom:0.75rem;">
                        <span>Membalas komentar <strong id="reply-to-name"></strong></span>
                        <button type="button" onclick="cancelReply()" style="background:transparent;border:none;color:var(--color-dark-300);cursor:pointer;">✖</button>
                    </div>

                    <textarea name="content" rows="3" placeholder="Tulis komentar Anda..." required
                              style="width:100%;background:var(--color-dark-700);border:1px solid var(--color-dark-500);border-radius:0.5rem;padding:0.75rem;color:white;font-size:0.9375rem;resize:vertical;outline:none;margin-bottom:0.75rem;"></textarea>
                    
                    <div style="display:flex;justify-content:flex-end;">
                        <button type="submit" class="btn btn-primary btn-sm">Kirim Komentar</button>
                    </div>
                </form>
                @else
                <div style="background:var(--color-dark-800);padding:1.5rem;border-radius:0.75rem;border:1px solid var(--color-dark-600);text-align:center;margin-bottom:2rem;">
                    <p style="font-size:0.875rem;color:var(--color-dark-200);margin-bottom:0.75rem;">Silakan login untuk memberikan komentar.</p>
                    <a href="{{ route('login') }}" class="btn btn-outline btn-sm">Login Sekarang</a>
                </div>
                @endauth

                {{-- Daftar Komentar --}}
                <div style="display:flex;flex-direction:column;gap:1.5rem;">
                    @forelse($post->comments as $comment)
                        @if(!$comment->parent_id) 
                        {{-- Parent Comment --}}
                        <div style="display:flex;gap:1rem;">
                            <div style="width:40px;height:40px;border-radius:50%;background:var(--color-dark-600);display:flex;align-items:center;justify-content:center;font-weight:700;color:white;flex-shrink:0;">
                                {{ substr($comment->user->name ?? 'A', 0, 1) }}
                            </div>
                            <div style="flex:1;">
                                <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.25rem;">
                                    <span style="font-size:0.9375rem;font-weight:600;color:white;">{{ $comment->user->name ?? 'Anonim' }}</span>
                                    <span style="font-size:0.75rem;color:var(--color-dark-300);">• {{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p style="font-size:0.9375rem;color:var(--color-dark-100);line-height:1.6;margin-bottom:0.5rem;">
                                    {{ $comment->content }}
                                </p>
                                @auth
                                <button onclick="setReply({{ $comment->id }}, '{{ addslashes($comment->user->name ?? 'Anonim') }}')" style="background:transparent;border:none;font-size:0.8125rem;font-weight:600;color:var(--color-dark-200);cursor:pointer;transition:color 0.2s;" onmouseover="this.style.color='var(--color-brand-400)'" onmouseout="this.style.color='var(--color-dark-200)'">Balas</button>
                                @endauth

                                {{-- Nested Replies --}}
                                @if($comment->replies && $comment->replies->count() > 0)
                                <div style="margin-top:1rem;display:flex;flex-direction:column;gap:1rem;border-left:2px solid var(--color-dark-700);padding-left:1rem;">
                                    @foreach($comment->replies as $reply)
                                    <div style="display:flex;gap:0.75rem;">
                                        <div style="width:32px;height:32px;border-radius:50%;background:var(--color-dark-600);display:flex;align-items:center;justify-content:center;font-weight:700;color:white;font-size:0.75rem;flex-shrink:0;">
                                            {{ substr($reply->user->name ?? 'A', 0, 1) }}
                                        </div>
                                        <div style="flex:1;">
                                            <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.25rem;">
                                                <span style="font-size:0.875rem;font-weight:600;color:white;">{{ $reply->user->name ?? 'Anonim' }}</span>
                                                <span style="font-size:0.75rem;color:var(--color-dark-300);">• {{ $reply->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p style="font-size:0.875rem;color:var(--color-dark-100);line-height:1.5;">
                                                {{ $reply->content }}
                                            </p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    @empty
                        <p style="font-size:0.875rem;color:var(--color-dark-300);text-align:center;padding:2rem 0;">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                    @endforelse
                </div>
            </div>

        </article>

        {{-- ══ Sidebar ══ --}}
        <aside style="display:flex;flex-direction:column;gap:1.25rem;" class="lg:sticky lg:top-20 self-start">

            @if($related->isNotEmpty())
            <div class="sidebar-widget">
                <div class="section-label">Artikel Terkait</div>
                <div style="display:flex;flex-direction:column;gap:0.875rem;">
                    @foreach($related as $rel)
                    <a href="{{ route('post.show', $rel->slug) }}" style="display:flex;gap:0.75rem;text-decoration:none;group">
                        <div style="width:60px;height:60px;border-radius:0.5rem;overflow:hidden;flex-shrink:0;">
                            @if($rel->thumbnail)
                            <img src="{{ asset('storage/' . $rel->thumbnail) }}" alt="{{ $rel->title }}" style="width:100%;height:100%;object-fit:cover;">
                            @else
                            <div class="img-placeholder" style="width:100%;height:100%;"></div>
                            @endif
                        </div>
                        <div style="flex:1;min-width:0;">
                            <p style="font-size:0.8125rem;font-weight:600;color:white;line-height:1.35;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;transition:color 0.2s;"
                               onmouseover="this.style.color='var(--color-brand-400)'" onmouseout="this.style.color='white'">
                                {{ $rel->title }}
                            </p>
                            <p style="font-size:0.6875rem;color:var(--color-dark-300);margin-top:0.25rem;">{{ $rel->published_at?->diffForHumans() }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="sidebar-widget">
                <div class="section-label">Kategori</div>
                @php $allCats = \App\Models\Category::withCount(['posts' => fn($q) => $q->published()])->having('posts_count','>',0)->get(); @endphp
                @foreach($allCats as $cat)
                <a href="{{ route('category.show', $cat->slug) }}"
                   style="display:flex;align-items:center;justify-content:space-between;padding:0.5rem 0.625rem;border-radius:0.5rem;text-decoration:none;transition:background 0.2s;margin-bottom:0.125rem;"
                   onmouseover="this.style.background='rgba(249,115,22,0.08)'" onmouseout="this.style.background='transparent'">
                    <span style="font-size:0.875rem;font-weight:{{ $post->category_id === $cat->id ? '700' : '500' }};color:{{ $post->category_id === $cat->id ? 'var(--color-brand-400)' : 'var(--color-dark-100)' }};">{{ $cat->name }}</span>
                    <span style="font-size:0.75rem;font-weight:700;padding:0.125rem 0.5rem;border-radius:999px;background:var(--color-dark-600);color:var(--color-dark-200);">{{ $cat->posts_count }}</span>
                </a>
                @endforeach
            </div>

        </aside>
    </div>
</div>

{{-- Baca Juga section --}}
@if($related->isNotEmpty())
<section style="background:var(--color-dark-800);border-top:1px solid var(--color-dark-700);padding:2rem 0 3rem;">
    <div class="container-site">
        <div class="section-label">Baca Juga</div>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($related as $rel)
            <x-article-card :post="$rel" />
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

@push('scripts')
<script>
function handleShare() {
    const title = @js($post->title);
    const url = window.location.href;
    if (navigator.share) {
        navigator.share({ title, url }).catch(() => {});
    } else {
        navigator.clipboard.writeText(url).then(() => showToast('Link artikel disalin!', 'success'));
    }
}

function setReply(commentId, authorName) {
    document.getElementById('parent_id').value = commentId;
    document.getElementById('reply-to-name').innerText = authorName;
    document.getElementById('reply-to').style.display = 'flex';
    document.querySelector('textarea[name="content"]').focus();
    // Scroll to form
    document.getElementById('komentar').scrollIntoView({ behavior: 'smooth' });
}

function cancelReply() {
    document.getElementById('parent_id').value = '';
    document.getElementById('reply-to').style.display = 'none';
}
</script>
@endpush
