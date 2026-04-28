@extends('layouts.admin')

@section('title', 'Tambah Pengguna')

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
    
    select.input-field {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
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
        <a href="{{ route('admin.users.index') }}" class="flex items-center justify-center w-10 h-10 rounded-full bg-white/5 text-gray-400 hover:text-white hover:bg-white/10 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white font-display mb-1">Tambah Pengguna</h1>
            <p class="text-sm text-gray-400">Buat akun baru dan tentukan hak aksesnya</p>
        </div>
    </div>

    <div class="form-card">
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-bold text-gray-300 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="input-field" placeholder="Masukkan nama lengkap...">
                    @error('name')
                    <p class="text-sm text-red-500 mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-300 mb-2">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required class="input-field" placeholder="contoh@email.com">
                    @error('email')
                    <p class="text-sm text-red-500 mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="role" class="block text-sm font-bold text-gray-300 mb-2">Hak Akses (Role)</label>
                <select name="role" id="role" required class="input-field">
                    <option value="" disabled selected>-- Pilih Hak Akses --</option>
                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User Biasa (Hanya Membaca & Komentar)</option>
                    <option value="writer" {{ old('role') === 'writer' ? 'selected' : '' }}>Writer (Menulis Artikel ke Draft)</option>
                    <option value="editor" {{ old('role') === 'editor' ? 'selected' : '' }}>Editor (Review & Terbitkan Artikel)</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin (Akses Penuh)</option>
                </select>
                @error('role')
                <p class="text-sm text-red-500 mt-2 font-medium">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                <div>
                    <label for="password" class="block text-sm font-bold text-gray-300 mb-2">Password</label>
                    <input type="password" name="password" id="password" required class="input-field" placeholder="Minimal 8 karakter">
                    @error('password')
                    <p class="text-sm text-red-500 mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-300 mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required class="input-field" placeholder="Ketik ulang password">
                </div>
            </div>

            <div class="flex justify-end pt-6 border-t border-white/10 mt-6">
                <button type="submit" class="btn-submit inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    Simpan Pengguna
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
