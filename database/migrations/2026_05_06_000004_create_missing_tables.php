<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Categories Table (Admin managed)
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon')->nullable();
            $table->string('popularity')->default('low');
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        // 2. Vendor Categories Pivot
        Schema::create('category_vendor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        // 3. Wishlists (User -> Meal)
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('meal_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'meal_id']);
        });

        // 4. Blog Comments
        Schema::create('blog_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('body');
            $table->timestamps();
        });

        // 5. Blog Likes
        Schema::create('blog_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['blog_post_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_likes');
        Schema::dropIfExists('blog_comments');
        Schema::dropIfExists('wishlists');
        Schema::dropIfExists('category_vendor');
        Schema::dropIfExists('categories');
    }
};
