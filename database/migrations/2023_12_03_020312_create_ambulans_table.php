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
        Schema::create('ambulans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->string('telepon');
            $table->string('wa');
            $table->boolean('available')->default(false);
            $table->boolean('free')->default(false);
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 11, 7);
            $table->timestamps();
            $table->string('username')->unique();
            $table->string('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ambulans');
    }
};
