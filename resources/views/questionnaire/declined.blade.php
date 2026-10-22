@extends('layouts.public')

@section('title', 'Persetujuan tidak diberikan')

@section('content')
    <section class="mx-auto max-w-3xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm sm:p-10">
            <x-ui.badge tone="slate">Dihentikan</x-ui.badge>
            <h1 class="mt-5 text-3xl font-bold tracking-tight text-slate-950">Tidak ada data yang disimpan.</h1>
            <p class="mt-4 text-base leading-7 text-slate-600">
                Anda memilih untuk tidak memberikan persetujuan. Proses berhenti dan tidak ada jawaban
                penelitian yang dikirim atau disimpan.
            </p>
            <p class="mt-3 text-sm leading-6 text-slate-600">
                Anda dapat menutup halaman ini. Terima kasih telah membaca informasi penelitian.
            </p>

            <div class="mt-7">
                <x-ui.button :href="route('home')" variant="secondary">Kembali ke beranda</x-ui.button>
            </div>
        </div>
    </section>
@endsection
