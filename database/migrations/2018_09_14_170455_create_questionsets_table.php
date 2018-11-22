<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionsets', function (Blueprint $table) {
            $table->increments('id');
			$table->string('title', 50);
			$table->string('description', 255);
			$table->integer('numofques')->nullable();
			$table->integer('level');
			$table->integer('passnum');
			$table->integer('time');
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
        Schema::dropIfExists('questionsets');
    }
}
