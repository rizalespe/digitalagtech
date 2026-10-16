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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('type', 20)->index()->comment('webinar | workshop');
            $table->string('summary', 500)->nullable();
            $table->longText('description')->nullable();
            $table->dateTime('starts_at')->index();
            $table->dateTime('ends_at')->nullable();
            $table->string('location')->nullable()->comment('Nama tempat atau platform, mis. "Zoom Meeting"');
            $table->string('city')->nullable();
            $table->boolean('is_online')->default(false);
            $table->string('meeting_url')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('flyer')->nullable();
            $table->json('workshop_cities')->nullable()->comment('Kota lanjutan workshop yang ditampilkan di "Current Event"');
            $table->unsignedInteger('quota')->nullable();
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('registration_open')->default(true);
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('event_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->time('starts_at');
            $table->time('ends_at');
            $table->string('title');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('event_speaker', function (Blueprint $table) {
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('speaker_id')->constrained()->cascadeOnDelete();
            $table->string('role')->nullable()->comment('Keynote, Panelis, Moderator, ...');
            $table->primary(['event_id', 'speaker_id']);
        });

        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('status', 20)->default('registered')->index()->comment('registered | approved | rejected | attended | cancelled');
            $table->text('motivation')->nullable();
            $table->timestamps();

            $table->unique(['event_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
        Schema::dropIfExists('event_speaker');
        Schema::dropIfExists('event_sessions');
        Schema::dropIfExists('events');
    }
};
