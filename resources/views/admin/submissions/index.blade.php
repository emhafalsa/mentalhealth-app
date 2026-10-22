@extends('layouts.admin')

@section('title', 'Data responden')

@section('content')
    <div class="space-y-6">
        <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Data penelitian</p>
                    <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-950">Kiriman responden</h2>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">
                        Halaman ini hanya untuk administrator. Skor dan kategori tidak boleh ditampilkan
                        sebagai diagnosis kepada responden.
                    </p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <x-ui.button :href="route('admin.submissions.export')" variant="secondary" size="sm">Ekspor CSV</x-ui.button>
                    <x-ui.button :href="route('admin.setup.index')" variant="ghost" size="sm">Persiapan</x-ui.button>
                </div>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-3">
                <div class="rounded-2xl bg-slate-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total</p>
                    <p class="mt-1 text-2xl font-bold text-slate-950">{{ number_format($counts['total'], 0, ',', '.') }}</p>
                </div>
                <div class="rounded-2xl bg-emerald-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-emerald-700">Valid</p>
                    <p class="mt-1 text-2xl font-bold text-emerald-950">{{ number_format($counts['valid'], 0, ',', '.') }}</p>
                </div>
                <div class="rounded-2xl bg-amber-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-amber-700">Dikecualikan</p>
                    <p class="mt-1 text-2xl font-bold text-amber-950">{{ number_format($counts['excluded'], 0, ',', '.') }}</p>
                </div>
            </div>
        </section>

        <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            @if ($submissions->isEmpty())
                <div class="p-8 text-center">
                    <p class="text-sm font-semibold text-slate-900">Belum ada kiriman.</p>
                    <p class="mt-1 text-sm text-slate-600">Data akan muncul setelah formulir penelitian dibuka dan ada peserta yang mengirim jawaban.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <tr>
                                <th scope="col" class="px-4 py-3">Dikirim</th>
                                <th scope="col" class="px-4 py-3">Lahir</th>
                                <th scope="col" class="px-4 py-3">Usia</th>
                                <th scope="col" class="px-4 py-3">Kecamatan</th>
                                <th scope="col" class="px-4 py-3">Depresi</th>
                                <th scope="col" class="px-4 py-3">Kecemasan</th>
                                <th scope="col" class="px-4 py-3">Stres</th>
                                <th scope="col" class="px-4 py-3"><span class="sr-only">Aksi</span></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($submissions as $submission)
                                <tr class="hover:bg-slate-50">
                                    <td class="whitespace-nowrap px-4 py-3 text-slate-600">{{ $submission->submitted_at?->format('d-m-Y H:i') }}</td>
                                    <td class="px-4 py-3 text-slate-700">{{ $submission->birth_year }}</td>
                                    <td class="px-4 py-3 text-slate-700">{{ $submission->age_at_submission ?? '—' }}</td>
                                    <td class="px-4 py-3 text-slate-700">{{ $submission->subdistrictLabel() ?? '—' }}</td>
                                    <td class="px-4 py-3">
                                        @if ($submission->screeningResult)
                                            <x-ui.badge tone="slate">{{ $submission->screeningResult->depression_category->label() }}</x-ui.badge>
                                        @else
                                            <span class="text-slate-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($submission->screeningResult)
                                            <x-ui.badge tone="slate">{{ $submission->screeningResult->anxiety_category->label() }}</x-ui.badge>
                                        @else
                                            <span class="text-slate-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($submission->screeningResult)
                                            <x-ui.badge tone="slate">{{ $submission->screeningResult->stress_category->label() }}</x-ui.badge>
                                        @else
                                            <span class="text-slate-400">—</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 text-right">
                                        <x-ui.button :href="route('admin.submissions.show', $submission)" variant="ghost" size="sm">Lihat</x-ui.button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-slate-200 p-4">
                    {{ $submissions->links() }}
                </div>
            @endif
        </section>
    </div>
@endsection
