@extends('layouts.public')

@section('title', 'Kuesioner penelitian')

@section('content')
    <section class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
        @include('questionnaire.partials.alerts')

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Langkah 2 dari 3</p>
            <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-950 sm:text-3xl">Kuesioner penelitian</h1>
            <p class="mt-3 text-sm leading-6 text-slate-600">
                {{ $instrument->instructionsText() }}
            </p>

            <x-ui.alert tone="info" class="mt-5" title="Cara menjawab">
                Pilih satu jawaban untuk setiap pernyataan. Tidak ada jawaban benar atau salah.
                Jawaban Anda tidak ditampilkan kembali sebagai diagnosis.
            </x-ui.alert>

            <form method="POST" action="{{ route('questionnaire.submit') }}" class="mt-8 space-y-8">
                @csrf
                <input type="hidden" name="nonce" value="{{ $nonce }}">

                <section>
                    <div class="flex items-end justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-bold text-slate-950">Bagian A — DASS-21</h2>
                            <p class="mt-1 text-sm text-slate-600">21 pernyataan tentang pengalaman satu minggu terakhir.</p>
                        </div>
                        <x-ui.badge tone="slate">21 butir</x-ui.badge>
                    </div>

                    <div class="mt-5 space-y-4">
                        @foreach ($items as $itemNumber => $itemText)
                            <fieldset class="rounded-2xl border border-slate-200 p-4">
                                <legend class="px-1 text-sm font-semibold text-slate-900">
                                    <span class="mr-2 inline-grid size-7 place-items-center rounded-full bg-emerald-50 text-xs font-bold text-emerald-800 ring-1 ring-inset ring-emerald-200">{{ $itemNumber }}</span>
                                    {{ $itemText }}
                                </legend>

                                <div class="mt-4 grid gap-2 sm:grid-cols-2">
                                    @foreach ($responseOptions as $value => $label)
                                        <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 p-3 text-sm leading-6 text-slate-700 hover:border-emerald-300 hover:bg-emerald-50/40">
                                            <input
                                                type="radio"
                                                name="items[{{ $itemNumber }}]"
                                                value="{{ $value }}"
                                                class="mt-1 size-4 border-slate-300 text-emerald-700"
                                                @checked((string) old('items.'.$itemNumber) === (string) $value)
                                                required
                                            >
                                            <span>
                                                <span class="font-bold text-slate-900">{{ $value }}</span>
                                                — {{ $label }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </fieldset>
                        @endforeach
                    </div>
                </section>

                <section class="border-t border-slate-200 pt-8">
                    <h2 class="text-lg font-bold text-slate-950">Bagian B — Faktor pendukung</h2>
                    <p class="mt-1 text-sm text-slate-600">
                        Jawaban berikut digunakan untuk analisis penelitian, bukan untuk menilai Anda.
                    </p>

                    <div class="mt-5 grid gap-5 sm:grid-cols-2">
                        @foreach ($features as $key => $feature)
                            <div class="{{ ($feature['type'] ?? null) === 'categorical' ? '' : '' }}">
                                <label for="factor_{{ $key }}" class="text-sm font-semibold text-slate-800">
                                    {{ $feature['label'] }}
                                </label>

                                @if (($feature['type'] ?? null) === 'categorical')
                                    <select
                                        id="factor_{{ $key }}"
                                        name="factors[{{ $key }}]"
                                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none"
                                        required
                                    >
                                        <option value="">Pilih {{ strtolower($feature['label']) }}</option>
                                        @foreach (($feature['options'] ?? []) as $optionValue => $optionLabel)
                                            <option value="{{ $optionValue }}" @selected(old('factors.'.$key) === (string) $optionValue)>{{ $optionLabel }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <div class="mt-2 flex items-center gap-2">
                                        <input
                                            id="factor_{{ $key }}"
                                            name="factors[{{ $key }}]"
                                            type="number"
                                            min="{{ $feature['min'] ?? 0 }}"
                                            max="{{ $feature['max'] ?? 100 }}"
                                            step="{{ $feature['step'] ?? 1 }}"
                                            value="{{ old('factors.'.$key) }}"
                                            class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none"
                                            required
                                            inputmode="decimal"
                                        >
                                        <span class="shrink-0 text-xs text-slate-500">{{ $feature['unit'] ?? '' }}</span>
                                    </div>
                                @endif

                                @if (! empty($feature['operational_definition']))
                                    <p class="mt-1 text-xs leading-5 text-slate-500">{{ $feature['operational_definition'] }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>

                <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm leading-6 text-amber-900">
                    <p class="font-semibold">Sebelum mengirim</p>
                    <p class="mt-1">
                        Pastikan semua jawaban sudah sesuai. Setelah dikirim, jawaban tidak dapat diubah
                        melalui situs ini. Hubungi peneliti jika ada masalah.
                    </p>
                </div>

                <div class="flex flex-col gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-xs leading-5 text-slate-500">
                        Dengan mengirim, Anda menyatakan bahwa jawaban diisi berdasarkan pengalaman Anda sendiri.
                    </p>
                    <x-ui.button type="submit" size="lg">Kirim jawaban</x-ui.button>
                </div>
            </form>
        </div>
    </section>
@endsection
