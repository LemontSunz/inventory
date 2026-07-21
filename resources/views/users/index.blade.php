@extends('layouts.app')

@section('title', 'Kelola Pengguna - Inventory SaaS')

@section('content')
<div class="space-y-4 max-w-screen-2xl w-full mx-auto px-6 sm:px-8 lg:px-10 xl:px-12">
    <x-page-header
        category="Pengguna"
        title="Kelola Pengguna"
        description="Buat, edit, dan hapus akun manager atau admin gudang."
    >
        <x-slot:actionButton>
            <a href="{{ route('users.create') }}" class="group inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pengguna
            </a>
        </x-slot:actionButton>
    </x-page-header>

    @if (session('success'))
        <div class="rounded-lg border border-green-300 bg-green-50 p-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="rounded-lg border border-red-300 bg-red-50 p-4 text-red-700">
            {{ session('error') }}
        </div>
    @endif

<x-table.table-wrapper title="Tabel Pengguna" description="Daftar akun manager dan admin gudang." :count="$users->total()">
        <table class="table-standard text-sm text-left divide-y divide-gray-200 min-w-full">
            <thead>
                <tr>
                    <x-table.table-header label="Nama" align="left" class="px-6 py-4 font-semibold text-gray-900" :sortable="true" sort-route="users.index" column="name" :current-sort="$sort" :direction="$direction" />
                    <x-table.table-header label="Email" align="left" class="px-6 py-4 font-semibold text-gray-900" :sortable="true" sort-route="users.index" column="email" :current-sort="$sort" :direction="$direction" />
                    <x-table.table-header label="Peran" align="center" class="px-6 py-4 font-semibold text-gray-900" :sortable="true" sort-route="users.index" column="role" :current-sort="$sort" :direction="$direction" />
                    <x-table.table-header label="Dibuat" align="center" class="table-col-date px-6 py-4 font-semibold text-gray-900" :sortable="true" sort-route="users.index" column="created_at" :current-sort="$sort" :direction="$direction" />
                    <x-table.table-header label="Aksi" align="center" class="table-col-actions px-6 py-4 font-semibold text-gray-900" />
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($users as $user)
                    <x-table.table-row>
                        <x-table.table-cell align="left" class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</x-table.table-cell>
                        <x-table.table-cell align="left" class="px-6 py-4 text-gray-600">{{ $user->email }}</x-table.table-cell>
                        <x-table.table-cell align="center" class="px-6 py-4 text-gray-600">{{ $user->role === 'manager' ? 'Manager' : 'Admin Gudang' }}</x-table.table-cell>
                        <x-table.table-cell align="center" class="table-col-date px-6 py-4 text-gray-500">{{ $user->created_at->format('d M Y') }}</x-table.table-cell>
                        <x-table.table-cell align="center" class="table-col-actions px-6 py-4">
                            @if(auth()->user()->role === 'admin_gudang')
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('users.edit', $user) }}" class="rounded-lg bg-slate-100 px-3 py-1 text-sm text-slate-700 hover:bg-slate-200 cursor-pointer">Edit</a>
                                    @if(auth()->id() !== $user->id)
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg bg-red-50 px-3 py-1 text-sm text-red-700 hover:bg-red-100 cursor-pointer">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            @else
                                <span class="text-slate-500">Hanya lihat</span>
                            @endif
                        </x-table.table-cell>
                    </x-table.table-row>
                @endforeach
            </tbody>
        </table>

        <div class="border-t border-gray-200 px-6 py-4">
            {{ $users->links() }}
        </div>
    </x-table.table-wrapper>
</div>
@endsection
