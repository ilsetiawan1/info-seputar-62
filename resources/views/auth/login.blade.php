<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Info Seputar +62</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            min-height: 100vh;
            background: #0a0a0a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Plus Jakarta Sans', sans-serif;
            padding: 1.5rem;
        }
        .auth-card {
            width: 100%;
            max-width: 420px;
            background: #141414;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            padding: 2.5rem 2rem;
        }
        .auth-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.625rem;
            text-decoration: none;
            margin-bottom: 2rem;
        }
        .auth-logo-icon {
            width: 40px; height: 40px;
            background: var(--color-brand-500, #f97316);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .auth-logo-text {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.375rem;
            color: white;
        }
        .auth-logo-text span { color: var(--color-brand-400, #fb923c); }
        .auth-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: white;
            text-align: center;
            margin-bottom: 0.375rem;
        }
        .auth-sub {
            font-size: 0.8125rem;
            color: #888;
            text-align: center;
            margin-bottom: 1.75rem;
        }
        .form-group { margin-bottom: 1.125rem; }
        label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #ccc;
            margin-bottom: 0.4rem;
        }
        input[type=email], input[type=password], input[type=text] {
            width: 100%;
            background: #1e1e1e;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 8px;
            padding: 0.65rem 0.875rem;
            font-size: 0.9rem;
            color: white;
            outline: none;
            transition: border-color .2s;
            font-family: inherit;
        }
        input:focus { border-color: var(--color-brand-500, #f97316); }
        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .remember-label {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.8125rem;
            color: #999;
            cursor: pointer;
            margin: 0;
        }
        .remember-label input[type=checkbox] {
            width: 15px; height: 15px;
            accent-color: var(--color-brand-500, #f97316);
        }
        .link-muted {
            font-size: 0.8125rem;
            color: #888;
            text-decoration: none;
            transition: color .2s;
        }
        .link-muted:hover { color: var(--color-brand-400, #fb923c); }
        .btn-primary {
            width: 100%;
            padding: 0.7rem;
            background: var(--color-brand-500, #f97316);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.9375rem;
            font-weight: 700;
            cursor: pointer;
            font-family: inherit;
            transition: background .2s;
        }
        .btn-primary:hover { background: var(--color-brand-600, #ea580c); }
        .auth-footer {
            text-align: center;
            margin-top: 1.25rem;
            font-size: 0.8125rem;
            color: #888;
        }
        .auth-footer a {
            color: var(--color-brand-400, #fb923c);
            font-weight: 600;
            text-decoration: none;
        }
        .auth-footer a:hover { text-decoration: underline; }
        .alert-error {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.3);
            border-radius: 8px;
            padding: 0.625rem 0.875rem;
            font-size: 0.8125rem;
            color: #f87171;
            margin-bottom: 1rem;
        }
        .field-error {
            font-size: 0.75rem;
            color: #f87171;
            margin-top: 0.35rem;
        }
        .status-success {
            background: rgba(34,197,94,0.1);
            border: 1px solid rgba(34,197,94,0.3);
            border-radius: 8px;
            padding: 0.625rem 0.875rem;
            font-size: 0.8125rem;
            color: #4ade80;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <a href="{{ route('home') }}" class="auth-logo">
            <div class="auth-logo-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>
            </div>
            <div class="auth-logo-text">Info<span>Seputar</span> +62</div>
        </a>

        <p class="auth-title">Selamat Datang Kembali</p>
        <p class="auth-sub">Masuk ke akun redaksi Anda</p>

        @if(session('status'))
            <div class="status-success">{{ session('status') }}</div>
        @endif

        @if($errors->any())
            <div class="alert-error">Email atau password salah.</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nama@email.com">
                @error('email') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                @error('password') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-row">
                <label class="remember-label">
                    <input type="checkbox" name="remember" id="remember_me">
                    Ingat saya
                </label>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="link-muted">Lupa password?</a>
                @endif
            </div>

            <button type="submit" class="btn-primary">Masuk</button>
        </form>

        <p class="auth-footer">
            Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
        </p>
    </div>
</body>
</html>