@extends('layouts.admin')

@section('title', 'Kelola User')

@section('content')

<style>
    .admin-card {
        background: #141414;
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 20px;
        overflow: hidden;
    }
    
    .table-row {
        transition: background 0.2s;
    }
    .table-row:hover {
        background: rgba(255,255,255,0.02);
    }

    .filter-btn {
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-size: 0.8125rem;
        font-weight: 600;
        transition: all 0.2s;
        border: 1px solid transparent;
    }
    .filter-btn.active-all { background: rgba(255,255,255,0.1); color: white; border-color: rgba(255,255,255,0.2); }
    .filter-btn.active-admin { background: rgba(239,68,68,0.15); color: #f87171; border-color: rgba(239,68,68,0.3); }
    .filter-btn.active-editor { background: rgba(234,179,8,0.15); color: #eab308; border-color: rgba(234,179,8,0.3); }
    .filter-btn.active-writer { background: rgba(59,130,246,0.15); color: #60a5fa; border-color: rgba(59,130,246,0.3); }
    .filter-btn.active-user { background: rgba(34,197,94,0.15); color: #4ade80; border-color: rgba(34,197,94,0.3); }
    .filter-btn:not([class*="active-"]):hover { background: rgba(255,255,255,0.05); color: white; }

    .btn-action-primary {
        background: linear-gradient(135deg, #f97316, #ea580c);
        color: white;
        border: none;
        box-shadow: 0 4px 15px rgba(249,115,22,0.3);
        transition: all 0.2s;
    }
    .btn-action-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(249,115,22,0.4); }
    
    .btn-action-outline {
        background: rgba(255,255,255,0.05);
        color: #e5e5e5;
        border: 1px solid rgba(255,255,255,0.1);
        transition: all 0.2s;
    }
    .btn-action-outline:hover { background: rgba(255,255,255,0.1); color: white; border-color: rgba(255,255,255,0.2); }
    
    .btn-action-danger {
        background: transparent;
        color: #f87171;
        border: 1px solid rgba(248,113,113,0.3);
        transition: all 0.2s;
    }
    .btn-action-danger:hover { background: rgba(248,113,113,0.1); border-color: #f87171; }
    
    .badge-role {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }
    .badge-admin { background: rgba(239,68,68,0.1); color: #f87171; border: 1px solid rgba(239,68,68,0.2); }
    .badge-editor { background: rgba(234,179,8,0.1); color: #eab308; border: 1px solid rgba(234,179,8,0.2); }
    .badge-writer { background: rgba(59,130,246,0.1); color: #60a5fa; border: 1px solid rgba(59,130,246,0.2); }
    .badge-user { background: rgba(34,197,94,0.1); color: #4ade80; border: 1px solid rgba(34,197,94,0.2); }
</style>

<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white font-display mb-1">Manajemen Pengguna</h1>
            <p class="text-sm text-gray-400">Kelola akun dan hak akses pengguna di portal</p>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2.5 btn-action-primary text-sm font-bold rounded-xl whitespace-nowrap">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                Tambah Pengguna
            </a>
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-2 p-1.5 bg-[#141414] rounded-xl border border-white/5 inline-flex mb-2">
        <a href="{{ route('admin.users.index') }}" class="filter-btn {{ !$role || $role === 'all' ? 'active-all' : 'text-gray-400' }}">
            Semua
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" class="filter-btn {{ $role === 'admin' ? 'active-admin' : 'text-gray-400' }}">
            Admin
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'editor']) }}" class="filter-btn {{ $role === 'editor' ? 'active-editor' : 'text-gray-400' }}">
            Editor
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'writer']) }}" class="filter-btn {{ $role === 'writer' ? 'active-writer' : 'text-gray-400' }}">
            Writer
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'user']) }}" class="filter-btn {{ $role === 'user' ? 'active-user' : 'text-gray-400' }}">
            User Biasa
        </a>
    </div>

    <div class="admin-card">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-black/20 text-gray-400 text-xs font-bold uppercase tracking-widest border-b border-white/5">
                        <th class="px-8 py-4">Pengguna</th>
                        <th class="px-8 py-4">Hak Akses (Role)</th>
                        <th class="px-8 py-4">Tgl Bergabung</th>
                        <th class="px-8 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($users as $user)
                    <tr class="table-row">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-orange-500/20">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-white mb-0.5">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            @if($user->role === 'admin')
                            <span class="badge-role badge-admin">Admin</span>
                            @elseif($user->role === 'editor')
                            <span class="badge-role badge-editor">Editor</span>
                            @elseif($user->role === 'writer')
                            <span class="badge-role badge-writer">Writer</span>
                            @else
                            <span class="badge-role badge-user">User</span>
                            @endif
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-sm font-medium text-gray-400">
                                {{ $user->created_at->format('d M Y') }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="inline-flex items-center px-3 py-1.5 btn-action-outline text-xs font-bold rounded-lg">
                                    Edit
                                </a>
                                
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini secara permanen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 btn-action-danger text-xs font-bold rounded-lg">
                                        Hapus
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 mb-4 rounded-full bg-white/5 flex items-center justify-center text-gray-500">
                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                </div>
                                <h3 class="text-lg font-bold text-white mb-1">Data Kosong</h3>
                                <p class="text-sm text-gray-500">Belum ada pengguna yang ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
        <div class="px-8 py-5 border-t border-white/5 bg-black/20">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
