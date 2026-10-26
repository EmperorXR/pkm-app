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
        Schema::create('training_tracks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('icon')->default('sparkles');
            $table->string('level')->default('Pemula - Menengah');
            $table->integer('duration_hours')->default(16);
            $table->string('instructor_name')->default('Dr. Eng. Tim Pengabdian AI');
            $table->string('instructor_title')->default('Pakar Artificial Intelligence & Sistem Terdistribusi');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_tracks');
    }
};
