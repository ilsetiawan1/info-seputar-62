@extends('layouts.admin')

@section('title', 'Profil Saya')

@section('content')
<style>
    .profile-card {
        background: #141414;
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 20px;
        padding: 2.5rem;
        position: relative;
        overflow: hidden;
    }
    
    .profile-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, #f97316, #ea580c, #f97316);
        background-size: 200% auto;
        animation: gradientSweep 3s linear infinite;
    }

    @keyframes gradientSweep {
        0% { background-position: 0% center; }
        100% { background-position: 200% center; }
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
    
    .btn-danger {
        background: transparent;
        color: #ef4444;
        border: 1px solid rgba(239,68,68,0.3);
        transition: all 0.2s;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 700;
    }
    .btn-danger:hover { background: rgba(239,68,68,0.1); border-color: #ef4444; }
</style>

<div class="max-w-4xl mx-auto space-y-8">
    <div class="flex items-center gap-6 mb-8">
        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-bold text-3xl shadow-[0_0_30px_rgba(249,115,22,0.3)]">
            {{ substr($user->name, 0, 1) }}
        </div>
        <div>
            <h1 class="text-3xl font-bold text-white font-display mb-1">{{ $user->name }}</h1>
            <div class="flex items-center gap-3 text-sm">
                <span class="text-gray-400">{{ $user->email }}</span>
                <span class="w-1.5 h-1.5 rounded-full bg-gray-600"></span>
                <span class="text-orange-400 font-bold uppercase tracking-wider text-xs px-2 py-0.5 rounded bg-orange-500/10">{{ $user->role }}</span>
            </div>
        </div>
    </div>

    <!-- Informasi Profil & Password -->
    <div class="profile-card">
        <div class="mb-8 border-b border-white/10 pb-6">
            <h2 class="text-xl font-bold text-white mb-2">Informasi Dasar & Password</h2>
            <p class="text-sm text-gray-400">Perbarui nama, alamat email, dan password akun Anda.</p>
        </div>

        <form method="post" action="{{ route('admin.profile.update') }}" class="space-y-8">
            @csrf
            @method('patch')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Kolom Kiri: Info Dasar -->
                <div class="space-y-5">
                    <h3 class="text-sm font-bold text-gray-300 uppercase tracking-wider mb-4">Profil</h3>
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-400 mb-2">Nama Lengkap</label>
                        <input id="name" name="name" type="text" class="input-field" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                        @error('name')
                            <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-400 mb-2">Alamat Email</label>
                        <input id="email" name="email" type="email" class="input-field" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                        @error('email')
                            <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                        @enderror

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="mt-3 p-3 rounded-xl bg-orange-500/10 border border-orange-500/20">
                                <p class="text-sm text-orange-400">
                                    Alamat email Anda belum diverifikasi.
                                    <button form="send-verification" class="underline text-sm text-white hover:text-orange-400 rounded-md focus:outline-none">
                                        Klik di sini untuk mengirim ulang email verifikasi.
                                    </button>
                                </p>
                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 font-medium text-sm text-green-400">Tautan verifikasi baru telah dikirim ke alamat email Anda.</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Kolom Kanan: Password -->
                <div class="space-y-5">
                    <h3 class="text-sm font-bold text-gray-300 uppercase tracking-wider mb-4">Ubah Password</h3>
                    
                    <div>
                        <label for="update_password_current_password" class="block text-sm font-medium text-gray-400 mb-2">Password Saat Ini</label>
                        <input id="update_password_current_password" name="current_password" type="password" class="input-field" autocomplete="current-password" placeholder="Hanya jika ingin mengubah password" />
                        @error('current_password')
                            <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="update_password_password" class="block text-sm font-medium text-gray-400 mb-2">Password Baru</label>
                        <input id="update_password_password" name="password" type="password" class="input-field" autocomplete="new-password" />
                        @error('password')
                            <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-400 mb-2">Konfirmasi Password Baru</label>
                        <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="input-field" autocomplete="new-password" />
                        @error('password_confirmation')
                            <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4 pt-6 border-t border-white/10">
                <button type="submit" class="btn-submit">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Hapus Akun -->
    <div class="profile-card border-red-500/20">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-red-500 mb-2">Hapus Akun</h2>
            <p class="text-sm text-gray-400">Setelah akun Anda dihapus, semua data dan artikel terkait akan dihapus secara permanen. Harap berhati-hati.</p>
        </div>

        <form method="post" action="{{ route('admin.profile.destroy') }}" class="space-y-6" onsubmit="return confirm('Tindakan ini tidak dapat dibatalkan. Apakah Anda yakin ingin menghapus akun Anda?');">
            @csrf
            @method('delete')

            <div class="max-w-xl">
                <label for="password_delete" class="block text-sm font-medium text-gray-400 mb-2">Masukkan Password untuk Konfirmasi</label>
                <input id="password_delete" name="password" type="password" class="input-field border-red-500/30 focus:border-red-500 focus:ring-red-500/20" required placeholder="Password Anda" />
                @error('password', 'userDeletion')
                    <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-danger">
                Hapus Akun Secara Permanen
            </button>
        </form>
    </div>
</div>

<form id="send-verification" method="post" action="{{ route('verification.send') }}" class="hidden">
    @csrf
</form>
@endsection
