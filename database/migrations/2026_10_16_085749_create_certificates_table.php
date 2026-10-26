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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_number')->unique();
            $table->string('verify_code')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('training_track_id')->constrained()->cascadeOnDelete();
            $table->foreignId('quiz_attempt_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('final_score', 5, 2);
            $table->date('issue_date');
            $table->string('status')->default('valid'); // valid, revoked
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
