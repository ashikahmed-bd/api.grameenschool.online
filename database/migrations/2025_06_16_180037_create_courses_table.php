<?php

use App\Enums\CourseLevel;
use App\Enums\CourseStatus;
use App\Enums\Provider;
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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('hashid')->nullable();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subcategory_id')->nullable()->constrained('categories', 'id')->cascadeOnDelete();
            $table->foreignId('collection_id')->nullable()->constrained('collections')->onDelete('set null');

            $table->foreignId('grade_id')->nullable()->constrained('grades')->nullOnDelete();
            $table->foreignId('batch_id')->nullable()->constrained('batches')->nullOnDelete();

            $table->string('title');
            $table->string('slug');
            $table->text('overview');
            $table->longText('description')->nullable();

            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();

            $table->decimal('base_price', 12, 2)->default(0);
            $table->decimal('price', 12, 2)->nullable();
            $table->integer('access_days')->nullable();

            $table->string('level')->default(CourseLevel::ALL->value);
            $table->boolean('is_feature')->default(false);

            $table->json('learnings')->nullable();
            $table->json('requirements')->nullable();
            $table->json('includes')->nullable();

            $table->string('cover')->nullable();
            $table->string('intro_id')->nullable();
            $table->string('status')->default(CourseStatus::DRAFT);
            $table->string('disk')->default(config('app.disk'));

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
