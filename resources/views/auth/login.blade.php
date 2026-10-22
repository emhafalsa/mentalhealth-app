@extends('layouts.guest')

@section('title', 'Masuk Admin')

@section('content')
    <section class="rounded-[2rem] border border-slate-200 bg-white p-7 shadow-xl shadow-slate-950/5 sm:p-8">
        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Dashboard penelitian</p>
        <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-950">Masuk sebagai admin</h1>
        <p class="mt-2 text-sm leading-6 text-slate-600">
            Halaman ini hanya untuk pengelola penelitian. Responden tidak perlu membuat akun.
        </p>

        {{-- Ringkasan error dibuat umum agar tidak membocorkan data akun. --}}
        @if ($errors->any())
            <x-ui.alert tone="danger" class="mt-6">
                {{ $errors->first() }}
            </x-ui.alert>
        @endif

        @if (session('status'))
            <x-ui.alert tone="success" class="mt-6">
                {{ session('status') }}
            </x-ui.alert>
        @endif

        <form method="POST" action="{{ route('login.store') }}" class="mt-6 space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-slate-800">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    class="mt-1.5 w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100"
                >
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-800">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                    class="mt-1.5 w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100"
                >
            </div>

            <label class="flex items-center gap-2.5 text-sm text-slate-700">
                <input type="checkbox" name="remember" value="1" class="size-4 rounded border-slate-300 text-emerald-700 focus:ring-emerald-500">
                Ingat perangkat ini
            </label>

            <x-ui.button type="submit" size="lg" class="w-full">
                Masuk ke dashboard
            </x-ui.button>
        </form>

        <p class="mt-6 border-t border-slate-200 pt-5 text-center text-sm text-slate-500">
            <a href="{{ route('home') }}" class="font-medium text-emerald-700 hover:text-emerald-800">Kembali ke halaman utama</a>
        </p>
    </section>
@endsection
