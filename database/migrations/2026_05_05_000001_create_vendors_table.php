<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->string('tagline')->nullable();
            $table->text('description')->nullable();
            $table->string('banner_path')->nullable();
            $table->string('avatar_path')->nullable();
            $table->foreignId('state_id')->constrained('states')->onDelete('cascade');
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('set null');
            $table->string('address')->nullable();
            $table->boolean('is_open')->default(false);
            $table->time('open_time')->nullable();
            $table->time('close_time')->nullable();
            $table->boolean('delivery_available')->default(true);
            $table->boolean('pickup_available')->default(true);
            $table->unsignedTinyInteger('commission_percent')->default(10);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
