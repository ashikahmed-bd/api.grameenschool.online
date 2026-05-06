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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('hashid')->nullable();

            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('categories');

            $table->string('name');
            $table->string('slug')->unique();
            $table->text('overview')->nullable();
            $table->string('icon')->default('');

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();

            $table->integer('sort_order')->default(0);
            $table->boolean('active')->default(true);
            $table->string('disk')->default(config('app.disk'));
            $table->timestamps();
            $table->softDeletes();

            $table->index(['parent_id', 'active', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
