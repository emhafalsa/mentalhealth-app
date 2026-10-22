@extends('layouts.admin')

@section('title', 'Persiapan penelitian')

@section('content')
    <div class="space-y-6">
        @if ($errors->any())
            <x-ui.alert tone="danger" title="Periksa kembali">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-ui.alert>
        @endif

        <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Kesiapan</p>
                    <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-950">Gerbang aktivasi penelitian</h2>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">
                        Formulir responden tetap tertutup sampai seluruh syarat terpenuhi. Halaman ini
                        hanya mengelola konfigurasi dan metadata, bukan mengumpulkan data nyata.
                    </p>
                </div>
                <x-ui.badge :tone="$ready ? 'emerald' : 'amber'">
                    {{ $ready ? 'Siap' : 'Belum lengkap' }}
                </x-ui.badge>
            </div>

            @if ($blockers === [])
                <x-ui.alert tone="success" class="mt-5" title="Semua gerbang terpenuhi">
                    Konfigurasi dasar sudah lengkap. Formulir tetap perlu diuji sebelum dibuka.
                </x-ui.alert>
            @else
                <div class="mt-5 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">
                    <p class="font-semibold">Yang masih menahan aktivasi</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5">
                        @foreach ($blockers as $blocker)
                            <li>{{ $blocker }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </section>

        @if ($ready)
            <section class="rounded-3xl border border-emerald-200 bg-emerald-50 p-6 shadow-sm">
                <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-start">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Akses peserta</p>
                        <h2 class="mt-2 text-xl font-bold text-slate-950">Formulir siap dibagikan secara terbatas</h2>
                        <p class="mt-1 max-w-2xl text-sm leading-6 text-emerald-900">
                            Jangan membagikan tautan ini ke publik. Bagikan hanya kepada peserta penelitian
                            yang memenuhi kriteria.
                        </p>
                    </div>
                    <x-ui.button :href="route('questionnaire.start')" variant="secondary" size="sm">Buka formulir</x-ui.button>
                </div>

                @if ($participantLink)
                    <div class="mt-4" x-data="{ copied: false }">
                        <label for="participant_link" class="text-sm font-semibold text-emerald-950">Tautan peserta (berlaku 7 hari)</label>
                        <div class="mt-2 flex flex-col gap-2 sm:flex-row">
                            <input id="participant_link" type="text" readonly value="{{ $participantLink }}" class="w-full rounded-xl border border-emerald-300 bg-white px-3 py-2.5 text-xs text-slate-800">
                            <button
                                type="button"
                                class="rounded-full bg-emerald-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-emerald-800"
                                @click="navigator.clipboard.writeText($refs.link.value); copied = true; setTimeout(() => copied = false, 1500)"
                            >
                                <span x-show="! copied">Salin</span>
                                <span x-show="copied" x-cloak>Tersalin</span>
                            </button>
                        </div>
                        <input x-ref="link" type="hidden" value="{{ $participantLink }}">
                    </div>
                @else
                    <div class="mt-4 rounded-2xl bg-white/70 p-4 text-sm text-emerald-950">
                        @if ($accessCodeConfigured)
                            Kode akses peserta sudah diatur. Bagikan kode tersebut secara langsung kepada peserta.
                        @else
                            Atur kode akses peserta pada bagian pengaturan di bawah sebelum membagikan formulir.
                        @endif
                    </div>
                @endif
            </section>
        @endif

        <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-start">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Identitas</p>
                    <h2 class="mt-2 text-xl font-bold text-slate-950">Pengaturan penelitian</h2>
                    <p class="mt-1 text-sm text-slate-600">
                        Isi hanya informasi yang sudah benar. Gunakan status etik <strong>pending</strong>
                        sampai prosedur etik benar-benar dikonfirmasi.
                    </p>
                </div>
                <x-ui.badge tone="slate">Dapat diisi bertahap</x-ui.badge>
            </div>

            <form method="POST" action="{{ route('admin.setup.research.update') }}" class="mt-6 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="research_title" class="text-sm font-semibold text-slate-800">Judul penelitian</label>
                        <input id="research_title" name="research_title" type="text" value="{{ old('research_title', $settings->research_title) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none" required>
                    </div>

                    <div>
                        <label for="researcher_name" class="text-sm font-semibold text-slate-800">Nama peneliti</label>
                        <input id="researcher_name" name="researcher_name" type="text" value="{{ old('researcher_name', $settings->researcher_name) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none">
                    </div>

                    <div>
                        <label for="institution" class="text-sm font-semibold text-slate-800">Institusi</label>
                        <input id="institution" name="institution" type="text" value="{{ old('institution', $settings->institution) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none">
                    </div>

                    <div>
                        <label for="contact_email" class="text-sm font-semibold text-slate-800">Email kontak</label>
                        <input id="contact_email" name="contact_email" type="email" value="{{ old('contact_email', $settings->contact_email) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none">
                    </div>

                    <div>
                        <label for="contact_phone" class="text-sm font-semibold text-slate-800">Nomor kontak</label>
                        <input id="contact_phone" name="contact_phone" type="text" value="{{ old('contact_phone', $settings->contact_phone) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none">
                    </div>
                </div>

                <div class="border-t border-slate-200 pt-6">
                    <h3 class="text-sm font-bold uppercase tracking-[0.14em] text-slate-500">Kriteria responden</h3>

                    <div class="mt-4 grid gap-4 sm:grid-cols-3">
                        <div>
                            <label for="genz_birth_year_start" class="text-sm font-semibold text-slate-800">Tahun lahir awal</label>
                            <input id="genz_birth_year_start" name="genz_birth_year_start" type="number" min="1900" max="2100" value="{{ old('genz_birth_year_start', $settings->genz_birth_year_start) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none">
                        </div>

                        <div>
                            <label for="genz_birth_year_end" class="text-sm font-semibold text-slate-800">Tahun lahir akhir</label>
                            <input id="genz_birth_year_end" name="genz_birth_year_end" type="number" min="1900" max="2100" value="{{ old('genz_birth_year_end', $settings->genz_birth_year_end) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none">
                        </div>

                        <div>
                            <label for="minimum_age" class="text-sm font-semibold text-slate-800">Usia minimum</label>
                            <input id="minimum_age" name="minimum_age" type="number" min="18" max="120" value="{{ old('minimum_age', $settings->minimum_age ?? 18) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none" required>
                        </div>
                    </div>

                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="age_verification_method" class="text-sm font-semibold text-slate-800">Metode verifikasi usia</label>
                            <select id="age_verification_method" name="age_verification_method" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none">
                                <option value="">Belum ditetapkan</option>
                                <option value="date_of_birth" @selected(old('age_verification_method', $settings->age_verification_method) === 'date_of_birth')>Tanggal lahir lengkap</option>
                                <option value="age_years" @selected(old('age_verification_method', $settings->age_verification_method) === 'age_years')>Usia dalam tahun</option>
                                <option value="birth_year_plus_age_confirmation" @selected(old('age_verification_method', $settings->age_verification_method) === 'birth_year_plus_age_confirmation')>Tahun lahir + konfirmasi usia dewasa</option>
                            </select>
                        </div>

                        <div>
                            <label for="access_mode" class="text-sm font-semibold text-slate-800">Mode akses formulir</label>
                            <select id="access_mode" name="access_mode" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none">
                                <option value="">Belum ditetapkan</option>
                                <option value="participant_link" @selected(old('access_mode', $settings->access_mode) === 'participant_link')>Tautan khusus peserta</option>
                                <option value="access_code" @selected(old('access_mode', $settings->access_mode) === 'access_code')>Kode akses peserta</option>
                                <option value="restricted_group" @selected(old('access_mode', $settings->access_mode) === 'restricted_group')>Kelompok penelitian terbatas</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="access_code" class="text-sm font-semibold text-slate-800">Kode akses peserta</label>
                            <input id="access_code" name="access_code" type="password" autocomplete="new-password" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none">
                            <p class="mt-1 text-xs text-slate-500">
                                @if ($accessCodeConfigured)
                                    Kode sudah diatur. Isi kolom ini hanya jika ingin menggantinya.
                                @else
                                    Wajib untuk mode kode akses/kelompok terbatas.
                                @endif
                            </p>
                        </div>

                        @if ($accessCodeConfigured)
                            <label class="mt-7 flex items-start gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm text-slate-700">
                                <input type="checkbox" name="remove_access_code" value="1" class="mt-0.5 size-4 rounded border-slate-300 text-emerald-700" @checked(old('remove_access_code'))>
                                <span>Hapus kode akses yang tersimpan.</span>
                            </label>
                        @endif
                    </div>

                    <div class="mt-4">
                        <label for="region_definition" class="text-sm font-semibold text-slate-800">Definisi lokasi Kabupaten Wonosobo</label>
                        <textarea id="region_definition" name="region_definition" rows="3" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none">{{ old('region_definition', $settings->region_definition) }}</textarea>
                    </div>

                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="study_start_date" class="text-sm font-semibold text-slate-800">Tanggal mulai</label>
                            <input id="study_start_date" name="study_start_date" type="date" value="{{ old('study_start_date', $settings->study_start_date?->format('Y-m-d')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none">
                        </div>
                        <div>
                            <label for="study_end_date" class="text-sm font-semibold text-slate-800">Tanggal selesai</label>
                            <input id="study_end_date" name="study_end_date" type="date" value="{{ old('study_end_date', $settings->study_end_date?->format('Y-m-d')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none">
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-200 pt-6">
                    <h3 class="text-sm font-bold uppercase tracking-[0.14em] text-slate-500">Etika dan data</h3>

                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="ethics_confirmation_status" class="text-sm font-semibold text-slate-800">Status konfirmasi etik</label>
                            <select id="ethics_confirmation_status" name="ethics_confirmation_status" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none">
                                <option value="">Belum dicatat</option>
                                <option value="pending" @selected(old('ethics_confirmation_status', $settings->ethics_confirmation_status) === 'pending')>Menunggu konfirmasi</option>
                                <option value="confirmed" @selected(old('ethics_confirmation_status', $settings->ethics_confirmation_status) === 'confirmed')>Sudah dikonfirmasi</option>
                                <option value="not_required" @selected(old('ethics_confirmation_status', $settings->ethics_confirmation_status) === 'not_required')>Tidak diperlukan sesuai prosedur</option>
                            </select>
                        </div>

                        <div>
                            <label for="ethics_reference" class="text-sm font-semibold text-slate-800">Referensi etik (opsional)</label>
                            <input id="ethics_reference" name="ethics_reference" type="text" value="{{ old('ethics_reference', $settings->ethics_reference) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none">
                        </div>

                        <div>
                            <label for="retention_months" class="text-sm font-semibold text-slate-800">Masa penyimpanan (bulan)</label>
                            <input id="retention_months" name="retention_months" type="number" min="1" max="600" value="{{ old('retention_months', $settings->retention_months) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="deletion_procedure" class="text-sm font-semibold text-slate-800">Prosedur penghapusan data</label>
                        <textarea id="deletion_procedure" name="deletion_procedure" rows="3" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none">{{ old('deletion_procedure', $settings->deletion_procedure) }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end border-t border-slate-200 pt-5">
                    <x-ui.button type="submit">Simpan pengaturan</x-ui.button>
                </div>
            </form>
        </section>

        <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-start">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Instrumen</p>
                    <h2 class="mt-2 text-xl font-bold text-slate-950">Versi DASS-21</h2>
                    <p class="mt-1 text-sm text-slate-600">
                        Teks butir tidak ditampilkan di halaman ini. Aktivasi hanya boleh dilakukan
                        setelah sumber, penerjemah, dan status penggunaan diverifikasi.
                    </p>
                </div>
                <x-ui.button :href="route('admin.instruments.create')" variant="secondary" size="sm">Tambah versi</x-ui.button>
            </div>

            <div class="mt-5 space-y-3">
                @forelse ($instruments as $instrument)
                    <article class="rounded-2xl border border-slate-200 p-4">
                        <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-start">
                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="text-base font-bold text-slate-950">{{ $instrument->code }} · {{ $instrument->version }}</h3>
                                    <x-ui.badge :tone="$instrument->status === \App\Enums\InstrumentStatus::Active ? 'emerald' : 'slate'">
                                        {{ $instrument->status->label() }}
                                    </x-ui.badge>
                                    @if ($instrument->is_active)
                                        <x-ui.badge tone="emerald">Aktif untuk formulir</x-ui.badge>
                                    @endif
                                    <x-ui.badge :tone="$instrument->hasCompleteItemTexts() ? 'emerald' : 'amber'">
                                        {{ count($instrument->orderedItemTexts()) }}/21 butir
                                    </x-ui.badge>
                                </div>
                                <p class="mt-2 text-sm text-slate-600">
                                    {{ $instrument->source_reference ?: 'Referensi sumber belum diisi.' }}
                                </p>
                                <p class="mt-1 text-xs text-slate-500">
                                    Penerjemah: {{ $instrument->translator ?: 'belum diisi' }} ·
                                    Sumber diambil: {{ $instrument->source_retrieved_at?->format('d-m-Y') ?? 'belum diisi' }} ·
                                    Verifikasi: {{ $instrument->verified_at?->format('d-m-Y H:i') ?? 'belum' }}
                                </p>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                @if ($instrument->is_active)
                                    <form method="POST" action="{{ route('admin.instruments.deactivate', $instrument) }}">
                                        @csrf
                                        <x-ui.button type="submit" variant="secondary" size="sm">Nonaktifkan</x-ui.button>
                                    </form>
                                @else
                                    <x-ui.button :href="route('admin.instruments.edit', $instrument)" variant="secondary" size="sm">Ubah</x-ui.button>

                                    @if ($instrument->status === \App\Enums\InstrumentStatus::Verified)
                                        <form method="POST" action="{{ route('admin.instruments.activate', $instrument) }}">
                                            @csrf
                                            <x-ui.button type="submit" size="sm">Aktifkan</x-ui.button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <x-ui.alert tone="warning" title="Belum ada versi instrumen">
                        Tambahkan versi DASS-21 beserta metadata sumber sebelum mengaktifkannya.
                    </x-ui.alert>
                @endforelse
            </div>
        </section>

        <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-start">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Persetujuan</p>
                    <h2 class="mt-2 text-xl font-bold text-slate-950">Versi teks persetujuan</h2>
                    <p class="mt-1 text-sm text-slate-600">
                        Teks dengan placeholder tidak dapat masuk ke tahap etik, ditinjau, disetujui, atau diaktifkan. Jangan mengisi
                        identitas atau nomor etik yang belum benar-benar tersedia.
                    </p>
                </div>
                <x-ui.button :href="route('admin.consents.create')" variant="secondary" size="sm">Tambah versi</x-ui.button>
            </div>

            <div class="mt-5 space-y-3">
                @forelse ($consents as $consent)
                    <article class="rounded-2xl border border-slate-200 p-4">
                        <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-start">
                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="text-base font-bold text-slate-950">{{ $consent->version }}</h3>
                                    <x-ui.badge :tone="$consent->status === \App\Enums\ConsentStatus::ApprovedForUse ? 'emerald' : 'slate'">
                                        {{ $consent->status->label() }}
                                    </x-ui.badge>
                                    @if ($consent->is_active)
                                        <x-ui.badge tone="emerald">Aktif untuk formulir</x-ui.badge>
                                    @endif
                                    @if ($consentPlaceholders[$consent->getKey()] ?? false)
                                        <x-ui.badge tone="amber">Placeholder tersisa</x-ui.badge>
                                    @endif
                                </div>
                                <p class="mt-2 text-sm font-medium text-slate-700">{{ $consent->title }}</p>
                                <p class="mt-1 text-xs text-slate-500">
                                    Disetujui: {{ $consent->verified_at?->format('d-m-Y H:i') ?? 'belum' }} ·
                                    Hash: {{ \Illuminate\Support\Str::limit($consent->content_hash, 16) }}
                                </p>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                @if ($consent->is_active)
                                    <form method="POST" action="{{ route('admin.consents.deactivate', $consent) }}">
                                        @csrf
                                        <x-ui.button type="submit" variant="secondary" size="sm">Nonaktifkan</x-ui.button>
                                    </form>
                                @else
                                    <x-ui.button :href="route('admin.consents.edit', $consent)" variant="secondary" size="sm">Ubah</x-ui.button>

                                    @if ($consent->status === \App\Enums\ConsentStatus::ApprovedForUse && ! ($consentPlaceholders[$consent->getKey()] ?? false))
                                        <form method="POST" action="{{ route('admin.consents.activate', $consent) }}">
                                            @csrf
                                            <x-ui.button type="submit" size="sm">Aktifkan</x-ui.button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <x-ui.alert tone="warning" title="Belum ada teks persetujuan">
                        Tambahkan versi teks persetujuan yang lengkap sebelum formulir dapat dibuka.
                    </x-ui.alert>
                @endforelse
            </div>
        </section>
    </div>
@endsection
