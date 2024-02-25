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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->unsignedBigInteger("contentable_id");
            $table->string("contentable_type");
            $table->boolean("status");
            $table->string("content");
            $table->bigInteger("duration");
            $table->boolean("is_paid");
            $table->integer("sequence");
            $table->text("description");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
