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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->double('amount');
            $table->longText('address');
            $table->string('status');
            $table->string('transaction_id');
            $table->string('currency');
            $table->integer('student_id')->references('id')->on('users')->nullable();
            $table->integer('staff_id')->references('id')->on('staff')->nullable();
            $table->string('type')->nullable();
            $table->string('proof')->nullable();
            $table->integer('hall_id')->references('id')->on('halls')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
