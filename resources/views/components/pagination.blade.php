@if($paginator->hasPages())
<nav class="pagination" aria-label="Pagination">
    {{-- Previous --}}
    @if($paginator->onFirstPage())
    <span class="opacity-30">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
    </span>
    @else
    <a href="{{ $paginator->previousPageUrl() }}" aria-label="Halaman sebelumnya">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
    </a>
    @endif

    {{-- Pages --}}
    @foreach($elements as $element)
        @if(is_string($element))
        <span>{{ $element }}</span>
        @endif
        @if(is_array($element))
            @foreach($element as $page => $url)
                @if($page == $paginator->currentPage())
                <span aria-current="page">{{ $page }}</span>
                @else
                <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next --}}
    @if($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" aria-label="Halaman berikutnya">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
    </a>
    @else
    <span class="opacity-30">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
    </span>
    @endif
</nav>
@endif
