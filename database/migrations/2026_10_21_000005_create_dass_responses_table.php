<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dass_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('submission_id')
                ->unique()
                ->constrained('submissions')
                ->cascadeOnDelete();

            // DASS-21 disimpan sebagai 21 kolom agar rentang 0-3 mudah diperiksa.
            for ($item = 1; $item <= 21; $item++) {
                $table->unsignedTinyInteger(sprintf('item_%02d', $item));
            }

            $table->timestamps();
        });

        if (DB::connection()->getDriverName() === 'mysql') {
            $checks = [];

            for ($item = 1; $item <= 21; $item++) {
                $checks[] = sprintf('`item_%02d` BETWEEN 0 AND 3', $item);
            }

            DB::statement(
                'ALTER TABLE `dass_responses` ADD CONSTRAINT `dass_responses_items_range` CHECK ('.implode(' AND ', $checks).')'
            );
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('dass_responses');
    }
};
