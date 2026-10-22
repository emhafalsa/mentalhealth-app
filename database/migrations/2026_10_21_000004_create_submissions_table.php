<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->unsignedSmallInteger('birth_year');
            $table->boolean('wonosobo_resident')->default(false);
            $table->boolean('eligible')->default(false);
            $table->foreignId('consent_version_id')->constrained('consent_versions')->restrictOnDelete();
            $table->timestamp('consent_accepted_at');
            $table->enum('data_status', ['valid', 'excluded'])->default('valid');
            $table->text('exclusion_reason')->nullable();
            $table->timestamp('submitted_at')->index();
            $table->timestamps();

            $table->index(['data_status', 'submitted_at']);
            $table->index('eligible');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
