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
        Schema::create('allocated_seats', function (Blueprint $table) {
            $table->id();
            $table->integer('room_id');
            $table->integer('user_id');
            $table->integer('position');
            $table->integer('hall_id')->references('id')->on('halls');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allocated_seats');
    }
};
