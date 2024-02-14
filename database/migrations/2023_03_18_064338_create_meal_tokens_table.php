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
        Schema::create('meal_tokens', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->string('food_name');
            $table->date('date');
            $table->integer('rollno');
            $table->string('meal_type');
            $table->integer('quantity');
            $table->integer('status');
            $table->string('token_number');
            $table->integer('hall_id')->references('id')->on('halls')->nullable();
            $table->integer('print')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_tokens');
    }
};
