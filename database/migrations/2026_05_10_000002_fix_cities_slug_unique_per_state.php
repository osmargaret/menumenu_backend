<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            // Drop the global unique index on slug alone
            $table->dropUnique(['slug']);

            // Add a composite unique index: slug unique within each state
            $table->unique(['state_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropUnique(['state_id', 'slug']);
            $table->unique(['slug']);
        });
    }
};
