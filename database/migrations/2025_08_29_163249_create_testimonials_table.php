<?php

use App\Enums\Provider;
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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('hashid')->nullable();
            $table->string('name');
            $table->string('tagline')->nullable();
            $table->string('photo')->nullable();
            $table->string('cover')->nullable();
            $table->string('video_id')->nullable();
            $table->string('provider')->default(Provider::YOUTUBE);
            $table->boolean('active')->default(true);
            $table->string('disk')->default(config('app.disk'));
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
