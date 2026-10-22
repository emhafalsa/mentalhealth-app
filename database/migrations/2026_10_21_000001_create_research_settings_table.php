<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('research_settings', function (Blueprint $table) {
            $table->id();
            $table->string('research_title')->nullable();
            $table->string('researcher_name')->nullable();
            $table->string('institution')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone', 30)->nullable();
            $table->unsignedSmallInteger('genz_birth_year_start')->nullable();
            $table->unsignedSmallInteger('genz_birth_year_end')->nullable();
            $table->unsignedTinyInteger('minimum_age')->default(18);
            $table->unsignedSmallInteger('retention_months')->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('research_settings');
    }
};
