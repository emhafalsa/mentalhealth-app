@extends('layouts.admin')

@section('title', $instrument->exists ? 'Ubah versi instrumen' : 'Tambah versi instrumen')

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
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Metadata instrumen</p>
            <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-950">
                {{ $instrument->exists ? 'Ubah versi DASS-21' : 'Tambah versi DASS-21' }}
            </h2>
            <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-600">
                Halaman ini tidak memuat teks 21 butir. Teks butir harus berasal dari dokumen resmi yang
                sudah diverifikasi. Status aktif hanya dapat dicapai melalui tombol aktivasi terpisah.
            </p>

            <form
                method="POST"
                action="{{ $instrument->exists ? route('admin.instruments.update', $instrument) : route('admin.instruments.store') }}"
                class="mt-6 space-y-6"
            >
                @csrf
                @if ($instrument->exists)
                    @method('PUT')
                @endif

                <div class="grid gap-4 sm:grid-cols-3">
                    <div>
                        <label for="code" class="text-sm font-semibold text-slate-800">Kode</label>
                        <input id="code" name="code" type="text" value="{{ old('code', $instrument->code ?? 'dass21') }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-2.5 text-sm text-slate-900" readonly>
                    </div>

                    <div>
                        <label for="version" class="text-sm font-semibold text-slate-800">Versi</label>
                        <input id="version" name="version" type="text" value="{{ old('version', $instrument->version) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none" required>
                    </div>

                    <div>
                        <label for="locale" class="text-sm font-semibold text-slate-800">Locale</label>
                        <input id="locale" name="locale" type="text" value="{{ old('locale', $instrument->locale ?? 'id') }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none" required>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="status" class="text-sm font-semibold text-slate-800">Status verifikasi</label>
                        <select id="status" name="status" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none">
                            @foreach (\App\Enums\InstrumentStatus::cases() as $status)
                                @if ($status !== \App\Enums\InstrumentStatus::Active)
                                    <option value="{{ $status->value }}" @selected(old('status', $instrument->status?->value ?? \App\Enums\InstrumentStatus::Draft->value) === $status->value)>
                                        {{ $status->label() }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="effective_from" class="text-sm font-semibold text-slate-800">Berlaku mulai (opsional)</label>
                        <input id="effective_from" name="effective_from" type="date" value="{{ old('effective_from', $instrument->effective_from?->format('Y-m-d')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none">
                    </div>
                </div>

                <div class="border-t border-slate-200 pt-6">
                    <h3 class="text-sm font-bold uppercase tracking-[0.14em] text-slate-500">Sumber dan verifikasi</h3>

                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="source_reference" class="text-sm font-semibold text-slate-800">Referensi sumber</label>
                            <input id="source_reference" name="source_reference" type="text" value="{{ old('source_reference', $instrument->source_reference) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="source_url" class="text-sm font-semibold text-slate-800">URL sumber</label>
                            <input id="source_url" name="source_url" type="url" value="{{ old('source_url', $instrument->source_url) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none">
                        </div>

                        <div>
                            <label for="source_retrieved_at" class="text-sm font-semibold text-slate-800">Tanggal sumber diambil</label>
                            <input id="source_retrieved_at" name="source_retrieved_at" type="date" value="{{ old('source_retrieved_at', $instrument->source_retrieved_at?->format('Y-m-d')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none">
                        </div>

                        <div>
                            <label for="translator" class="text-sm font-semibold text-slate-800">Penerjemah</label>
                            <input id="translator" name="translator" type="text" value="{{ old('translator', $instrument->translator) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none">
                        </div>

                        <div>
                            <label for="copyright_status" class="text-sm font-semibold text-slate-800">Status penggunaan</label>
                            <input id="copyright_status" name="copyright_status" type="text" value="{{ old('copyright_status', $instrument->copyright_status) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="verification_notes" class="text-sm font-semibold text-slate-800">Catatan verifikasi</label>
                        <textarea id="verification_notes" name="verification_notes" rows="4" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none">{{ old('verification_notes', $instrument->verification_notes) }}</textarea>
                    </div>
                </div>

                <div class="border-t border-slate-200 pt-6">
                    <h3 class="text-sm font-bold uppercase tracking-[0.14em] text-slate-500">Teks instrumen</h3>

                    <div class="mt-4">
                        <label for="instructions" class="text-sm font-semibold text-slate-800">Instruksi pengisian</label>
                        <textarea id="instructions" name="instructions" rows="5" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm leading-6 text-slate-900 focus:border-emerald-600 focus:outline-none">{{ old('instructions', $instrument->instructions ?: config('dass21.instructions')) }}</textarea>
                    </div>

                    <div class="mt-4">
                        <label for="item_texts_raw" class="text-sm font-semibold text-slate-800">Teks 21 butir DASS-21</label>
                        <textarea id="item_texts_raw" name="item_texts_raw" rows="22" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 font-mono text-sm leading-6 text-slate-900 focus:border-emerald-600 focus:outline-none" placeholder="Satu butir per baris, urutan 1 sampai 21.">{{ old('item_texts_raw', implode("\n", $instrument->itemTextsForEditing())) }}</textarea>
                        <p class="mt-2 text-xs leading-5 text-slate-500">
                            Jangan mengarang, memparafrasa, atau menerjemahkan sendiri. Salin hanya dari dokumen
                            resmi yang sudah diverifikasi. Status terverifikasi membutuhkan tepat 21 baris.
                        </p>
                    </div>
                </div>

                <x-ui.alert tone="info" title="Aktivasi terpisah">
                    Status <strong>terverifikasi</strong> belum membuka formulir. Gunakan tombol
                    <strong>Aktifkan</strong> di halaman persiapan setelah metadata lengkap.
                </x-ui.alert>

                <div class="flex flex-wrap justify-end gap-3 border-t border-slate-200 pt-5">
                    <x-ui.button :href="route('admin.setup.index')" variant="secondary">Batal</x-ui.button>
                    <x-ui.button type="submit">Simpan versi</x-ui.button>
                </div>
            </form>
        </section>
    </div>
@endsection
