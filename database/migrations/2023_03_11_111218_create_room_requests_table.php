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
        Schema::create('room_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('room_id');
            $table->longText('application');
            $table->integer('status')->nullable();
            $table->integer('flag')->nullable();
            $table->integer('allocated_seat_id')->nullable();
            $table->integer('hall_id')->references('id')->on('halls');
            $table->dateTime('visited_at')->nullable();
            $table->integer('visitor')->nullable();
            $table->integer('recommendation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_requests');
    }
};
