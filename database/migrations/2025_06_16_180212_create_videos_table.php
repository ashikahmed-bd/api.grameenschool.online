<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('hashid')->nullable();
            $table->foreignId('lecture_id')->unique()->constrained()->cascadeOnDelete();

            $table->string('title')->nullable()->comment('optional: video title');
            $table->string('video_id')->nullable()->comment('e.g., YouTube/Vimeo ID');
            $table->enum('provider', ['youtube', 'vimeo'])->default('youtube');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
