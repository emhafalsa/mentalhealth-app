@extends('layouts.public')

@section('title', 'Persetujuan peserta')

@section('content')
    <section class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8 lg:py-16">
        @include('questionnaire.partials.alerts')

        <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_20rem]">
            <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <x-ui.badge tone="emerald">Lembar informasi</x-ui.badge>
                <h1 class="mt-4 text-2xl font-bold tracking-tight text-slate-950 sm:text-3xl">{{ $consent->title }}</h1>
                <p class="mt-2 text-xs font-semibold uppercase tracking-wide text-slate-500">Versi {{ $consent->version }}</p>

                <div class="prose prose-slate mt-6 max-w-none text-sm leading-7 text-slate-700">
                    {!! nl2br(e($consent->body)) !!}
                </div>
            </article>

            <aside class="space-y-4">
                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="text-base font-bold text-slate-950">Persetujuan</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Baca seluruh lembar informasi. Anda dapat menolak atau berhenti sebelum mengirim
                        jawaban tanpa memberikan alasan.
                    </p>

                    <form method="POST" action="{{ route('questionnaire.consent.store') }}" class="mt-4 space-y-4">
                        @csrf

                        <label class="flex items-start gap-3 rounded-2xl border border-slate-200 p-3 text-sm leading-6 text-slate-700">
                            <input type="checkbox" name="consent" value="1" class="mt-1 size-4 rounded border-slate-300 text-emerald-700" required @checked(old('consent'))>
                            <span>
                                Saya telah membaca dan memahami lembar informasi ini, dan saya secara
                                sukarela menyetujui untuk mengikuti penelitian.
                            </span>
                        </label>

                        <x-ui.button type="submit" class="w-full">Saya setuju dan lanjutkan</x-ui.button>
                    </form>

                    <form method="POST" action="{{ route('questionnaire.consent.decline') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="w-full rounded-full border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                            Saya tidak setuju
                        </button>
                    </form>
                </div>

                <div class="rounded-3xl border border-amber-200 bg-amber-50 p-5 text-sm leading-6 text-amber-900">
                    <p class="font-semibold">Bukan diagnosis</p>
                    <p class="mt-1">
                        DASS-21 adalah alat skrining, bukan diagnosis. Hasil tidak ditampilkan kepada
                        responden dan tidak menggantikan pemeriksaan tenaga profesional.
                    </p>
                </div>
            </aside>
        </div>
    </section>
@endsection
