<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Masuk Admin') — {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 font-sans text-slate-900 antialiased">
    <div class="min-h-screen lg:grid lg:grid-cols-[1.05fr_1fr]">
        <aside class="relative hidden overflow-hidden bg-emerald-950 p-10 text-white lg:flex lg:flex-col lg:justify-between">
            <div class="absolute inset-0 bg-soft-grid opacity-20" aria-hidden="true"></div>
            <div class="absolute -right-20 top-20 size-80 rounded-full bg-emerald-500/20 blur-3xl" aria-hidden="true"></div>
            <div class="absolute -bottom-24 -left-16 size-72 rounded-full bg-teal-400/10 blur-3xl" aria-hidden="true"></div>

            <div class="relative">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                    <span class="grid size-11 place-items-center rounded-2xl bg-white text-sm font-bold text-emerald-900">MH</span>
                    <span class="leading-tight">
                        <span class="block text-sm font-bold">Penelitian Mental Health</span>
                        <span class="block text-xs text-emerald-200">Gen Z Wonosobo</span>
                    </span>
                </a>

                <div class="mt-20 max-w-lg">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-300">Ruang administrator</p>
                    <h1 class="mt-4 text-4xl font-bold leading-tight tracking-tight">
                        Kelola penelitian dengan data yang rapi dan dapat diaudit.
                    </h1>
                    <p class="mt-5 text-sm leading-6 text-emerald-100/80">
                        Dashboard ini hanya untuk pengelola penelitian. Responden tidak membuat akun dan
                        tidak dapat mengakses area ini.
                    </p>
                </div>
            </div>

            <div class="relative rounded-2xl border border-white/15 bg-white/5 p-5">
                <p class="text-sm font-semibold text-white">Prinsip kerja</p>
                <ul class="mt-3 space-y-2 text-sm text-emerald-100/80">
                    <li>Data riil saja, tanpa data responden fiktif.</li>
                    <li>Hasil skrining bukan diagnosis medis.</li>
                    <li>Prediksi model tidak ditampilkan sebagai diagnosis.</li>
                </ul>
            </div>
        </aside>

        <main class="flex min-h-screen items-center justify-center px-4 py-10 sm:px-8">
            <div class="w-full max-w-md">
                <div class="mb-6 flex items-center justify-between lg:hidden">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                        <span class="grid size-10 place-items-center rounded-2xl bg-emerald-700 text-sm font-bold text-white">MH</span>
                        <span class="text-sm font-bold text-slate-950">Penelitian Mental Health</span>
                    </a>
                    <a href="{{ route('home') }}" class="text-sm font-medium text-slate-600 hover:text-emerald-700">Beranda</a>
                </div>

                @yield('content')

                <p class="mt-6 text-center text-xs text-slate-500">
                    Akses terbatas untuk administrator penelitian.
                </p>
            </div>
        </main>
    </div>
</body>
</html>
