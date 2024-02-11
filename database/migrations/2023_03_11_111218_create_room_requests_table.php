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
            $table->string('banglaname');
            $table->string('englishname');
            $table->string('fathername');
            $table->string('mothername');
            $table->date('dob');
            $table->string('nationality');
            $table->string('religion');
            $table->string('maritalstatus');
            $table->string('village');
            $table->string('postoffice');
            $table->string('thana');
            $table->string('zilla');
            $table->string('parentmobile');
            $table->string('mobile');
            $table->string('presentaddress');
            $table->string('applicanthouse');
            $table->string('occupation');
            $table->string('ovivabok')->nullable();
            $table->string('ovivabokrelation')->nullable();
            $table->string('ovivabokthikana')->nullable();
            $table->string('ovivabokmobile')->nullable();
            $table->string('department');
            $table->string('rollno');
            $table->string('registrationno');
            $table->string('session');
            $table->string('borsho');
            $table->string('semester');
            $table->string('culture')->nullable();
            $table->string('otisitic')->nullable();
            $table->string('dobsonod');
            $table->string('academic');
            $table->string('earningproof');
            $table->string('signature');
            $table->integer('status')->nullable();
            $table->integer('flag')->nullable();
            $table->integer('allocated_seat_id')->nullable();
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
