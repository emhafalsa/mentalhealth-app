<?php

namespace Database\Seeders;

use App\Models\ResearchSetting;
use Illuminate\Database\Seeder;

class ResearchSettingSeeder extends Seeder
{
    public function run(): void
    {
        ResearchSetting::current();
    }
}
