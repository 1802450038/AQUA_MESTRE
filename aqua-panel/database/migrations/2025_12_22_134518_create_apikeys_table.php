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
        Schema::create('apikeys', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->boolean('is_active')->default(true);
            $table->foreignId('user_id')->constrained()->nullable();
            $table->foreignId('board_id')->constrained()->nullable()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apikeys');
    }
};
