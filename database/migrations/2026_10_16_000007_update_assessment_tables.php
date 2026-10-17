<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add option text (the readable description shown to users)
        Schema::table('assessment_options', function (Blueprint $table) {
            $table->text('text')->nullable()->after('label');
        });

        // Add startup context fields to attempts; make user_id nullable for guest use
        Schema::table('assessment_attempts', function (Blueprint $table) {
            $table->string('startup_name')->nullable()->after('user_id');
            $table->string('founder_name')->nullable()->after('startup_name');
            $table->string('sector')->nullable()->after('founder_name');
            $table->foreignId('user_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('assessment_options', function (Blueprint $table) {
            $table->dropColumn('text');
        });

        Schema::table('assessment_attempts', function (Blueprint $table) {
            $table->dropColumn(['startup_name', 'founder_name', 'sector']);
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};
