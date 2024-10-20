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
        Schema::create('course_tracker', function (Blueprint $table) {
            $table->id();
            $table->json("tracking");
            $table->foreignId("course_id")
                    ->constrained("courses")
                    ->cascadeOnDelete();
            $table->foreignId("user_id")
                    ->constrained("users")
                    ->cascadeOnDelete();
            $table->float("progress");
            $table->boolean("status");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_tracker');
    }
};
