<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentquestionpapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studentquestionpapers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('questionset_id');
			$table->string('result');
			$table->integer('default_time');
			$table->integer('time_spent');
			$table->integer('is_complete');
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
        Schema::dropIfExists('studentquestionpapers');
    }
}
