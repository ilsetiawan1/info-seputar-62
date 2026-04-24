<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" style="background-color: var(--color-dark-900); color: var(--color-dark-50);">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0" style="background: linear-gradient(135deg, var(--color-dark-800), var(--color-dark-900));">
            <div>
                <a href="/" style="display:flex; align-items:center; gap:0.5rem; text-decoration:none;">
                    <div style="width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;background:var(--color-brand-500);">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>
                    </div>
                    <span style="font-family:var(--font-display);font-weight:700;color:white;font-size:1.5rem;line-height:1;">
                        Info<br><span style="color:var(--color-brand-400);">Seputar</span>
                    </span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 overflow-hidden sm:rounded-lg" style="background-color: var(--color-dark-800); border: 1px solid var(--color-dark-600); box-shadow: 0 10px 25px rgba(0,0,0,0.5);">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
