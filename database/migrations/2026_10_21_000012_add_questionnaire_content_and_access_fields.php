<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('instrument_versions', function (Blueprint $table) {
            $table->text('instructions')->nullable();
            $table->json('item_texts')->nullable();
            $table->json('response_options')->nullable();
        });

        Schema::table('research_settings', function (Blueprint $table) {
            $table->string('access_code_hash')->nullable();
        });

        Schema::table('submissions', function (Blueprint $table) {
            $table->unsignedTinyInteger('age_at_submission')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropColumn('age_at_submission');
        });

        Schema::table('research_settings', function (Blueprint $table) {
            $table->dropColumn('access_code_hash');
        });

        Schema::table('instrument_versions', function (Blueprint $table) {
            $table->dropColumn(['instructions', 'item_texts', 'response_options']);
        });
    }
};
