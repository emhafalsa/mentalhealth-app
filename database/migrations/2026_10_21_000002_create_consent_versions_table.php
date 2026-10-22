<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consent_versions', function (Blueprint $table) {
            $table->id();
            $table->string('version', 50)->unique();
            $table->string('title');
            $table->longText('body');
            $table->string('content_hash', 64);
            $table->timestamp('effective_from')->nullable();
            $table->boolean('is_active')->default(false)->index();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consent_versions');
    }
};
