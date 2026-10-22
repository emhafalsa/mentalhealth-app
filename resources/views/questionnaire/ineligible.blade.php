@extends('layouts.public')

@section('title', 'Belum memenuhi kriteria')

@section('content')
    <section class="mx-auto max-w-3xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
        <div class="rounded-3xl border border-amber-200 bg-white p-8 shadow-sm sm:p-10">
            <x-ui.badge tone="amber">Tidak dilanjutkan</x-ui.badge>
            <h1 class="mt-5 text-3xl font-bold tracking-tight text-slate-950">Anda belum memenuhi kriteria peserta.</h1>
            <p class="mt-4 text-base leading-7 text-slate-600">{{ $reason }}</p>
            <p class="mt-4 text-sm leading-6 text-slate-600">
                Tidak ada jawaban penelitian yang disimpan pada tahap ini. Terima kasih telah
                mempertimbangkan penelitian ini.
            </p>

            <div class="mt-7">
                <x-ui.button :href="route('home')" variant="secondary">Kembali ke beranda</x-ui.button>
            </div>
        </div>
    </section>
@endsection
