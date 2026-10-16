<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Startup Assessment / Diagnose Test: pertanyaan dikelompokkan per dimensi
 * (Market Fit, Scale, Traction, Funding, Product, Team), tiap jawaban punya skor,
 * dan hasil per dimensi disimpan sebagai snapshot di assessment_attempts.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assessment_dimensions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('assessment_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_dimension_id')->constrained()->cascadeOnDelete();
            $table->text('question');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('assessment_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_question_id')->constrained()->cascadeOnDelete();
            $table->string('label');
            $table->unsignedTinyInteger('score')->comment('0–100');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('assessment_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('total_score')->nullable()->comment('0–100');
            $table->string('stage')->nullable()->comment('Tahap hasil, mis. "Discover", "Build", "Scale"');
            $table->json('dimension_scores')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('assessment_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_attempt_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assessment_question_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assessment_option_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['assessment_attempt_id', 'assessment_question_id'], 'assessment_answers_attempt_question_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_answers');
        Schema::dropIfExists('assessment_attempts');
        Schema::dropIfExists('assessment_options');
        Schema::dropIfExists('assessment_questions');
        Schema::dropIfExists('assessment_dimensions');
    }
};
