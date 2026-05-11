<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('moderations', function (Blueprint $table) {
            $table->id();
            $table->morphs('moderatable');
            $table->foreignId('moderator_id')->nullable()->constrained('admins');
            $table->string('purpose')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->text('reason')->nullable();
            $table->timestamp('moderated_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('moderations');
    }
};
