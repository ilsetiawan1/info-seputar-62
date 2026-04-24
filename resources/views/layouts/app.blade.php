
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

{{-- Meta default (temporary) --}}
<meta name="description" content="@yield('meta_description', 'Portal berita terpercaya dengan informasi terbaru dan teraktual.')">
<meta property="og:title" content="@yield('title', 'Info Seputar +62')">
<meta property="og:image" content="@yield('og_image', asset('images/default-og.jpg'))">

    <title>@yield('title', 'Info Seputar +62') | Info Seputar +62</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,700;0,800;1,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @if(trim($__env->yieldContent('show-reading-bar')))
    <div id="reading-bar"></div>
    @endif

    {{-- ══ Navbar Default ══ --}}
    <nav class="navbar relative z-100">
        <div class="container-site navbar-inner">

            {{-- Logo --}}
            <a href="{{ route('home') }}" style="text-decoration:none;" class="nav-logo">
                <div class="nav-logo-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>
                </div>
                <div class="nav-logo-text">Info<span class="nav-logo-accent">Seputar</span></div>
            </a>

            {{-- Desktop Links --}}
            <div class="nav-links">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('search') }}" class="nav-link {{ request()->routeIs('search') ? 'active' : '' }}">Eksplor</a>
                
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
                    @elseif(auth()->user()->role === 'editor')
                        <a href="{{ route('editor.dashboard') }}" class="nav-link">Dashboard</a>
                    @else
                        <a href="{{ route('writer.dashboard') }}" class="nav-link">Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="nav-link" style="color:var(--color-brand-400);">Login</a>
                @endauth
            </div>

            {{-- Desktop Search --}}
            <form action="{{ route('search') }}" method="GET" class="nav-search hidden lg:flex" aria-label="Pencarian cepat">
                <input type="text" name="q" placeholder="Cari berita..." required>
                <button type="submit" aria-label="Cari"><svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg></button>
            </form>

            {{-- Mobile Toggle --}}
            <button class="menu-toggle-btn md:hidden" id="menu-toggle" aria-label="Buka menu">
                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path id="menu-icon-path" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>

        {{-- Mobile Menu --}}
        <div class="mobile-menu px-4 bg-dark-800" id="mobile-menu" style="display:none;">
            <form action="{{ route('search') }}" method="GET" class="mobile-menu-search mb-4">
                <input type="text" name="q" placeholder="Cari judul, topik..." required>
                <button type="submit"><svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg></button>
            </form>
            <div class="flex flex-col gap-2 pb-4">
                <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('search') }}" class="mobile-nav-link {{ request()->routeIs('search') ? 'active' : '' }}">Semua Berita</a>
                
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="mobile-nav-link">Dashboard Admin</a>
                    @elseif(auth()->user()->role === 'editor')
                        <a href="{{ route('editor.dashboard') }}" class="mobile-nav-link">Dashboard Editor</a>
                    @else
                        <a href="{{ route('writer.dashboard') }}" class="mobile-nav-link">Dashboard Penulis</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" style="margin-top:0.5rem;">
                        @csrf
                        <button type="submit" class="mobile-nav-link" style="width:100%;text-align:left;color:var(--color-brand-400);">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="mobile-nav-link" style="color:var(--color-brand-400);">Login / MASUK</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Flash Toast Data --}}
    @if(session('success'))
    <div data-flash="{{ session('success') }}" data-flash-type="success"></div>
    @endif
    @if(session('error'))
    <div data-flash="{{ session('error') }}" data-flash-type="error"></div>
    @endif

    {{-- Main Content Space --}}
    <main>
        @yield('content')
    </main>

    {{-- ══ Footer ══ --}}
    <footer style="background:var(--color-dark-900);padding:4rem 0 2rem;border-top:1px solid var(--color-dark-700);margin-top:auto;">
        <div class="container-site">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-4" style="margin-bottom:3rem;">
                <div class="md:col-span-2">
                    <a href="{{ route('home') }}" style="display:flex;align-items:center;gap:0.5rem;text-decoration:none;margin-bottom:1rem;">
                        <div style="width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;background:var(--color-brand-500);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>
                        </div>
                        <span style="font-family:var(--font-display);font-weight:700;color:white;font-size:1.25rem;">Info<span style="color:var(--color-brand-400);">Seputar</span></span>
                    </a>
                    <p style="font-size:0.875rem;color:var(--color-dark-200);line-height:1.6;max-width:300px;">
                        Portal berita digital modern terpercaya yang menyajikan informasi aktual dan mendalam.
                    </p>
                </div>
                <div>
                    <h3 style="font-size:0.9375rem;font-weight:700;color:white;margin-bottom:1rem;">Navigasi</h3>
                    <ul style="list-style:none;display:flex;flex-direction:column;gap:0.5rem;font-size:0.875rem;">
                        <li><a href="{{ route('home') }}" style="color:var(--color-dark-200);text-decoration:none;">Beranda</a></li>
                        <li><a href="{{ route('search') }}" style="color:var(--color-dark-200);text-decoration:none;">Eksplor</a></li>
                        <li><a href="/login" style="color:var(--color-dark-200);text-decoration:none;">Redaksi Login</a></li>
                    </ul>
                </div>
                <div>
                    <h3 style="font-size:0.9375rem;font-weight:700;color:white;margin-bottom:1rem;">Kategori</h3>
                    <ul style="list-style:none;display:flex;flex-direction:column;gap:0.5rem;font-size:0.875rem;">
                        @foreach(\App\Models\Category::take(4)->get() as $fc)
                        <li><a href="{{ route('category.show', $fc->slug) }}" style="color:var(--color-dark-200);text-decoration:none;">{{ $fc->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div style="border-top:1px solid var(--color-dark-700);padding-top:1.5rem;display:flex;flex-direction:column;gap:1rem;md:flex-row;md:justify-between;align-items:center;font-size:0.8125rem;color:var(--color-dark-300);">
                <p>&copy; {{ date('Y') }} Info Seputar +62. Hak Cipta Dilindungi.</p>
                <div style="display:flex;gap:1rem;">
                    <a href="#" style="color:var(--color-dark-300);text-decoration:none;">Kebijakan Privasi</a>
                    <a href="#" style="color:var(--color-dark-300);text-decoration:none;">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    <div id="toast-container"></div>

    <script>
    document.getElementById('menu-toggle')?.addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        const path = document.getElementById('menu-icon-path');
        if(menu.style.display === 'none') {
            menu.style.display = 'block';
            path.setAttribute('d', 'M6 18L18 6M6 6l12 12');
            this.style.color = 'var(--color-brand-400)';
        } else {
            menu.style.display = 'none';
            path.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
            this.style.color = 'var(--color-dark-100)';
        }
    });
    </script>
    @stack('scripts')
</body>
</html>
