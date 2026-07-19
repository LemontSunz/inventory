@extends('layouts.app')

@section('title', 'Kelola Pengguna - Inventory SaaS')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Kelola Pengguna</h2>
            <p class="mt-2 text-gray-600">Buat, edit, dan hapus akun manager atau admin gudang.</p>
        </div>
        <a href="{{ route('users.create') }}" class="group inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 transition cursor-pointer">
            Tambah Pengguna
        </a>
    </div>

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

    <div class="overflow-hidden rounded-xl bg-white shadow-sm border border-gray-200">
        <div class="mt-6 table-standard-wrapper rounded-xl">
            <table class="table-standard text-sm text-left divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-gray-900 whitespace-nowrap">
                            @php
                                $isSorted = $sort === 'name';
                                $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                $params = array_merge(request()->query(), ['sort' => 'name', 'direction' => $nextDirection]);
                            @endphp
                            <a href="{{ route('users.index', $params) }}" class="group inline-flex items-center gap-2 cursor-pointer hover:text-gray-600 transition">
                                Nama
                                <span class="inline-flex items-center">
                                        @if($isSorted)
                                            @if($direction === 'asc')
                                                <svg class="h-4 w-4 text-gray-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 15.21a.75.75 0 001.06.02L12 10.56l5.71 4.67a.75.75 0 001.06-1.06l-6.24-5.11a.75.75 0 00-1.06 0L5.23 14.15a.75.75 0 00.02 1.06z" clip-rule="evenodd"/></svg>
                                            @else
                                                <svg class="h-4 w-4 text-gray-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                            @endif
                                        @else
                                            <svg class="h-4 w-4 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                        @endif
                                    </span>
                            </a>
                        </th>
                        <th class="px-6 py-4 font-semibold text-gray-900">
                            @php
                                $isSorted = $sort === 'email';
                                $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                $params = array_merge(request()->query(), ['sort' => 'email', 'direction' => $nextDirection]);
                            @endphp
                            <a href="{{ route('users.index', $params) }}" class="group inline-flex items-center gap-2 cursor-pointer hover:text-gray-600 transition">
                                Email
                                <span class="inline-flex items-center">
                                        @if($isSorted)
                                            @if($direction === 'asc')
                                                <svg class="h-4 w-4 text-gray-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 15.21a.75.75 0 001.06.02L12 10.56l5.71 4.67a.75.75 0 001.06-1.06l-6.24-5.11a.75.75 0 00-1.06 0L5.23 14.15a.75.75 0 00.02 1.06z" clip-rule="evenodd"/></svg>
                                            @else
                                                <svg class="h-4 w-4 text-gray-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                            @endif
                                        @else
                                            <svg class="h-4 w-4 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                        @endif
                                    </span>
                            </a>
                        </th>
                        <th class="px-6 py-4 font-semibold text-gray-900">
                            @php
                                $isSorted = $sort === 'role';
                                $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                $params = array_merge(request()->query(), ['sort' => 'role', 'direction' => $nextDirection]);
                            @endphp
                            <a href="{{ route('users.index', $params) }}" class="group inline-flex items-center gap-2 cursor-pointer hover:text-gray-600 transition">
                                Peran
                                <span class="inline-flex items-center">
                                        @if($isSorted)
                                            @if($direction === 'asc')
                                                <svg class="h-4 w-4 text-gray-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 15.21a.75.75 0 001.06.02L12 10.56l5.71 4.67a.75.75 0 001.06-1.06l-6.24-5.11a.75.75 0 00-1.06 0L5.23 14.15a.75.75 0 00.02 1.06z" clip-rule="evenodd"/></svg>
                                            @else
                                                <svg class="h-4 w-4 text-gray-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                            @endif
                                        @else
                                            <svg class="h-4 w-4 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                        @endif
                                    </span>
                            </a>
                        </th>
                        <th class="table-col-date px-6 py-4 font-semibold text-gray-900">
                            @php
                                $isSorted = $sort === 'created_at';
                                $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                $params = array_merge(request()->query(), ['sort' => 'created_at', 'direction' => $nextDirection]);
                            @endphp
                            <a href="{{ route('users.index', $params) }}" class="group inline-flex items-center gap-2 cursor-pointer hover:text-gray-600 transition">
                                Dibuat
                                <span class="inline-flex items-center">
                                        @if($isSorted)
                                            @if($direction === 'asc')
                                                <svg class="h-4 w-4 text-gray-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 15.21a.75.75 0 001.06.02L12 10.56l5.71 4.67a.75.75 0 001.06-1.06l-6.24-5.11a.75.75 0 00-1.06 0L5.23 14.15a.75.75 0 00.02 1.06z" clip-rule="evenodd"/></svg>
                                            @else
                                                <svg class="h-4 w-4 text-gray-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                            @endif
                                        @else
                                            <svg class="h-4 w-4 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                        @endif
                                    </span>
                            </a>
                        </th>
                        <th class="table-col-actions px-6 py-4 font-semibold text-gray-900">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($users as $user)
                        <tr>
                            <td class="px-6 py-4 text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->role === 'manager' ? 'Manager' : 'Admin Gudang' }}</td>
                            <td class="table-col-date px-6 py-4 text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="table-col-actions px-6 py-4">
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
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="border-t border-gray-200 px-6 py-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
