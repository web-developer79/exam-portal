<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('registeredfor')->nullable();
            $table->string('altermobilenumber')->nullable();
            $table->string('fatherName')->nullable();
            $table->string('fatherOccupation')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('current_class')->nullable();
            $table->string('genaddressder')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode')->nullable();            
            $table->string('schoolName')->nullable();
            $table->string('schoolAddress')->nullable();
            $table->string('prefer_location')->nullable();
            $table->string('profilepic')->nullable();
            $table->string('sourcedetail')->nullable();
            $table->string('enrollmentid')->nullable();
            $table->integer('ispaymentdone')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_details');
    }
}
