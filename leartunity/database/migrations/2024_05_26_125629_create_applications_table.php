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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained("users")->cascadeOnDelete();
            $table->string("fullname");
            $table->string("qualification");
            $table->text("cover_letter");
            $table->string("supporting_file")->nullable();
            $table->integer("status")->default(0);
            $table->timestamp("cooldown_till");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
