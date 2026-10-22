<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instrument_versions', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50);
            $table->string('version', 50);
            $table->string('locale', 10)->default('id');
            $table->string('source_reference')->nullable();
            $table->json('item_subscale_map');
            $table->json('severity_thresholds');
            $table->json('response_scale')->nullable();
            $table->boolean('is_active')->default(false)->index();
            $table->timestamp('effective_from')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['code', 'version']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instrument_versions');
    }
};
