@extends('layouts.admin')

@section('title', 'Detail responden')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Data penelitian</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-950">Detail kiriman</h2>
                <p class="mt-1 text-xs text-slate-500">ID: {{ $submission->getKey() }}</p>
            </div>
            <x-ui.button :href="route('admin.submissions.index')" variant="secondary" size="sm">Kembali</x-ui.button>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
            <div class="rounded-2xl border border-slate-200 bg-white p-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Dikirim</p>
                <p class="mt-1 text-sm font-bold text-slate-950">{{ $submission->submitted_at?->format('d-m-Y H:i') }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Tahun lahir</p>
                <p class="mt-1 text-sm font-bold text-slate-950">{{ $submission->birth_year }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Usia saat kirim</p>
                <p class="mt-1 text-sm font-bold text-slate-950">{{ $submission->age_at_submission ?? 'Tidak dihitung' }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Kecamatan</p>
                <p class="mt-1 text-sm font-bold text-slate-950">{{ $submission->subdistrictLabel() ?? 'Tidak diisi' }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Status data</p>
                <p class="mt-1 text-sm font-bold text-slate-950">{{ $submission->data_status->label() }}</p>
            </div>
        </div>

        <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-950">Hasil DASS-21</h3>
                    <p class="mt-1 text-sm text-slate-600">Skor akhir = skor mentah × 2. Kategori bukan diagnosis.</p>
                </div>
                <x-ui.badge tone="amber">Admin only</x-ui.badge>
            </div>

            @if ($submission->screeningResult)
                <div class="mt-5 grid gap-4 md:grid-cols-3">
                    @foreach ([
                        ['label' => 'Depresi', 'raw' => $submission->screeningResult->depression_raw, 'final' => $submission->screeningResult->depression_final, 'category' => $submission->screeningResult->depression_category],
                        ['label' => 'Kecemasan', 'raw' => $submission->screeningResult->anxiety_raw, 'final' => $submission->screeningResult->anxiety_final, 'category' => $submission->screeningResult->anxiety_category],
                        ['label' => 'Stres', 'raw' => $submission->screeningResult->stress_raw, 'final' => $submission->screeningResult->stress_final, 'category' => $submission->screeningResult->stress_category],
                    ] as $score)
                        <div class="rounded-2xl border border-slate-200 p-4">
                            <p class="text-sm font-semibold text-slate-700">{{ $score['label'] }}</p>
                            <p class="mt-2 text-3xl font-bold text-slate-950">{{ $score['final'] }}</p>
                            <p class="mt-1 text-xs text-slate-500">Mentah: {{ $score['raw'] }}</p>
                            <div class="mt-3">
                                <x-ui.badge tone="slate">{{ $score['category']->label() }}</x-ui.badge>
                            </div>
                        </div>
                    @endforeach
                </div>
                <p class="mt-4 text-xs text-slate-500">
                    Instrumen: {{ $submission->screeningResult->instrumentVersion?->code }}
                    {{ $submission->screeningResult->instrumentVersion?->version }} ·
                    Dihitung: {{ $submission->screeningResult->computed_at?->format('d-m-Y H:i') }}
                </p>
            @else
                <p class="mt-4 text-sm text-slate-600">Hasil skrining belum tersedia.</p>
            @endif
        </section>

        <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-950">Faktor pendukung</h3>

            @if ($submission->supportingFactor)
                <dl class="mt-5 grid gap-4 text-sm sm:grid-cols-2 lg:grid-cols-3">
                    <div>
                        <dt class="text-slate-500">Pendidikan</dt>
                        <dd class="mt-1 font-semibold text-slate-950">{{ $submission->supportingFactor->education_status }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Pekerjaan</dt>
                        <dd class="mt-1 font-semibold text-slate-950">{{ $submission->supportingFactor->employment_status }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Durasi tidur</dt>
                        <dd class="mt-1 font-semibold text-slate-950">{{ $submission->supportingFactor->sleep_duration_hours }} jam</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Aktivitas fisik</dt>
                        <dd class="mt-1 font-semibold text-slate-950">{{ $submission->supportingFactor->physical_activity_days }} hari</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Media sosial</dt>
                        <dd class="mt-1 font-semibold text-slate-950">{{ $submission->supportingFactor->social_media_hours_per_day }} jam/hari</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Dukungan sosial</dt>
                        <dd class="mt-1 font-semibold text-slate-950">{{ $submission->supportingFactor->social_support_score ?? 'Tidak aktif' }}</dd>
                    </div>
                </dl>
            @else
                <p class="mt-4 text-sm text-slate-600">Data faktor pendukung belum tersedia.</p>
            @endif
        </section>

        <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-950">Persetujuan</h3>
            <p class="mt-3 text-sm text-slate-600">
                Versi: <span class="font-semibold text-slate-900">{{ $submission->consentVersion?->version }}</span> ·
                Disetujui: {{ $submission->consent_accepted_at?->format('d-m-Y H:i') }}
            </p>
            <p class="mt-1 text-xs text-slate-500">
                Hash teks: {{ \Illuminate\Support\Str::limit($submission->consentVersion?->content_hash, 20) }}
            </p>
        </section>
    </div>
@endsection
