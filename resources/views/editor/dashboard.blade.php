@extends('layouts.app')

@section('title', 'Editor Dashboard')

@section('content')
<section class="container-site" style="padding-top:3rem;padding-bottom:3rem;min-height:50vh;">
    <div class="card" style="padding:2rem;">
        <h1 class="font-display" style="font-size:2rem;font-weight:700;color:white;margin-bottom:1rem;">Dashboard Editor</h1>
        <p class="prose-content">Selamat datang, {{ auth()->user()->name }}. Ini adalah halaman khusus Editor (Phase 6 Preparation).</p>
        
        <form method="POST" action="{{ route('logout') }}" style="margin-top:2rem;">
            @csrf
            <button type="submit" class="btn btn-outline" style="color:var(--color-brand-400);border-color:var(--color-brand-400);">Logout</button>
        </form>
    </div>
</section>
@endsection
