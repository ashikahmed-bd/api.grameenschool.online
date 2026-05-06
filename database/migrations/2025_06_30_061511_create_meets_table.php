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
        Schema::create('meets', function (Blueprint $table) {
            $table->id();
            $table->string('hashid')->nullable();

            $table->foreignId('course_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('host_id')->constrained('users')->onDelete('cascade');
            $table->enum('provider', ['google_meet', 'zoom']);
            $table->string('topic');
            $table->string('meeting_id')->nullable();
            $table->text('join_url');
            $table->text('host_url')->nullable();
            $table->date('date')->comment('e.g 25 Feb 2026');
            $table->time('time')->comment('e.g 8:00 PM');
            $table->string('timezone')->default(config('app.timezone'));
            $table->enum('status', ['scheduled', 'started', 'ended', 'cancelled'])->default('scheduled');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meets');
    }
};
