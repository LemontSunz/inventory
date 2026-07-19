@extends('layouts.app')

@section('title', 'Tambah Pengguna - Inventory SaaS')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Tambah Pengguna</h2>
            <p class="mt-2 text-gray-600">Tambahkan akun manager atau admin gudang baru.</p>
        </div>
        <a href="{{ route('users.index') }}" class="group inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 transition cursor-pointer">Kembali</a>
    </div>

    <div class="rounded-xl bg-white p-6 shadow-sm border border-gray-200">
        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-red-300 bg-red-50 p-4 text-sm text-red-700">
                <strong class="block font-semibold text-red-800">Terjadi kesalahan:</strong>
                <ul class="mt-2 list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="mt-2 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-sky-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-100" />
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="mt-2 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-sky-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-100" />
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Peran</label>
                <select name="role" required class="mt-2 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-sky-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-100">
                    <option value="manager" {{ old('role') === 'manager' ? 'selected' : '' }}>Manager</option>
                    <option value="admin_gudang" {{ old('role') === 'admin_gudang' ? 'selected' : '' }}>Admin Gudang</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Password</label>
                <input type="password" name="password" required class="mt-2 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-sky-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-100" />
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required class="mt-2 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-sky-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-100" />
                @error('password_confirmation')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="group inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition cursor-pointer">Simpan Pengguna</button>
        </form>
    </div>
</div>
@endsection
