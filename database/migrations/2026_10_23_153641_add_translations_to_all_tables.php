<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add English (_en) translation columns to all content tables.
 * Existing columns are treated as Indonesian (the base language).
 * _en columns are nullable; views fall back to the base column when empty.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assessment_dimensions', function (Blueprint $table) {
            $table->string('name_en')->nullable()->after('name');
            $table->text('description_en')->nullable()->after('description');
        });

        Schema::table('assessment_questions', function (Blueprint $table) {
            $table->text('question_en')->nullable()->after('question');
        });

        Schema::table('assessment_options', function (Blueprint $table) {
            $table->string('label_en')->nullable()->after('label');
            $table->text('text_en')->nullable()->after('text');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->string('summary_en', 500)->nullable()->after('summary');
            $table->longText('description_en')->nullable()->after('description');
        });

        Schema::table('event_sessions', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->string('excerpt_en', 500)->nullable()->after('excerpt');
            $table->longText('body_en')->nullable()->after('body');
        });

        Schema::table('speakers', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->string('expertise_en')->nullable()->after('expertise');
            $table->text('bio_en')->nullable()->after('bio');
        });

        Schema::table('toolkits', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->text('description_en')->nullable()->after('description');
            $table->string('duration_label_en')->nullable()->after('duration_label');
        });

        Schema::table('incubation_programs', function (Blueprint $table) {
            $table->string('name_en')->nullable()->after('name');
            $table->text('description_en')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('assessment_dimensions', fn (Blueprint $t) => $t->dropColumn(['name_en', 'description_en']));
        Schema::table('assessment_questions', fn (Blueprint $t) => $t->dropColumn('question_en'));
        Schema::table('assessment_options', fn (Blueprint $t) => $t->dropColumn(['label_en', 'text_en']));
        Schema::table('events', fn (Blueprint $t) => $t->dropColumn(['title_en', 'summary_en', 'description_en']));
        Schema::table('event_sessions', fn (Blueprint $t) => $t->dropColumn('title_en'));
        Schema::table('posts', fn (Blueprint $t) => $t->dropColumn(['title_en', 'excerpt_en', 'body_en']));
        Schema::table('speakers', fn (Blueprint $t) => $t->dropColumn(['title_en', 'expertise_en', 'bio_en']));
        Schema::table('toolkits', fn (Blueprint $t) => $t->dropColumn(['title_en', 'description_en', 'duration_label_en']));
        Schema::table('incubation_programs', fn (Blueprint $t) => $t->dropColumn(['name_en', 'description_en']));
    }
};
