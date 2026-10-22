<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->string('subdistrict', 100)->nullable()->after('wonosobo_resident')->index();
        });

        DB::table('consent_versions')
            ->where('status', 'active')
            ->update(['status' => 'approved_for_use']);

        DB::table('consent_versions')
            ->where('status', 'verified')
            ->update(['status' => 'ready_for_review']);

        DB::table('consent_versions')
            ->where('status', 'pending_verification')
            ->update(['status' => 'incomplete']);

        DB::table('research_settings')
            ->whereNull('age_verification_method')
            ->update(['age_verification_method' => 'birth_year_plus_age_confirmation']);
    }

    public function down(): void
    {
        DB::table('consent_versions')
            ->where('status', 'approved_for_use')
            ->where('is_active', true)
            ->update(['status' => 'active']);

        DB::table('consent_versions')
            ->where('status', 'approved_for_use')
            ->update(['status' => 'verified']);

        DB::table('consent_versions')
            ->whereIn('status', ['incomplete', 'pending_ethics'])
            ->update(['status' => 'pending_verification']);

        DB::table('consent_versions')
            ->where('status', 'ready_for_review')
            ->update(['status' => 'verified']);

        Schema::table('submissions', function (Blueprint $table) {
            $table->dropIndex(['subdistrict']);
            $table->dropColumn('subdistrict');
        });
    }
};
