@extends('layouts.public')

@section('title', 'Tautan peserta diperlukan')

@section('content')
    <section class="mx-auto max-w-3xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
        @include('questionnaire.partials.alerts')

        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm sm:p-10">
            <x-ui.badge tone="amber">Akses terbatas</x-ui.badge>
            <h1 class="mt-5 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">
                Gunakan tautan peserta dari peneliti.
            </h1>
            <p class="mt-4 text-base leading-7 text-slate-600">
                Formulir penelitian ini hanya dibuka untuk peserta penelitian yang telah menerima
                tautan khusus. Tautan tidak boleh dibagikan ke publik.
            </p>

            <div class="mt-7">
                <x-ui.button :href="route('home')" variant="secondary">Kembali ke beranda</x-ui.button>
            </div>
        </div>
    </section>
@endsection
