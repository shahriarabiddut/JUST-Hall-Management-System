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
            $table->integer('student_id')->references('id')->on('users');
            $table->integer('staff_id')->references('id')->on('staff')->nullable();
            $table->integer('amount');
            $table->string('payment_method');
            $table->text('mobileno')->nullable();
            $table->string('transid')->nullable();
            $table->integer('status');
            $table->string('createdby');
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
