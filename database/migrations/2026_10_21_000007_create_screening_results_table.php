<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('screening_results', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('submission_id')
                ->unique()
                ->constrained('submissions')
                ->cascadeOnDelete();
            $table->foreignId('instrument_version_id')
                ->constrained('instrument_versions')
                ->restrictOnDelete();

            $table->unsignedTinyInteger('depression_raw');
            $table->unsignedTinyInteger('depression_final');
            $table->enum('depression_category', ['normal', 'ringan', 'sedang', 'berat', 'sangat_berat'])
                ->index();

            $table->unsignedTinyInteger('anxiety_raw');
            $table->unsignedTinyInteger('anxiety_final');
            $table->enum('anxiety_category', ['normal', 'ringan', 'sedang', 'berat', 'sangat_berat'])
                ->index();

            $table->unsignedTinyInteger('stress_raw');
            $table->unsignedTinyInteger('stress_final');
            $table->enum('stress_category', ['normal', 'ringan', 'sedang', 'berat', 'sangat_berat'])
                ->index();

            $table->timestamp('computed_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('screening_results');
    }
};
