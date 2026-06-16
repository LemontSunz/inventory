<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{ config('app.name', 'Inventory SaaS') }}</title>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
        <div class="min-h-screen">
            @include('components.nav')
            <div class="flex min-h-[calc(100vh-4rem)] overflow-visible bg-slate-50">
                @include('components.sidebar')

                <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
                    <div class="mx-auto w-full max-w-[1400px]">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
