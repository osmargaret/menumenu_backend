<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('meal_id')->nullable()->constrained('meals')->onDelete('set null');
            $table->foreignId('kitchen_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->integer('price')->default(0);
            $table->integer('quantity')->default(1);
            $table->integer('subtotal')->default(0);
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
