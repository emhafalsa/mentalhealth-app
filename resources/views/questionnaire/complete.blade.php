@extends('layouts.public')

@section('title', 'Jawaban terkirim')

@section('content')
    <section class="mx-auto max-w-3xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
        <div class="rounded-3xl border border-emerald-200 bg-white p-8 shadow-sm sm:p-10">
            <x-ui.badge tone="emerald">Selesai</x-ui.badge>
            <h1 class="mt-5 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">
                Jawaban berhasil dikirim.
            </h1>
            <p class="mt-4 text-base leading-7 text-slate-600">
                Terima kasih telah berpartisipasi. Jawaban Anda sudah tercatat untuk keperluan
                penelitian. Halaman ini tidak menampilkan skor atau interpretasi individual.
            </p>

            <div class="mt-6 rounded-2xl bg-slate-50 p-5 text-sm leading-6 text-slate-600">
                <p class="font-semibold text-slate-900">Penting</p>
                <p class="mt-1">
                    DASS-21 dan model Random Forest bukan alat diagnosis. Jika Anda membutuhkan bantuan,
                    hubungi tenaga kesehatan mental atau layanan darurat setempat.
                </p>
            </div>

            <div class="mt-7">
                <x-ui.button :href="route('home')" variant="secondary">Kembali ke beranda</x-ui.button>
            </div>
        </div>
    </section>
@endsection
