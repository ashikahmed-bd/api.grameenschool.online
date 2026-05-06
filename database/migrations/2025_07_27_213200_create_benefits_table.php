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
        Schema::create('benefits', function (Blueprint $table) {
            $table->id();
            $table->string('hashid')->unique()->nullable();

            $table->string('title');
            $table->text('description')->nullable();
            $table->string('banner')->nullable();
            $table->string('provider')->default(Provider::YOUTUBE)->index();
            $table->string('video_id');
            $table->integer('sort_order')->default(0);
            $table->string('disk')->default(config('app.disk'));
            $table->timestamps();

            $table->index(['sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('benefits');
    }
};
