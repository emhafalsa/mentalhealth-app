@extends('layouts.public')

@section('title', 'Pemeriksaan kelayakan')

@section('content')
    <section class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8 lg:py-16">
        @include('questionnaire.partials.alerts')

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Langkah 1 dari 3</p>
            <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-950 sm:text-3xl">Pemeriksaan kelayakan</h1>
            <p class="mt-3 text-sm leading-6 text-slate-600">
                Pemeriksaan ini memastikan Anda memenuhi kriteria peserta. Data kelayakan tidak
                disimpan jika Anda tidak memenuhi syarat.
            </p>

            <div class="mt-5 grid gap-3 sm:grid-cols-3">
                <div class="rounded-2xl bg-slate-50 p-4 text-sm">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Rentang lahir</p>
                    <p class="mt-1 font-bold text-slate-950">
                        {{ $settings->genz_birth_year_start ?? config('research.genz_operational_start') }}–{{ $settings->genz_birth_year_end ?? config('research.genz_operational_end') }}
                    </p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-4 text-sm">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Usia minimum</p>
                    <p class="mt-1 font-bold text-slate-950">{{ $settings->minimum_age }} tahun</p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-4 text-sm">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Wilayah</p>
                    <p class="mt-1 font-bold text-slate-950">Kabupaten Wonosobo</p>
                </div>
            </div>

            <form method="POST" action="{{ route('questionnaire.eligibility.store') }}" class="mt-6 space-y-5">
                @csrf

                <div>
                    <label for="birth_year" class="text-sm font-semibold text-slate-800">Tahun lahir</label>
                    <input
                        id="birth_year"
                        name="birth_year"
                        type="number"
                        min="{{ $settings->genz_birth_year_start ?? config('research.genz_operational_start') }}"
                        max="{{ $settings->genz_birth_year_end ?? config('research.genz_operational_end') }}"
                        value="{{ old('birth_year') }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none"
                        required
                        inputmode="numeric"
                    >
                </div>

                @if ($settings->age_verification_method === 'date_of_birth')
                    <div>
                        <label for="date_of_birth" class="text-sm font-semibold text-slate-800">Tanggal lahir</label>
                        <input
                            id="date_of_birth"
                            name="date_of_birth"
                            type="date"
                            max="{{ now()->format('Y-m-d') }}"
                            value="{{ old('date_of_birth') }}"
                            class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none"
                            required
                        >
                        <p class="mt-1 text-xs text-slate-500">Tanggal lahir lengkap hanya dipakai untuk menghitung usia saat ini.</p>
                    </div>
                @elseif ($settings->age_verification_method === 'age_years')
                    <div>
                        <label for="age_years" class="text-sm font-semibold text-slate-800">Usia saat ini (tahun)</label>
                        <input
                            id="age_years"
                            name="age_years"
                            type="number"
                            min="{{ $settings->minimum_age }}"
                            max="120"
                            value="{{ old('age_years') }}"
                            class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none"
                            required
                            inputmode="numeric"
                        >
                    </div>
                @elseif ($settings->age_verification_method === 'birth_year_plus_age_confirmation')
                    <div>
                        <label for="age_years" class="text-sm font-semibold text-slate-800">Usia saat ini (tahun)</label>
                        <input
                            id="age_years"
                            name="age_years"
                            type="number"
                            min="{{ $settings->minimum_age }}"
                            max="120"
                            value="{{ old('age_years') }}"
                            class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none"
                            required
                            inputmode="numeric"
                        >
                        <p class="mt-1 text-xs text-slate-500">
                            Usia dinyatakan sendiri dan akan diperiksa terhadap tahun lahir. Peneliti tidak meminta
                            tanggal lahir lengkap atau unggahan KTP.
                        </p>
                    </div>
                @else
                    <x-ui.alert tone="warning" title="Metode usia belum diatur">
                        Peneliti belum menetapkan metode verifikasi usia. Formulir tidak dapat dilanjutkan.
                    </x-ui.alert>
                @endif

                <div>
                    <label for="subdistrict" class="text-sm font-semibold text-slate-800">Kecamatan (opsional)</label>
                    <select
                        id="subdistrict"
                        name="subdistrict"
                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none"
                    >
                        <option value="">Tidak diisi</option>
                        @foreach (config('research.subdistricts', []) as $value => $label)
                            <option value="{{ $value }}" @selected(old('subdistrict') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-slate-500">
                        Cukup kecamatan, bukan alamat lengkap. Data ini tidak digunakan untuk mengklaim keterwakilan kabupaten.
                    </p>
                </div>

                <label class="flex items-start gap-3 rounded-2xl border border-slate-200 p-4 text-sm leading-6 text-slate-700">
                    <input type="checkbox" name="wonosobo_resident" value="1" class="mt-1 size-4 rounded border-slate-300 text-emerald-700" @checked(old('wonosobo_resident'))>
                    <span>
                        Saya berada di wilayah penelitian Kabupaten Wonosobo sesuai definisi yang
                        ditetapkan peneliti.
                    </span>
                </label>

                <div class="flex flex-col gap-3 border-t border-slate-200 pt-5 sm:flex-row sm:justify-between">
                    <x-ui.button :href="route('questionnaire.consent')" variant="secondary">Kembali ke persetujuan</x-ui.button>
                    <x-ui.button type="submit">Periksa dan lanjutkan</x-ui.button>
                </div>
            </form>
        </div>
    </section>
@endsection
