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
        Schema::create('training_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_track_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->text('summary');
            $table->longText('content');
            $table->json('key_takeaways')->nullable();
            $table->integer('duration_minutes')->default(45);
            $table->integer('order_number')->default(1);
            $table->string('resource_type')->default('article'); // article, video, hands_on, case_study
            $table->string('resource_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_modules');
    }
};
