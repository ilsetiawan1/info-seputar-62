@extends('layouts.admin')

@section('title', 'Tag')

@section('content')

<style>
    .admin-card {
        background: #141414;
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 20px;
        overflow: hidden;
        margin-top: 1rem;
    }
    
    .table-row {
        transition: background 0.2s;
    }
    .table-row:hover {
        background: rgba(255,255,255,0.03);
    }

    /* Padding baris tabel agar tidak sesak saat dibaca */
    .table-row td {
        padding-top: 1.25rem;
        padding-bottom: 1.25rem;
        padding-left: 2rem;
        padding-right: 2rem;
    }

    .admin-card thead th {
        padding-top: 1.25rem;
        padding-bottom: 1.25rem;
        padding-left: 2rem;
        padding-right: 2rem;
    }

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

    .main-content-wrapper {
        padding-left: 2.5rem;
        padding-right: 1.5rem;
        padding-top: 1.5rem;
        padding-bottom: 2rem;
    }
</style>

<div class="main-content-wrapper">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white font-display mb-1">Manajemen Tag</h1>
            <p class="text-sm text-gray-500">Atur label tag untuk pengelompokan artikel spesifik</p>
        </div>
        <a href="{{ route('admin.tags.create') }}" class="inline-flex items-center px-4 py-2.5 btn-action-primary text-sm font-bold rounded-xl whitespace-nowrap shadow-lg">
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Tag
        </a>
    </div>

    <div class="admin-card shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[600px]">
                <thead>
                    <tr class="bg-black/20 text-gray-500 text-[11px] font-black uppercase tracking-widest border-b border-white/5">
                        <th>Nama Tag</th>
                        <th>Slug</th>
                        <th class="text-center">Jumlah Artikel</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($tags as $tag)
                    <tr class="table-row">
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-orange-500/10 flex items-center justify-center text-orange-400">
                                    <span class="font-bold text-lg leading-none">#</span>
                                </div>
                                <span class="font-bold text-white">{{ $tag->name }}</span>
                            </div>
                        </td>
                        <td class="text-sm text-gray-400">
                            {{ $tag->slug }}
                        </td>
                        <td class="text-center">
                            <span class="inline-flex items-center justify-center bg-white/5 text-gray-300 font-bold text-[11px] px-3.5 py-1.5 rounded-lg border border-white/5">
                                {{ $tag->posts_count }}
                            </span>
                        </td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.tags.edit', $tag->id) }}" class="inline-flex items-center px-4 py-1.5 btn-action-outline text-[11px] font-bold rounded-lg uppercase tracking-wider">
                                    Edit
                                </a>
                                
                                <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tag ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-1.5 btn-action-danger text-[11px] font-bold rounded-lg uppercase tracking-wider">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 mb-4 rounded-full bg-white/5 flex items-center justify-center text-gray-500">
                                    <span class="font-bold text-3xl leading-none">#</span>
                                </div>
                                <h3 class="text-lg font-bold text-white mb-1">Belum Ada Tag</h3>
                                <p class="text-sm text-gray-500 mb-4">Mulai dengan menambahkan tag baru.</p>
                                <a href="{{ route('admin.tags.create') }}" class="inline-flex items-center px-4 py-2 bg-white/10 hover:bg-white/20 text-white text-sm font-bold rounded-lg transition-colors">
                                    Tambah Tag
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($tags->hasPages())
        <div class="px-8 py-5 border-t border-white/5 bg-black/20">
            {{ $tags->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
