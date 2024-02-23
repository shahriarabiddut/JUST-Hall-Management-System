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
        Schema::create('halls', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('banglatitle');
            $table->string('logo');
            $table->integer('staff_id')->references('id')->on('staff');
            $table->integer('type');
            $table->integer('status')->nullable();
            $table->integer('print');
            $table->string('secret');
            $table->integer('fixed_cost');
            $table->integer('fixed_cost_masters');
            $table->integer('payment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('halls');
    }
};
