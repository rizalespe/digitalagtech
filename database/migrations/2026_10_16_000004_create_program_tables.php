<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Business Incubation: Jagoan Tani Banyuwangi, Kita Tani Muda Semarang, ...
        Schema::create('incubation_programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('cover_image')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('incubation_program_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incubation_program_id')->constrained()->cascadeOnDelete();
            $table->string('image');
            $table->string('caption')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // Self-Learning Program toolkits
        Schema::create('toolkits', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('stage', 20)->index()->comment('discover | build | scale');
            $table->text('description');
            $table->string('thumbnail')->nullable();
            $table->string('video_url')->nullable();
            $table->string('pdf_path')->nullable();
            $table->unsignedSmallInteger('tools_count')->default(0);
            $table->unsignedSmallInteger('activities_count')->default(0);
            $table->string('duration_label')->nullable()->comment('mis. "2–3 Hours"');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toolkits');
        Schema::dropIfExists('incubation_program_photos');
        Schema::dropIfExists('incubation_programs');
    }
};
