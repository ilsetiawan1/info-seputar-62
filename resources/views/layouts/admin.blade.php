<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel') | Info Seputar +62</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,700;0,800;1,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            background-color: #0a0a0a;
            color: #e5e5e5;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        .admin-sidebar {
            background-color: #141414;
            border-right: 1px solid rgba(255,255,255,0.05);
        }
        
        .admin-header {
            background-color: rgba(10,10,10,0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 600;
            color: #a3a3a3;
            transition: all 0.3s ease;
            text-decoration: none;
            margin-bottom: 0.25rem;
        }

        .nav-item:hover {
            color: #fff;
            background-color: rgba(255,255,255,0.03);
            transform: translateX(4px);
        }

        .nav-item.active {
            color: #f97316;
            background: linear-gradient(90deg, rgba(249,115,22,0.15) 0%, rgba(249,115,22,0.05) 100%);
            border-left: 3px solid #f97316;
        }

        .nav-item.active svg {
            color: #f97316;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #f97316, #ea580c);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 1rem;
            box-shadow: 0 4px 12px rgba(249,115,22,0.3);
        }

        /* Custom Scrollbar for sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #333;
            border-radius: 4px;
        }
        .sidebar-scroll:hover::-webkit-scrollbar-thumb {
            background: #555;
        }
    </style>
</head>
<body class="antialiased h-screen overflow-hidden flex">
    
    {{-- Mobile Sidebar Backdrop --}}
    <div id="sidebar-backdrop" class="fixed inset-0 z-40 hidden bg-black/60 backdrop-blur-sm md:hidden transition-opacity" aria-hidden="true"></div>

    {{-- Sidebar --}}
    <aside id="sidebar" class="flex-shrink-0 fixed inset-y-0 left-0 z-50 flex flex-col w-[280px] admin-sidebar transition-transform duration-300 transform -translate-x-full md:relative md:translate-x-0 shadow-2xl md:shadow-none">
        
        <div class="flex items-center justify-between h-20 px-8 border-b border-white/5">
            <a href="{{ route('home') }}" class="flex items-center gap-4 no-underline group">
                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-orange-400 to-orange-600 shadow-[0_0_20px_rgba(249,115,22,0.4)] group-hover:scale-105 transition-transform">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>
                </div>
                <span class="text-2xl font-bold text-white font-display tracking-wide">Info<span class="text-orange-500">62</span></span>
            </a>
            <button id="close-sidebar" class="p-2 text-gray-400 rounded-lg md:hidden hover:text-white hover:bg-white/5 transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="px-8 py-5">
            <div class="text-xs font-bold tracking-widest text-gray-500 uppercase">Menu Utama</div>
        </div>

        <nav class="flex-1 px-5 sidebar-scroll overflow-y-auto space-y-1.5 pb-6">
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="w-5 h-5 mr-3.5 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            
            <a href="{{ route('admin.posts.index') }}" class="nav-item {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 mr-3.5 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                Artikel
            </a>

            <a href="{{ route('admin.categories.index') }}" class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 mr-3.5 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                Kategori
            </a>

            <a href="{{ route('admin.tags.index') }}" class="nav-item {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 mr-3.5 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>
                Tag
            </a>

            @if(auth()->user()->role === 'admin')
            <div class="pt-6 pb-3 px-3">
                <div class="text-xs font-bold tracking-widest text-gray-500 uppercase">Administrator</div>
            </div>
            
            <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 mr-3.5 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Kelola User
            </a>
            @endif

            <div class="pt-6 pb-3 px-3">
                <div class="text-xs font-bold tracking-widest text-gray-500 uppercase">Pengaturan</div>
            </div>

            <a href="{{ route('admin.profile.edit') }}" class="nav-item {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 mr-3.5 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Profil Saya
            </a>
        </nav>

        <div class="p-5 border-t border-white/5 bg-black/20">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-3.5 text-sm font-bold text-gray-400 bg-white/5 border border-white/5 rounded-xl hover:text-white hover:bg-red-500/10 hover:border-red-500/20 transition-all group">
                    <svg class="w-5 h-5 mr-3 text-gray-500 group-hover:text-red-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span class="group-hover:text-red-400 transition-colors">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="flex flex-col flex-1 min-w-0 h-screen bg-[#050505] overflow-hidden">
        {{-- Top Navbar --}}
        <header class="admin-header flex-shrink-0 flex items-center justify-between h-20 px-8 lg:px-12 xl:px-16 z-30 shadow-sm">
            <div class="flex items-center gap-4 md:hidden">
                <button id="open-sidebar" class="p-2 -ml-2 text-gray-300 rounded-lg hover:text-white hover:bg-white/10 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
            
            <div class="hidden md:flex flex-col">
                <h2 class="text-sm font-medium text-gray-400">Selamat Datang,</h2>
                <h1 class="text-xl font-bold text-white tracking-wide">{{ auth()->user()->name }}</h1>
            </div>
            
            <div class="flex items-center ml-auto gap-6">
                <button class="relative p-2.5 text-gray-400 hover:text-white bg-white/5 hover:bg-white/10 rounded-full transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 rounded-full border-2 border-[#141414]"></span>
                </button>
                
                <div class="h-10 w-px bg-white/10 mx-1"></div>
                
                <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-4 cursor-pointer group no-underline">
                    <div class="hidden sm:block text-right">
                        <div class="text-sm font-bold text-white group-hover:text-orange-400 transition-colors">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-gray-500 capitalize tracking-wider font-semibold">{{ auth()->user()->role }}</div>
                    </div>
                    <div class="user-avatar shadow-[0_0_15px_rgba(249,115,22,0.3)] group-hover:scale-105 transition-transform">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </a>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto p-8 lg:p-12 xl:p-16">
            <div class="max-w-[1600px] mx-auto w-full">
                {{-- Flash Messages --}}
                @if(session('success'))
                <div class="p-4 mb-8 text-green-400 bg-green-500/10 border border-green-500/20 rounded-2xl flex items-center shadow-lg shadow-green-500/5">
                    <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center mr-4 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="font-medium text-sm">{{ session('success') }}</p>
                </div>
                @endif
                
                @if(session('error'))
                <div class="p-4 mb-8 text-red-400 bg-red-500/10 border border-red-500/20 rounded-2xl flex items-center shadow-lg shadow-red-500/5">
                    <div class="w-8 h-8 rounded-full bg-red-500/20 flex items-center justify-center mr-4 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                    <p class="font-medium text-sm">{{ session('error') }}</p>
                </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            const openBtn = document.getElementById('open-sidebar');
            const closeBtn = document.getElementById('close-sidebar');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
                setTimeout(() => backdrop.classList.add('opacity-100'), 10);
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.remove('opacity-100');
                setTimeout(() => backdrop.classList.add('hidden'), 300);
            }

            openBtn?.addEventListener('click', openSidebar);
            closeBtn?.addEventListener('click', closeSidebar);
            backdrop?.addEventListener('click', closeSidebar);
        });
    </script>
    @stack('scripts')
</body>
</html>
