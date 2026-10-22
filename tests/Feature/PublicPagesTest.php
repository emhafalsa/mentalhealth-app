<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    public function test_beranda_menampilkan_informasi_penelitian_tanpa_data_contoh(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Ruang sadar untuk')
            ->assertSee('DASS-21')
            ->assertSee('Bukan diagnosis')
            ->assertSee('Kuesioner belum dibuka untuk umum')
            ->assertSee(route('login'))
            ->assertDontSee('Daftar akun')
            ->assertDontSee('item_01')
            ->assertDontSee('Test User');
    }

    public function test_beranda_tidak_memakai_teks_butir_dass(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertDontSee('Saya merasa');
        $response->assertDontSee('Saya mengalami');
    }
}
