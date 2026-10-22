<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supporting_factors', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('submission_id')
                ->unique()
                ->constrained('submissions')
                ->cascadeOnDelete();
            $table->string('education_status', 50);
            $table->string('employment_status', 50);
            $table->decimal('sleep_duration_hours', 3, 1);
            $table->unsignedTinyInteger('physical_activity_days');
            $table->decimal('social_media_hours_per_day', 3, 1);
            $table->unsignedTinyInteger('social_support_score')->nullable();
            $table->timestamps();
        });

        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement(
                'ALTER TABLE `supporting_factors` ADD CONSTRAINT `supporting_factors_ranges` CHECK ('
                .'`sleep_duration_hours` BETWEEN 0 AND 24 AND '
                .'`physical_activity_days` BETWEEN 0 AND 7 AND '
                .'`social_media_hours_per_day` BETWEEN 0 AND 24 AND '
                .'(`social_support_score` IS NULL OR `social_support_score` BETWEEN 1 AND 5)'
                .')'
            );
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('supporting_factors');
    }
};
