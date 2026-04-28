@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
<style>
    .form-card {
        background: #141414;
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 20px;
        padding: 2rem;
    }
    
    .input-field {
        width: 100%;
        background: #1e1e1e;
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 12px;
        padding: 0.875rem 1rem;
        color: white;
        outline: none;
        transition: all 0.2s;
    }
    .input-field:focus {
        border-color: #f97316;
        box-shadow: 0 0 0 3px rgba(249,115,22,0.15);
    }

    .btn-submit {
        background: linear-gradient(135deg, #f97316, #ea580c);
        color: white;
        border: none;
        box-shadow: 0 4px 15px rgba(249,115,22,0.3);
        transition: all 0.2s;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 700;
    }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(249,115,22,0.4); }
</style>

<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.categories.index') }}" class="flex items-center justify-center w-10 h-10 rounded-full bg-white/5 text-gray-400 hover:text-white hover:bg-white/10 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white font-display mb-1">Edit Kategori</h1>
            <p class="text-sm text-gray-400">Ubah detail kategori terpilih</p>
        </div>
    </div>

    <div class="form-card">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="name" class="block text-sm font-bold text-gray-300 mb-2">Nama Kategori</label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required autofocus class="input-field" placeholder="Masukkan nama kategori...">
                @error('name')
                <p class="text-sm text-red-500 mt-2 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="btn-submit inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
