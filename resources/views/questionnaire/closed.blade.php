@extends('layouts.public')

@section('title', 'Kuesioner belum dibuka')

@section('content')
    <section class="mx-auto max-w-3xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
        @include('questionnaire.partials.alerts')

        <div class="rounded-3xl border border-amber-200 bg-white p-8 shadow-sm sm:p-10">
            <x-ui.badge tone="amber">Belum dibuka</x-ui.badge>
            <h1 class="mt-5 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">
                Kuesioner penelitian belum dapat diisi.
            </h1>
            <p class="mt-4 text-base leading-7 text-slate-600">
                Formulir baru tersedia setelah instrumen, teks persetujuan, kriteria peserta, dan
                prosedur etik penelitian selesai diverifikasi. Situs ini tidak menampilkan formulir
                atau data contoh.
            </p>

            <div class="mt-6 rounded-2xl bg-slate-50 p-5 text-sm leading-6 text-slate-600">
                <p class="font-semibold text-slate-900">{{ $settings->research_title ?: config('research.title') }}</p>
                <p class="mt-1">
                    Jika Anda menerima tautan atau kode peserta, hubungi peneliti apabila tautan
                    tersebut belum dapat digunakan.
                </p>
            </div>

            <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                <x-ui.button :href="route('home')">Kembali ke beranda</x-ui.button>
                <x-ui.button :href="route('login')" variant="secondary">Masuk administrator</x-ui.button>
            </div>
        </div>
    </section>
@endsection
