<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('model_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('model_experiment_id')
                ->constrained('model_experiments')
                ->cascadeOnDelete();
            $table->enum('target', ['depresi', 'kecemasan', 'stres']);

            $table->decimal('accuracy', 8, 6);
            $table->decimal('precision_macro', 8, 6);
            $table->decimal('recall_macro', 8, 6);
            $table->decimal('f1_macro', 8, 6);
            $table->decimal('precision_weighted', 8, 6);
            $table->decimal('recall_weighted', 8, 6);
            $table->decimal('f1_weighted', 8, 6);

            $table->json('confusion_matrix');
            $table->json('per_class_metrics');
            $table->unsignedInteger('train_count');
            $table->unsignedInteger('test_count');
            $table->json('class_distribution');
            $table->string('artifact_path');
            $table->string('artifact_hash', 64);
            $table->string('sklearn_version', 30)->nullable();
            $table->timestamps();

            $table->unique(['model_experiment_id', 'target']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('model_evaluations');
    }
};
