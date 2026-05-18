<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Countries table
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->char('code', 2)->unique();   // ISO alpha-2 e.g. NG, GH, US
            $table->string('phone_code', 10)->nullable(); // e.g. +234
            $table->string('flag', 10)->nullable();       // emoji flag e.g. 🇳🇬
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Add country_id to states (nullable for existing rows)
        Schema::table('states', function (Blueprint $table) {
            $table->foreignId('country_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('countries')
                  ->onDelete('cascade');
        });

        // 3. Add phone + city_id to users (nullable)
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->after('state_id');
            $table->foreignId('city_id')
                  ->nullable()
                  ->after('phone')
                  ->constrained('cities')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropColumn(['city_id', 'phone']);
        });

        Schema::table('states', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropColumn('country_id');
        });

        Schema::dropIfExists('countries');
    }
};
