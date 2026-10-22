@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="space-y-6">
        <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Selamat datang</p>
                    <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-950">Ringkasan data responden</h2>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">
                        Angka di bawah berasal dari database MySQL. Data valid belum otomatis berarti cukup
                        untuk pelatihan model; keputusan kelayakan tetap mengikuti aturan penelitian.
                    </p>
                </div>
                <x-ui.badge tone="emerald">Data riil</x-ui.badge>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-3">
                <x-admin.stat
                    label="Total kiriman"
                    :value="number_format($counts['total'], 0, ',', '.')"
                    hint="Seluruh kiriman yang tercatat."
                    tone="slate"
                />
                <x-admin.stat
                    label="Data valid"
                    :value="number_format($counts['valid'], 0, ',', '.')"
                    hint="Siap dipertimbangkan untuk analisis."
                    tone="emerald"
                />
                <x-admin.stat
                    label="Data dikecualikan"
                    :value="number_format($counts['excluded'], 0, ',', '.')"
                    hint="Tidak memenuhi kriteria."
                    tone="amber"
                />
            </div>
        </section>

        <div class="grid gap-6 lg:grid-cols-[1.08fr_0.92fr]">
            <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Kesiapan</p>
                        <h2 class="mt-2 text-xl font-bold text-slate-950">Instrumen penelitian</h2>
                    </div>
                    <x-ui.badge :tone="$ready ? 'emerald' : 'amber'">
                        {{ $ready ? 'Siap' : 'Belum lengkap' }}
                    </x-ui.badge>
                </div>

                <ul class="mt-5 divide-y divide-slate-200">
                    <li class="flex items-center justify-between gap-4 py-3">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Instrumen DASS-21 aktif</p>
                            <p class="mt-0.5 text-xs text-slate-500">Pemetaan butir dan ambang final.</p>
                        </div>
                        <x-ui.badge :tone="$readiness['instrument'] ? 'emerald' : 'amber'">
                            {{ $readiness['instrument'] ? 'Aktif' : 'Belum' }}
                        </x-ui.badge>
                    </li>
                    <li class="flex items-center justify-between gap-4 py-3">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Teks 21 butir DASS-21</p>
                            <p class="mt-0.5 text-xs text-slate-500">Butir yang akan ditampilkan pada formulir.</p>
                        </div>
                        <x-ui.badge :tone="$readiness['instrument_items'] ? 'emerald' : 'amber'">
                            {{ $readiness['instrument_items'] ? 'Lengkap' : 'Belum' }}
                        </x-ui.badge>
                    </li>
                    <li class="flex items-center justify-between gap-4 py-3">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Teks persetujuan aktif</p>
                            <p class="mt-0.5 text-xs text-slate-500">Versi yang akan disetujui responden.</p>
                        </div>
                        <x-ui.badge :tone="$readiness['consent'] && $readiness['consent_placeholders'] ? 'emerald' : 'amber'">
                            {{ $readiness['consent'] && $readiness['consent_placeholders'] ? 'Lengkap' : 'Belum' }}
                        </x-ui.badge>
                    </li>
                    <li class="flex items-center justify-between gap-4 py-3">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Akses peserta</p>
                            <p class="mt-0.5 text-xs text-slate-500">Tautan bertanda tangan atau kode akses.</p>
                        </div>
                        <x-ui.badge :tone="$readiness['access'] && $readiness['access_credentials'] ? 'emerald' : 'amber'">
                            {{ $readiness['access'] && $readiness['access_credentials'] ? 'Siap' : 'Belum' }}
                        </x-ui.badge>
                    </li>
                    <li class="flex items-center justify-between gap-4 py-3">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Kriteria Gen Z</p>
                            <p class="mt-0.5 text-xs text-slate-500">
                                @if ($settings->hasGenZCriteria())
                                    {{ $settings->genz_birth_year_start }}–{{ $settings->genz_birth_year_end }}
                                @else
                                    Rentang tahun lahir belum diisi.
                                @endif
                            </p>
                        </div>
                        <x-ui.badge :tone="$readiness['genz'] ? 'emerald' : 'amber'">
                            {{ $readiness['genz'] ? 'Lengkap' : 'Belum' }}
                        </x-ui.badge>
                    </li>
                </ul>

                <div class="mt-5 rounded-2xl bg-slate-50 p-4 text-sm text-slate-600">
                    Usia minimum: <span class="font-semibold text-slate-900">{{ $settings->minimum_age }} tahun</span>.
                    Semua konfigurasi klinis harus dikonfirmasi sebelum kuesioner dibuka.
                </div>

                @if ($blockers !== [])
                    <div class="mt-4 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">
                        <p class="font-semibold">Yang masih menahan aktivasi</p>
                        <ul class="mt-2 list-disc space-y-1 pl-5">
                            @foreach ($blockers as $blocker)
                                <li>{{ $blocker }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </section>

            <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Pemodelan</p>
                        <h2 class="mt-2 text-xl font-bold text-slate-950">Eksperimen model</h2>
                    </div>
                    <x-ui.badge tone="slate">{{ number_format($experimentCount, 0, ',', '.') }} total</x-ui.badge>
                </div>

                @if ($latestExperiment)
                    <dl class="mt-5 grid gap-4 text-sm sm:grid-cols-2">
                        <div>
                            <dt class="text-slate-500">Eksperimen terbaru</dt>
                            <dd class="mt-1 font-semibold text-slate-950">{{ $latestExperiment->version }}</dd>
                        </div>
                        <div>
                            <dt class="text-slate-500">Status</dt>
                            <dd class="mt-1 font-semibold text-slate-950">{{ $latestExperiment->status->label() }}</dd>
                        </div>
                        <div>
                            <dt class="text-slate-500">Jumlah baris</dt>
                            <dd class="mt-1 font-semibold text-slate-950">{{ number_format($latestExperiment->row_count, 0, ',', '.') }}</dd>
                        </div>
                        <div>
                            <dt class="text-slate-500">Dibuat</dt>
                            <dd class="mt-1 font-semibold text-slate-950">{{ $latestExperiment->created_at?->format('d-m-Y H:i') ?? '—' }}</dd>
                        </div>
                    </dl>

                    @if ($latestSuccessfulExperiment)
                        <p class="mt-5 rounded-2xl bg-emerald-50 p-4 text-sm leading-6 text-emerald-900">
                            Eksperimen berhasil terakhir: <span class="font-semibold">{{ $latestSuccessfulExperiment->version }}</span>.
                            Metrik hanya ditampilkan setelah evaluasi tersimpan.
                        </p>
                    @endif
                @else
                    <div class="mt-5 rounded-2xl bg-slate-50 p-5">
                        <p class="text-sm font-semibold text-slate-900">Belum ada eksperimen.</p>
                        <p class="mt-1 text-sm leading-6 text-slate-600">
                            Pelatihan tidak boleh dimulai sebelum data riil dan keputusan label disetujui.
                        </p>
                    </div>
                @endif
            </section>
        </div>

        <x-ui.alert tone="warning" title="Batas penggunaan hasil">
            Kategori DASS-21 dan prediksi Random Forest tidak boleh ditampilkan sebagai diagnosis.
            Model hanya boleh dilatih dengan data penelitian yang valid dan konfigurasi fitur yang disetujui.
        </x-ui.alert>

        <section class="rounded-3xl border border-dashed border-slate-300 bg-white/60 p-6">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Tahap berikutnya</p>
                    <h2 class="mt-2 text-xl font-bold text-slate-950">Modul responden sudah tersedia</h2>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">
                        Formulir tetap tertutup sampai seluruh kesiapan penelitian terpenuhi. Setelah data
                        riil terkumpul, dataset dapat diekspor untuk eksperimen Random Forest.
                    </p>
                </div>
                <a href="{{ route('admin.submissions.index') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Buka data responden
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 17 17 7M9 7h8v8" />
                    </svg>
                </a>
            </div>
        </section>
    </div>
@endsection
