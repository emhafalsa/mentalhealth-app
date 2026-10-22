@extends('layouts.admin')

@section('title', $consent->exists ? 'Ubah teks persetujuan' : 'Tambah teks persetujuan')

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
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Persetujuan responden</p>
            <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-950">
                {{ $consent->exists ? 'Ubah teks persetujuan' : 'Tambah teks persetujuan' }}
            </h2>
            <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-600">
                Jangan mengisi nama, kontak, institusi, atau nomor etik yang belum benar-benar tersedia.
                Teks dengan placeholder boleh disimpan sebagai draft atau menunggu kelengkapan, tetapi tidak
                dapat masuk ke tahap etik, ditinjau, disetujui, atau diaktifkan.
            </p>

            <form
                method="POST"
                action="{{ $consent->exists ? route('admin.consents.update', $consent) : route('admin.consents.store') }}"
                class="mt-6 space-y-6"
            >
                @csrf
                @if ($consent->exists)
                    @method('PUT')
                @endif

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="version" class="text-sm font-semibold text-slate-800">Versi</label>
                        <input id="version" name="version" type="text" value="{{ old('version', $consent->version) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none" required>
                    </div>

                    <div>
                        <label for="status" class="text-sm font-semibold text-slate-800">Status alur persetujuan</label>
                        <select id="status" name="status" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none">
                            @foreach (\App\Enums\ConsentStatus::cases() as $status)
                                <option value="{{ $status->value }}" @selected(old('status', $consent->status?->value ?? \App\Enums\ConsentStatus::Draft->value) === $status->value)>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="title" class="text-sm font-semibold text-slate-800">Judul</label>
                        <input id="title" name="title" type="text" value="{{ old('title', $consent->title) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none" required>
                    </div>

                    <div>
                        <label for="effective_from" class="text-sm font-semibold text-slate-800">Berlaku mulai (opsional)</label>
                        <input id="effective_from" name="effective_from" type="date" value="{{ old('effective_from', $consent->effective_from?->format('Y-m-d')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label for="body" class="text-sm font-semibold text-slate-800">Isi teks persetujuan</label>
                    <textarea id="body" name="body" rows="18" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 font-mono text-sm leading-6 text-slate-900 focus:border-emerald-600 focus:outline-none" required>{{ old('body', $consent->body) }}</textarea>
                    <p class="mt-2 text-xs text-slate-500">
                        Placeholder yang masih ada akan menghambat verifikasi dan aktivasi. Contoh:
                        [NAMA PENELITI], [MASA PENYIMPANAN DATA].
                    </p>
                </div>

                <x-ui.alert tone="info" title="Aktivasi terpisah">
                    Status <strong>disetujui untuk digunakan</strong> belum membuka formulir. Gunakan tombol
                    <strong>Aktifkan</strong> di halaman persiapan setelah teks bersih dari placeholder.
                </x-ui.alert>

                <div class="flex flex-wrap justify-end gap-3 border-t border-slate-200 pt-5">
                    <x-ui.button :href="route('admin.setup.index')" variant="secondary">Batal</x-ui.button>
                    <x-ui.button type="submit">Simpan versi</x-ui.button>
                </div>
            </form>
        </section>
    </div>
@endsection
