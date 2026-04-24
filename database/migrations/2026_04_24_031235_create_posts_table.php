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
        Schema::create('posts', function (Blueprint $table) {
    $table->id();

    $table->string('title');
    $table->string('slug')->unique();
    $table->text('excerpt')->nullable();
    $table->longText('content');

    $table->string('thumbnail')->nullable();

    $table->foreignId('category_id')->constrained()->cascadeOnDelete();
    $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();

    $table->enum('status', ['draft', 'review', 'published', 'archived'])->default('draft');

    $table->timestamp('published_at')->nullable();
    $table->boolean('is_featured')->default(false);

    $table->unsignedBigInteger('views_count')->default(0);

    $table->string('meta_title')->nullable();
    $table->text('meta_description')->nullable();

    $table->timestamps();
    $table->softDeletes();

    $table->index(['status', 'published_at']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
