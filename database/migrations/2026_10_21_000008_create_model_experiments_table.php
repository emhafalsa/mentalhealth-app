<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('model_experiments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('version', 50)->unique();
            $table->foreignId('instrument_version_id')
                ->constrained('instrument_versions')
                ->restrictOnDelete();
            $table->string('feature_set_version', 20)->default('v1');
            $table->enum('status', ['queued', 'running', 'succeeded', 'failed'])
                ->default('queued')
                ->index();
            $table->string('dataset_hash', 64)->nullable()->index();
            $table->unsignedInteger('row_count')->default(0);
            $table->json('feature_list')->nullable();
            $table->json('training_config')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->string('error_code', 50)->nullable();
            $table->text('error_message_safe')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('model_experiments');
    }
};
