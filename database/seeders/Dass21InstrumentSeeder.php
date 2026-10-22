<?php

namespace Database\Seeders;

use App\Enums\InstrumentStatus;
use App\Models\InstrumentVersion;
use Illuminate\Database\Seeder;

class Dass21InstrumentSeeder extends Seeder
{
    public function run(): void
    {
        $instrument = InstrumentVersion::query()->firstOrCreate(
            [
                'code' => 'dass21',
                'version' => 'id-damanik-2026-10-21',
            ],
            [
                'locale' => 'id',
                'status' => InstrumentStatus::PendingVerification,
                'source_reference' => 'DASS42 Bahasa Indonesia — terjemahan Evelina Damanik; DASS21 English response form',
                'source_url' => 'https://dass.psy.unsw.edu.au/Indonesian/Damanik.htm',
                'source_retrieved_at' => '2026-10-21',
                'translator' => 'Evelina Damanik, M.Psi',
                'copyright_status' => 'Public domain; restricted research use; not for open public access',
                'verification_notes' => 'Teks 21 butir disusun dari DASS42 Bahasa Indonesia Damanik dengan urutan DASS21 English response form. Metadata dan teks sumber sudah diperiksa; status penelitian dan ambang kategori tetap perlu disetujui peneliti/dosen pembimbing sebelum aktivasi.',
                'instructions' => config('dass21.instructions'),
                'response_options' => config('dass21.response_options'),
                'item_texts' => [
                    'Saya merasa sulit untuk beristirahat.',
                    'Saya merasa bibir saya sering kering.',
                    'Saya sama sekali tidak dapat merasakan perasaan positif.',
                    'Saya mengalami kesulitan bernafas (misalnya: seringkali terengah-engah atau tidak dapat bernafas padahal tidak melakukan aktivitas fisik sebelumnya).',
                    'Saya merasa sulit untuk meningkatkan inisiatif dalam melakukan sesuatu.',
                    'Saya cenderung bereaksi berlebihan terhadap suatu situasi.',
                    'Saya merasa gemetar (misalnya: pada tangan).',
                    'Saya merasa telah menghabiskan banyak energi untuk merasa cemas.',
                    'Saya merasa khawatir dengan situasi dimana saya mungkin menjadi panik dan mempermalukan diri sendiri.',
                    'Saya merasa tidak ada hal yang dapat diharapkan di masa depan.',
                    'Saya menemukan diri saya mudah gelisah.',
                    'Saya merasa sulit untuk bersantai.',
                    'Saya merasa putus asa dan sedih.',
                    'Saya tidak dapat memaklumi hal apapun yang menghalangi saya untuk menyelesaikan hal yang sedang saya lakukan.',
                    'Saya merasa saya hampir panik.',
                    'Saya tidak merasa antusias dalam hal apapun.',
                    'Saya merasa bahwa saya tidak berharga sebagai seorang manusia.',
                    'Saya merasa bahwa saya mudah tersinggung.',
                    'Saya menyadari kegiatan jantung, walaupun saya tidak sehabis melakukan aktivitas fisik (misalnya: merasa detak jantung meningkat atau melemah).',
                    'Saya merasa takut tanpa alasan yang jelas.',
                    'Saya merasa bahwa hidup tidak berarti.',
                ],
                'item_subscale_map' => config('dass21.item_subscale_map'),
                'severity_thresholds' => config('dass21.severity_thresholds'),
                'response_scale' => config('dass21.response_values'),
                'is_active' => false,
            ],
        );

        if ($instrument->wasRecentlyCreated) {
            $this->command?->info('Instrumen DASS-21 Damanik ditambahkan sebagai draf menunggu verifikasi.');
        } else {
            $this->command?->warn('Instrumen DASS-21 Damanik sudah ada; tidak diubah.');
        }
    }
}
