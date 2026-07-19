@extends('layouts.app')

@section('title', 'Profil Saya - LogistikPro')

@section('content')
<div class="space-y-6 max-w-screen-2xl w-full mx-auto px-6 sm:px-8 lg:px-10 xl:px-12">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Akun</p>
            <h1 class="mt-2 text-4xl font-bold tracking-tight text-slate-900">Profil Saya</h1>
            <p class="mt-3 max-w-2xl text-base leading-7 text-slate-600">Perbarui informasi akun dan keamanan login Anda.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-10">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Informasi Akun</h2>
                    <p class="mt-1 text-sm text-slate-500">Ubah nama dan alamat email Anda. Role hanya dapat dilihat dan tidak dapat diubah dari halaman ini.</p>
                </div>

                <div class="grid gap-4 lg:grid-cols-2">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="mt-2 block w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-slate-100" />
                        @error('name')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="mt-2 block w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-slate-100" />
                        @error('email')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="lg:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700">Role</label>
                        <input type="text" value="{{ $user->role === 'manager' ? 'Manager' : ($user->role === 'admin_gudang' ? 'Admin Gudang' : ucfirst(str_replace('_', ' ', $user->role))) }}" readonly class="mt-2 block w-full rounded-3xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-600" />
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Keamanan Akun</h2>
                    <p class="mt-1 text-sm text-slate-500">Ganti password Anda jika diperlukan. Kosongkan kedua field jika tidak ingin mengubah password.</p>
                </div>

                <div class="grid gap-4 lg:grid-cols-2">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Password Baru</label>
                        <input type="password" name="password" class="mt-2 block w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-slate-100" />
                        @error('password')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="mt-2 block w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-slate-100" />
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                <button type="submit" class="group inline-flex h-12 items-center justify-center rounded-3xl bg-slate-900 px-6 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
