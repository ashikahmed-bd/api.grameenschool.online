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
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('hashid')->nullable();

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('badge')->nullable();
            $table->text('description')->nullable();
            $table->string('icon')->default('');
            $table->string('banner')->default('');

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();

            $table->boolean('active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->string('disk')->default(config('app.disk'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};
