<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('description', 'Penelitian kesehatan mental Gen Z di Wonosobo menggunakan skrining DASS-21 dan model Random Forest. Bukan layanan diagnosis.')">
    <title>@yield('title', 'Penelitian Mental Health Gen Z Wonosobo')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased">
    <a href="#main-content" class="sr-only z-[60] rounded-full bg-emerald-700 px-4 py-2 text-white focus:not-sr-only focus:fixed focus:left-4 focus:top-4">
        Lewati ke konten utama
    </a>

    <header x-data="{ open: false }" class="sticky top-0 z-50 border-b border-slate-200/80 bg-slate-50/90 backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3" aria-label="Kembali ke beranda">
                <span class="grid size-10 place-items-center rounded-2xl bg-emerald-700 text-sm font-bold text-white shadow-sm">MH</span>
                <span class="leading-tight">
                    <span class="block text-sm font-bold tracking-tight text-slate-950">Penelitian Mental Health</span>
                    <span class="block text-xs text-slate-500">Gen Z Wonosobo</span>
                </span>
            </a>

            <nav class="hidden items-center gap-1 md:flex" aria-label="Navigasi utama">
                <a href="{{ url('/') }}#tentang" class="rounded-full px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-950">Tentang</a>
                <a href="{{ url('/') }}#alur" class="rounded-full px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-950">Alur</a>
                <a href="{{ url('/') }}#privasi" class="rounded-full px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-950">Privasi</a>
                <a href="{{ url('/') }}#faq" class="rounded-full px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-950">FAQ</a>
            </nav>

            <div class="hidden items-center gap-2 md:flex">
                <x-ui.button href="{{ route('login') }}" variant="ghost" size="sm">
                    Masuk admin
                </x-ui.button>
            </div>

            <button
                type="button"
                class="grid size-10 place-items-center rounded-full border border-slate-300 bg-white text-slate-700 md:hidden"
                @click="open = ! open"
                :aria-expanded="open"
                aria-controls="mobile-navigation"
                aria-label="Buka menu navigasi"
            >
                <svg x-show="! open" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" />
                </svg>
                <svg x-show="open" x-cloak class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" d="M6 6l12 12M18 6 6 18" />
                </svg>
            </button>
        </div>

        <div
            id="mobile-navigation"
            x-show="open"
            x-cloak
            x-transition.opacity.duration.150ms
            @click.outside="open = false"
            class="border-t border-slate-200 bg-white px-4 py-4 shadow-lg md:hidden"
        >
            <nav class="mx-auto flex max-w-6xl flex-col gap-1" aria-label="Navigasi seluler">
                <a href="{{ url('/') }}#tentang" class="rounded-xl px-3 py-2.5 text-sm font-medium hover:bg-slate-100" @click="open = false">Tentang</a>
                <a href="{{ url('/') }}#alur" class="rounded-xl px-3 py-2.5 text-sm font-medium hover:bg-slate-100" @click="open = false">Alur</a>
                <a href="{{ url('/') }}#privasi" class="rounded-xl px-3 py-2.5 text-sm font-medium hover:bg-slate-100" @click="open = false">Privasi</a>
                <a href="{{ url('/') }}#faq" class="rounded-xl px-3 py-2.5 text-sm font-medium hover:bg-slate-100" @click="open = false">FAQ</a>
                <a href="{{ route('login') }}" class="mt-2 rounded-xl bg-emerald-700 px-3 py-2.5 text-center text-sm font-semibold text-white" @click="open = false">Masuk admin</a>
            </nav>
        </div>
    </header>

    <main id="main-content">
        @yield('content')
    </main>

    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto grid max-w-6xl gap-10 px-4 py-12 sm:px-6 md:grid-cols-[1.4fr_1fr_1fr] lg:px-8">
            <div>
                <div class="flex items-center gap-3">
                    <span class="grid size-10 place-items-center rounded-2xl bg-emerald-700 text-sm font-bold text-white">MH</span>
                    <div>
                        <p class="text-sm font-bold text-slate-950">Penelitian Mental Health</p>
                        <p class="text-xs text-slate-500">Gen Z Wonosobo</p>
                    </div>
                </div>
                <p class="mt-4 max-w-md text-sm leading-6 text-slate-600">
                    Situs penelitian akademik untuk skrining kesehatan mental dan eksperimen klasifikasi
                    Random Forest. Hasil skrining bukan diagnosis medis.
                </p>
            </div>

            <div>
                <p class="text-sm font-semibold text-slate-950">Navigasi</p>
                <ul class="mt-3 space-y-2 text-sm text-slate-600">
                    <li><a class="hover:text-emerald-700" href="{{ url('/') }}#tentang">Tentang penelitian</a></li>
                    <li><a class="hover:text-emerald-700" href="{{ url('/') }}#alur">Alur skrining</a></li>
                    <li><a class="hover:text-emerald-700" href="{{ url('/') }}#privasi">Privasi dan batasan</a></li>
                    <li><a class="hover:text-emerald-700" href="{{ url('/') }}#faq">Pertanyaan umum</a></li>
                </ul>
            </div>

            <div>
                <p class="text-sm font-semibold text-slate-950">Akses</p>
                <ul class="mt-3 space-y-2 text-sm text-slate-600">
                    <li><a class="hover:text-emerald-700" href="{{ route('login') }}">Masuk administrator</a></li>
                    <li><a class="hover:text-emerald-700" href="#main-content">Kembali ke atas</a></li>
                </ul>
                <p class="mt-4 rounded-xl bg-amber-50 p-3 text-xs leading-5 text-amber-900 ring-1 ring-inset ring-amber-200">
                    Bukan layanan darurat. Jika Anda dalam bahaya, hubungi layanan darurat atau tenaga
                    profesional terdekat.
                </p>
            </div>
        </div>

        <div class="border-t border-slate-200">
            <div class="mx-auto flex max-w-6xl flex-col gap-2 px-4 py-5 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                <p>&copy; {{ date('Y') }} Penelitian Mental Health Gen Z Wonosobo.</p>
                <p>Dikembangkan untuk keperluan penelitian akademik.</p>
            </div>
        </div>
    </footer>
</body>
</html>
