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
        Schema::create('certificate_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")
                    ->constrained("users")
                    ->cascadeOnDelete();
            $table->foreignId("course_id")
                    ->constrained("courses")
                    ->cascadeOnDelete();
            $table->string("certificate");
            $table->boolean("status");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_user');
    }
};
