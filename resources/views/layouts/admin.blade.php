<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Dashboard') — {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 font-sans text-slate-900 antialiased" x-data="{ sidebarOpen: false }" :class="{ 'overflow-hidden lg:overflow-auto': sidebarOpen }">
    <a href="#admin-content" class="sr-only z-[60] rounded-full bg-emerald-700 px-4 py-2 text-white focus:not-sr-only focus:fixed focus:left-4 focus:top-4">
        Lewati ke konten utama
    </a>

    <div class="lg:grid lg:grid-cols-[18rem_minmax(0,1fr)]">
        <div
            x-show="sidebarOpen"
            x-cloak
            x-transition.opacity.duration.150ms
            class="fixed inset-0 z-40 bg-slate-950/50 backdrop-blur-sm lg:hidden"
            @click="sidebarOpen = false"
            aria-hidden="true"
        ></div>

        <aside
            id="admin-sidebar"
            class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col bg-slate-950 text-slate-300 transition-transform duration-200 lg:sticky lg:top-0 lg:h-screen lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            aria-label="Navigasi dashboard"
        >
            <div class="flex items-center justify-between gap-3 px-5 py-5">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <span class="grid size-10 place-items-center rounded-2xl bg-emerald-600 text-sm font-bold text-white">MH</span>
                    <span class="leading-tight">
                        <span class="block text-sm font-bold text-white">Dashboard</span>
                        <span class="block text-xs text-slate-400">Penelitian Gen Z</span>
                    </span>
                </a>

                <button
                    type="button"
                    class="grid size-9 place-items-center rounded-full text-slate-400 hover:bg-slate-800 hover:text-white lg:hidden"
                    @click="sidebarOpen = false"
                    aria-label="Tutup menu"
                >
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" d="M6 6l12 12M18 6 6 18" />
                    </svg>
                </button>
            </div>

            <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4" aria-label="Menu dashboard">
                <p class="px-3 pb-2 text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500">Utama</p>

                <a
                    href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold {{ request()->routeIs('dashboard') ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                    @if (request()->routeIs('dashboard')) aria-current="page" @endif
                    @click="sidebarOpen = false"
                >
                    <svg class="size-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 13h6V4H4v9Zm0 7h6v-4H4v4Zm10 0h6v-9h-6v9Zm0-13h6V4h-6v3Z" />
                    </svg>
                    Dashboard
                </a>

                <p class="px-3 pb-2 pt-5 text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500">Penelitian</p>

                <a
                    href="{{ route('admin.submissions.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold {{ request()->routeIs('admin.submissions.*') ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                    @if (request()->routeIs('admin.submissions.*')) aria-current="page" @endif
                    @click="sidebarOpen = false"
                >
                    <svg class="size-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6.5A2.5 2.5 0 0 1 6.5 4H20v14.5A2.5 2.5 0 0 1 17.5 21H6.5A2.5 2.5 0 0 1 4 18.5v-12Z" />
                        <path stroke-linecap="round" d="M8 8h8M8 12h8M8 16h5" />
                    </svg>
                    Data responden
                </a>

                <div class="flex items-center justify-between rounded-xl px-3 py-2.5 text-sm text-slate-500">
                    <span class="flex items-center gap-3">
                        <svg class="size-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 19V5m0 14h16M8 15l3-4 3 2 4-6" />
                        </svg>
                        Eksperimen model
                    </span>
                    <span class="rounded-full bg-slate-800 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide">Segera</span>
                </div>

                <a
                    href="{{ route('admin.setup.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold {{ request()->routeIs('admin.setup.*') ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                    @if (request()->routeIs('admin.setup.*')) aria-current="page" @endif
                    @click="sidebarOpen = false"
                >
                    <svg class="size-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-1.42 1.42-.06-.06a1.7 1.7 0 0 0-1.88-.34 1.7 1.7 0 0 0-1.03 1.56V20h-2v-.48a1.7 1.7 0 0 0-1.03-1.56 1.7 1.7 0 0 0-1.88.34l-.06.06-1.42-1.42.06-.06A1.7 1.7 0 0 0 9.4 15a1.7 1.7 0 0 0-1.56-1.03H7.4v-2h.44A1.7 1.7 0 0 0 9.4 10.9a1.7 1.7 0 0 0-.34-1.88l-.06-.06 1.42-1.42.06.06a1.7 1.7 0 0 0 1.88.34 1.7 1.7 0 0 0 1.03-1.56V6h2v.38a1.7 1.7 0 0 0 1.03 1.56 1.7 1.7 0 0 0 1.88-.34l.06-.06 1.42 1.42-.06.06a1.7 1.7 0 0 0-.34 1.88 1.7 1.7 0 0 0 1.56 1.03H21v2h-.48A1.7 1.7 0 0 0 19.4 15Z" />
                    </svg>
                    Persiapan penelitian
                </a>
            </nav>

            <div class="border-t border-white/10 p-3">
                <div class="rounded-2xl bg-white/5 p-3">
                    <div class="flex items-center gap-3">
                        <span class="grid size-10 shrink-0 place-items-center rounded-full bg-emerald-600 text-sm font-bold text-white">
                            {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr(auth()->user()->name, 0, 2)) }}
                        </span>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                            <p class="truncate text-xs text-slate-400">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="w-full rounded-xl border border-white/10 px-3 py-2 text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white">
                            Keluar dari dashboard
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="min-w-0">
            <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 backdrop-blur">
                <div class="flex items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
                    <div class="flex min-w-0 items-center gap-3">
                        <button
                            type="button"
                            class="grid size-10 shrink-0 place-items-center rounded-full border border-slate-300 bg-white text-slate-700 lg:hidden"
                            @click="sidebarOpen = true"
                            aria-controls="admin-sidebar"
                            aria-label="Buka menu dashboard"
                        >
                            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" />
                            </svg>
                        </button>

                        <div class="min-w-0">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-emerald-700">Ruang administrator</p>
                            <h1 class="truncate text-lg font-bold text-slate-950">@yield('title', 'Dashboard')</h1>
                        </div>
                    </div>

                    <a href="{{ route('home') }}" class="hidden items-center gap-2 text-sm font-medium text-slate-600 hover:text-emerald-700 sm:inline-flex">
                        Lihat situs
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 17 17 7M9 7h8v8" />
                        </svg>
                    </a>
                </div>
            </header>

            <main id="admin-content" class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
                @if (session('status'))
                    <x-ui.alert tone="success" class="mb-6">{{ session('status') }}</x-ui.alert>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
