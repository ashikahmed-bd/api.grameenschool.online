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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('hashid')->unique()->nullable();
            $table->text('title')->nullable();
            $table->text('subtitle')->nullable();
            $table->string('image')->default('');
            $table->string('link')->nullable();
            $table->string('text')->nullable();
            $table->integer('sort_order')->default(0);
            $table->enum('target', ['_self', '_blank'])->default('_self');
            $table->string('disk')->default(config('app.disk'));
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
