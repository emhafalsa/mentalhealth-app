<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('instrument_versions', function (Blueprint $table) {
            $table->string('status', 30)->default('draft')->index();
            $table->string('source_url', 2048)->nullable();
            $table->timestamp('source_retrieved_at')->nullable();
            $table->string('translator')->nullable();
            $table->string('copyright_status', 100)->nullable();
            $table->text('verification_notes')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
        });

        Schema::table('consent_versions', function (Blueprint $table) {
            $table->string('status', 30)->default('draft')->index();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
        });

        Schema::table('research_settings', function (Blueprint $table) {
            $table->string('region_definition')->nullable();
            $table->date('study_start_date')->nullable();
            $table->date('study_end_date')->nullable();
            $table->string('age_verification_method', 50)->nullable();
            $table->string('access_mode', 30)->nullable();
            $table->string('ethics_confirmation_status', 50)->nullable();
            $table->string('ethics_reference')->nullable();
            $table->text('deletion_procedure')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('research_settings', function (Blueprint $table) {
            $table->dropColumn([
                'region_definition',
                'study_start_date',
                'study_end_date',
                'age_verification_method',
                'access_mode',
                'ethics_confirmation_status',
                'ethics_reference',
                'deletion_procedure',
            ]);
        });

        Schema::table('consent_versions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('verified_by');
            $table->dropColumn(['status', 'verified_at']);
        });

        Schema::table('instrument_versions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('verified_by');
            $table->dropColumn([
                'status',
                'source_url',
                'source_retrieved_at',
                'translator',
                'copyright_status',
                'verification_notes',
                'verified_at',
            ]);
        });
    }
};
