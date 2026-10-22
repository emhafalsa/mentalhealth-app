@extends('layouts.public')

@section('title', 'Penelitian Mental Health Gen Z Wonosobo')
@section('description', 'Penelitian akademik tentang kesehatan mental Gen Z di Wonosobo menggunakan skrining DASS-21 dan model Random Forest. Hasil skrining bukan diagnosis medis.')

@section('content')
    <section class="relative overflow-hidden border-b border-slate-200">
        <div class="absolute inset-0 bg-soft-grid opacity-40" aria-hidden="true"></div>
        <div class="absolute -right-24 top-10 size-80 rounded-full bg-emerald-200/50 blur-3xl" aria-hidden="true"></div>
        <div class="absolute -left-24 bottom-0 size-72 rounded-full bg-teal-100/60 blur-3xl" aria-hidden="true"></div>

        <div class="relative mx-auto grid max-w-6xl items-center gap-12 px-4 py-16 sm:px-6 lg:grid-cols-[1.12fr_0.88fr] lg:px-8 lg:py-24">
            <div>
                <div class="flex flex-wrap items-center gap-2">
                    <x-ui.badge tone="emerald">Penelitian akademik</x-ui.badge>
                    <x-ui.badge tone="amber">Kuesioner segera dibuka</x-ui.badge>
                </div>

                <h1 class="mt-6 max-w-3xl text-4xl font-bold leading-[1.08] tracking-tight text-slate-950 sm:text-5xl lg:text-6xl">
                    Ruang sadar untuk <span class="text-emerald-700">kesehatan mental</span> Gen Z Wonosobo.
                </h1>

                <p class="mt-6 max-w-2xl text-base leading-7 text-slate-600 sm:text-lg">
                    Penelitian ini menggabungkan skrining DASS-21 dengan model Random Forest untuk memahami
                    pola kesehatan mental pada Gen Z di Kabupaten Wonosobo. Hasil skrining membantu Anda
                    mengenali kondisi saat ini, bukan menegakkan diagnosis.
                </p>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <x-ui.button href="#alur" size="lg">
                        Lihat alur skrining
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-5-5 5 5-5 5" />
                        </svg>
                    </x-ui.button>
                    <x-ui.button href="#tentang" variant="secondary" size="lg">
                        Pelajari penelitian
                    </x-ui.button>
                </div>

                <dl class="mt-10 grid max-w-xl grid-cols-1 gap-3 text-sm sm:grid-cols-3">
                    <div class="rounded-2xl border border-slate-200 bg-white/80 p-4 shadow-sm">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Peserta</dt>
                        <dd class="mt-1 font-bold text-slate-950">Usia 18+</dd>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white/80 p-4 shadow-sm">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Identitas</dt>
                        <dd class="mt-1 font-bold text-slate-950">Tanpa nama</dd>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white/80 p-4 shadow-sm">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Tujuan</dt>
                        <dd class="mt-1 font-bold text-slate-950">Penelitian</dd>
                    </div>
                </dl>
            </div>

            <div class="relative mx-auto w-full max-w-md lg:mr-0">
                <div class="absolute -inset-4 rounded-[2rem] bg-emerald-200/40 blur-2xl" aria-hidden="true"></div>

                <div class="relative overflow-hidden rounded-[2rem] border border-emerald-200 bg-white p-6 shadow-xl shadow-emerald-950/5 sm:p-7">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Alur data</p>
                            <h2 class="mt-1 text-xl font-bold text-slate-950">Dari jawaban menjadi wawasan</h2>
                        </div>
                        <x-ui.badge tone="slate">Eksperimen</x-ui.badge>
                    </div>

                    <ol class="mt-6 space-y-4">
                        <li class="flex gap-4">
                            <span class="grid size-10 shrink-0 place-items-center rounded-2xl bg-emerald-50 text-sm font-bold text-emerald-700 ring-1 ring-inset ring-emerald-200">01</span>
                            <div>
                                <p class="font-semibold text-slate-950">Skrining DASS-21</p>
                                <p class="mt-1 text-sm leading-6 text-slate-600">21 butir untuk membaca tingkat depresi, kecemasan, dan stres.</p>
                            </div>
                        </li>
                        <li class="flex gap-4">
                            <span class="grid size-10 shrink-0 place-items-center rounded-2xl bg-emerald-50 text-sm font-bold text-emerald-700 ring-1 ring-inset ring-emerald-200">02</span>
                            <div>
                                <p class="font-semibold text-slate-950">Faktor pendukung</p>
                                <p class="mt-1 text-sm leading-6 text-slate-600">Usia, pendidikan, pekerjaan, tidur, aktivitas, dan penggunaan media sosial.</p>
                            </div>
                        </li>
                        <li class="flex gap-4">
                            <span class="grid size-10 shrink-0 place-items-center rounded-2xl bg-emerald-50 text-sm font-bold text-emerald-700 ring-1 ring-inset ring-emerald-200">03</span>
                            <div>
                                <p class="font-semibold text-slate-950">Analisis Random Forest</p>
                                <p class="mt-1 text-sm leading-6 text-slate-600">Model klasifikasi eksperimental dievaluasi dengan data penelitian yang valid.</p>
                            </div>
                        </li>
                    </ol>

                    <div class="mt-6 rounded-2xl bg-amber-50 p-4 text-sm leading-6 text-amber-900 ring-1 ring-inset ring-amber-200">
                        <p class="font-semibold">Penting</p>
                        <p class="mt-1">Hasil skrining dan prediksi model bukan diagnosis medis. Prediksi Random Forest tidak ditampilkan sebagai diagnosis kepada responden.</p>
                    </div>
                </div>

                <div class="absolute -bottom-5 -left-4 hidden rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-lg sm:block">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Instrumen</p>
                    <p class="mt-1 text-sm font-bold text-slate-950">DASS-21 · 3 subskala</p>
                </div>
            </div>
        </div>
    </section>

    <section id="tentang" class="border-b border-slate-200 bg-white">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="max-w-2xl">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">Tentang penelitian</p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">
                    Memahami kesehatan mental dengan data yang bertanggung jawab.
                </h2>
                <p class="mt-4 text-base leading-7 text-slate-600">
                    Penelitian ini berfokus pada Gen Z di Kabupaten Wonosobo. Data dikumpulkan melalui
                    kuesioner, diolah di database penelitian, lalu dianalisis untuk melihat pola yang
                    dapat membantu pemahaman awal tentang kesehatan mental.
                </p>
            </div>

            <div class="mt-10 grid gap-5 md:grid-cols-3">
                <article class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <div class="grid size-11 place-items-center rounded-2xl bg-emerald-700 text-white">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 4h6v3.2a3 3 0 0 0 .6 1.8l1.4 1.9a5 5 0 0 1 1 3V19a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2v-5.1a5 5 0 0 1 1-3L8.4 9A3 3 0 0 0 9 7.2V4Z" />
                            <path stroke-linecap="round" d="M9 17h6" />
                        </svg>
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-slate-950">Skrining DASS-21</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Instrumen 21 butir dengan tiga subskala: depresi, kecemasan, dan stres. Hasilnya
                        berupa kategori skrining, bukan diagnosis klinis.
                    </p>
                </article>

                <article class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <div class="grid size-11 place-items-center rounded-2xl bg-emerald-700 text-white">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 19V5m0 14h16M8 15l3-4 3 2 4-6" />
                        </svg>
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-slate-950">Faktor pendukung</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Usia, status pendidikan, pekerjaan, durasi tidur, aktivitas fisik, dan penggunaan
                        media sosial. Variabel final mengikuti keputusan dosen pembimbing.
                    </p>
                </article>

                <article class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <div class="grid size-11 place-items-center rounded-2xl bg-emerald-700 text-white">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 18a4 4 0 1 1 .6-7.95A5.5 5.5 0 0 1 18.2 11 3.5 3.5 0 0 1 18 18H7Z" />
                            <path stroke-linecap="round" d="M8 21h8" />
                        </svg>
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-slate-950">Random Forest</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Model klasifikasi eksperimental yang dievaluasi dengan metrik yang disetujui.
                        Model tidak menggantikan penilaian tenaga profesional.
                    </p>
                </article>
            </div>

            <div class="mt-8">
                <x-ui.alert tone="info" title="Fokus peserta">
                    Peserta adalah Gen Z yang berdomisili di Kabupaten Wonosobo dan berusia minimal 18 tahun.
                    Rentang tahun lahir Gen Z mengikuti kriteria final yang ditetapkan peneliti.
                </x-ui.alert>
            </div>
        </div>
    </section>

    <section id="alur" class="border-b border-slate-200 bg-slate-50">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end">
                <div class="max-w-2xl">
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">Alur skrining</p>
                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">
                        Empat langkah yang jelas dan transparan.
                    </h2>
                    <p class="mt-4 text-base leading-7 text-slate-600">
                        Kuesioner belum dibuka untuk umum. Alur di bawah menjelaskan proses yang akan
                        dijalankan setelah instrumen dan teks persetujuan final disetujui.
                    </p>
                </div>

                <x-ui.badge tone="amber">Tahap pengembangan</x-ui.badge>
            </div>

            <ol class="mt-10 grid gap-5 md:grid-cols-2">
                <li class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center gap-3">
                        <span class="grid size-9 place-items-center rounded-full bg-emerald-700 text-sm font-bold text-white">1</span>
                        <h3 class="text-lg font-bold text-slate-950">Cek kelayakan</h3>
                    </div>
                    <p class="mt-4 text-sm leading-6 text-slate-600">
                        Pastikan Anda berusia minimal 18 tahun, berdomisili di Wonosobo, dan termasuk
                        kriteria Gen Z yang ditetapkan peneliti.
                    </p>
                </li>

                <li class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center gap-3">
                        <span class="grid size-9 place-items-center rounded-full bg-emerald-700 text-sm font-bold text-white">2</span>
                        <h3 class="text-lg font-bold text-slate-950">Baca dan setujui</h3>
                    </div>
                    <p class="mt-4 text-sm leading-6 text-slate-600">
                        Pelajari tujuan, manfaat, risiko, kerahasiaan, hak Anda, dan kontak peneliti.
                        Anda dapat berhenti sebelum mengirim jawaban.
                    </p>
                </li>

                <li class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center gap-3">
                        <span class="grid size-9 place-items-center rounded-full bg-emerald-700 text-sm font-bold text-white">3</span>
                        <h3 class="text-lg font-bold text-slate-950">Isi kuesioner</h3>
                    </div>
                    <p class="mt-4 text-sm leading-6 text-slate-600">
                        Jawab 21 butir DASS-21 dan pertanyaan faktor pendukung. Data disimpan tanpa nama
                        dan hanya diakses oleh administrator penelitian.
                    </p>
                </li>

                <li class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center gap-3">
                        <span class="grid size-9 place-items-center rounded-full bg-emerald-700 text-sm font-bold text-white">4</span>
                        <h3 class="text-lg font-bold text-slate-950">Lihat hasil skrining</h3>
                    </div>
                    <p class="mt-4 text-sm leading-6 text-slate-600">
                        Anda menerima kategori skrining per subskala. Hasil ini bersifat awal dan bukan
                        diagnosis. Prediksi model tidak ditampilkan sebagai diagnosis.
                    </p>
                </li>
            </ol>

            <div class="mt-8">
                <x-ui.alert tone="warning" title="Belum dapat diisi">
                    Halaman kuesioner akan tersedia setelah teks DASS-21 Indonesia yang sah dan teks
                    persetujuan responden disetujui dosen pembimbing. Situs ini tidak menggunakan data
                    responden fiktif.
                </x-ui.alert>
            </div>
        </div>
    </section>

    <section id="privasi" class="border-b border-slate-200 bg-white">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="grid gap-10 lg:grid-cols-[0.8fr_1.2fr]">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">Privasi dan batasan</p>
                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">
                        Anda tetap memegang kendali atas data Anda.
                    </h2>
                    <p class="mt-4 text-base leading-7 text-slate-600">
                        Data digunakan untuk keperluan penelitian akademik. Tidak ada nama, email, atau
                        nomor telepon responden yang diminta pada kuesioner.
                    </p>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <article class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                        <h3 class="font-bold text-slate-950">Tanpa identitas</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-600">Jawaban tidak dihubungkan dengan nama atau akun pribadi.</p>
                    </article>
                    <article class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                        <h3 class="font-bold text-slate-950">Akses terbatas</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-600">Hanya administrator penelitian yang dapat membuka dashboard data.</p>
                    </article>
                    <article class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                        <h3 class="font-bold text-slate-950">Bukan diagnosis</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-600">Kategori DASS-21 dan prediksi model tidak menggantikan pemeriksaan profesional.</p>
                    </article>
                    <article class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                        <h3 class="font-bold text-slate-950">Boleh berhenti</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-600">Anda dapat menghentikan pengisian sebelum jawaban dikirim.</p>
                    </article>
                </div>
            </div>

            <div class="mt-8 rounded-3xl border border-amber-200 bg-amber-50 p-5 text-sm leading-6 text-amber-900">
                <p class="font-semibold">Jika Anda membutuhkan bantuan segera</p>
                <p class="mt-1">
                    Situs ini bukan layanan darurat. Hubungi layanan darurat setempat, tenaga kesehatan
                    mental, atau orang yang Anda percaya jika Anda merasa tidak aman.
                </p>
            </div>
        </div>
    </section>

    <section id="faq" class="bg-slate-50">
        <div class="mx-auto max-w-4xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="text-center">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">Pertanyaan umum</p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">Hal yang sering ditanyakan</h2>
            </div>

            <div class="mt-10 space-y-3">
                <details class="group rounded-2xl border border-slate-200 bg-white p-5 open:shadow-sm">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold text-slate-950">
                        Apakah hasil skrining ini diagnosis?
                        <span class="grid size-8 shrink-0 place-items-center rounded-full bg-slate-100 text-slate-600 transition group-open:rotate-45">
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <p class="mt-3 text-sm leading-6 text-slate-600">
                        Bukan. DASS-21 adalah alat skrining, bukan alat diagnosis. Hasil perlu ditafsirkan
                        bersama tenaga profesional.
                    </p>
                </details>

                <details class="group rounded-2xl border border-slate-200 bg-white p-5 open:shadow-sm">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold text-slate-950">
                        Apakah responden perlu membuat akun?
                        <span class="grid size-8 shrink-0 place-items-center rounded-full bg-slate-100 text-slate-600 transition group-open:rotate-45">
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <p class="mt-3 text-sm leading-6 text-slate-600">
                        Tidak. Responden tidak mendaftar atau membuat akun. Login hanya tersedia untuk
                        administrator penelitian.
                    </p>
                </details>

                <details class="group rounded-2xl border border-slate-200 bg-white p-5 open:shadow-sm">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold text-slate-950">
                        Data apa yang disimpan?
                        <span class="grid size-8 shrink-0 place-items-center rounded-full bg-slate-100 text-slate-600 transition group-open:rotate-45">
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <p class="mt-3 text-sm leading-6 text-slate-600">
                        Jawaban DASS-21, faktor pendukung, usia, status domisili, dan waktu pengiriman.
                        Kuesioner tidak meminta nama, email, atau nomor telepon.
                    </p>
                </details>

                <details class="group rounded-2xl border border-slate-200 bg-white p-5 open:shadow-sm">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold text-slate-950">
                        Apakah prediksi Random Forest ditampilkan?
                        <span class="grid size-8 shrink-0 place-items-center rounded-full bg-slate-100 text-slate-600 transition group-open:rotate-45">
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <p class="mt-3 text-sm leading-6 text-slate-600">
                        Pada versi awal, prediksi tidak ditampilkan kepada responden. Jika nanti ditampilkan,
                        hasilnya harus diberi label eksperimental dan tidak boleh disebut diagnosis.
                    </p>
                </details>

                <details class="group rounded-2xl border border-slate-200 bg-white p-5 open:shadow-sm">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold text-slate-950">
                        Kapan kuesioner dapat diisi?
                        <span class="grid size-8 shrink-0 place-items-center rounded-full bg-slate-100 text-slate-600 transition group-open:rotate-45">
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <p class="mt-3 text-sm leading-6 text-slate-600">
                        Setelah teks DASS-21 Indonesia yang sah, kriteria peserta, dan teks persetujuan
                        responden disetujui dosen pembimbing.
                    </p>
                </details>
            </div>
        </div>
    </section>

    <section class="bg-white">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-[2rem] bg-emerald-950 p-8 text-white sm:p-10 lg:p-12">
                <div class="absolute inset-0 bg-soft-grid opacity-20" aria-hidden="true"></div>
                <div class="absolute -right-16 -top-16 size-64 rounded-full bg-emerald-500/20 blur-3xl" aria-hidden="true"></div>

                <div class="relative max-w-2xl">
                    <x-ui.badge tone="amber">Status pengembangan</x-ui.badge>
                    <h2 class="mt-4 text-3xl font-bold tracking-tight sm:text-4xl">
                        Kuesioner dibuka setelah instrumen dan persetujuan final.
                    </h2>
                    <p class="mt-4 text-sm leading-7 text-emerald-100/80 sm:text-base">
                        Kami tidak menampilkan formulir atau hasil dengan data contoh. Langkah ini penting
                        agar penelitian berjalan sesuai etika dan menghasilkan data yang dapat
                        dipertanggungjawabkan.
                    </p>
                    <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                        <x-ui.button href="{{ route('login') }}" variant="secondary" size="lg">
                            Masuk administrator
                        </x-ui.button>
                        <x-ui.button href="#faq" variant="inverse" size="lg">
                            Baca pertanyaan umum
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
