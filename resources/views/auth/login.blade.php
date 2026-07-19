@extends('layouts.app')

@section('title', 'Login - Inventory SaaS')

@section('content')
<div class="flex min-h-[calc(100vh-4rem)] items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-6 rounded-3xl bg-white p-8 shadow-xl ring-1 ring-slate-200">
        <div class="text-center">
            <h2 class="text-2xl font-semibold text-slate-900">Masuk ke Logistik</h2>
            <p class="mt-2 text-sm text-slate-500">Gunakan akun manager atau admin gudang Anda.</p>
        </div>

        @if($errors->any())
            <div class="rounded-xl bg-red-50 p-4 text-red-700 ring-1 ring-red-200">
                <ul class="space-y-1 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="space-y-4" method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-sky-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-100" />
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Password</label>
                <div class="relative mt-2">
                    <input id="login-password" type="password" name="password" required class="block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 pr-12 text-sm text-slate-900 focus:border-sky-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-100" />
                    <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 transition duration-150 hover:text-slate-700 focus:outline-none" aria-label="Tampilkan atau sembunyikan password">
                        <svg id="icon-eye" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="icon-eye-off" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="hidden h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.223-3.607M6.18 6.18A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-1.123 2.468M3 3l18 18" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.88 9.88a3 3 0 104.24 4.24" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.12 14.12a3 3 0 01-4.24-4.24" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-between text-sm text-slate-500">
                <label class="group inline-flex items-center gap-2">
                    <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500" />
                    Ingat saya
                </label>
                <a href="#" class="font-medium text-sky-600 hover:text-sky-700 cursor-pointer">Lupa password?</a>
            </div>

            <button type="submit" class="w-full rounded-2xl bg-sky-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 cursor-pointer">Masuk</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var passwordInput = document.getElementById('login-password');
        var toggleButton = document.getElementById('toggle-password');
        var iconEye = document.getElementById('icon-eye');
        var iconEyeOff = document.getElementById('icon-eye-off');

        if (!passwordInput || !toggleButton || !iconEye || !iconEyeOff) {
            return;
        }

        toggleButton.addEventListener('click', function () {
            var isHidden = passwordInput.type === 'password';

            passwordInput.type = isHidden ? 'text' : 'password';
            iconEye.classList.toggle('hidden', !isHidden);
            iconEyeOff.classList.toggle('hidden', isHidden);
        });
    });
</script>
@endsection
