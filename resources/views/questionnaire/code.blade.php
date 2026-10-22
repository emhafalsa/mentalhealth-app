@extends('layouts.public')

@section('title', 'Masuk ke kuesioner')

@section('content')
    <section class="mx-auto max-w-2xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
        @include('questionnaire.partials.alerts')

        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm sm:p-10">
            <x-ui.badge tone="emerald">Peserta penelitian</x-ui.badge>
            <h1 class="mt-5 text-3xl font-bold tracking-tight text-slate-950">Masukkan kode akses</h1>
            <p class="mt-3 text-sm leading-6 text-slate-600">
                Kode diberikan langsung oleh peneliti kepada peserta yang memenuhi kriteria. Jangan
                membagikan kode ini kepada orang di luar kelompok penelitian.
            </p>

            <form method="POST" action="{{ route('questionnaire.code.store') }}" class="mt-6 space-y-4">
                @csrf

                <div>
                    <label for="access_code" class="text-sm font-semibold text-slate-800">Kode akses</label>
                    <input
                        id="access_code"
                        name="access_code"
                        type="password"
                        autocomplete="one-time-code"
                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-3 text-base text-slate-900 focus:border-emerald-600 focus:outline-none"
                        required
                        autofocus
                    >
                </div>

                <x-ui.button type="submit" size="lg" class="w-full">Lanjutkan</x-ui.button>
            </form>

            <p class="mt-5 text-xs leading-5 text-slate-500">
                Bukan layanan darurat. Jika Anda membutuhkan bantuan segera, hubungi layanan darurat
                atau tenaga profesional terdekat.
            </p>
        </div>
    </section>
@endsection
