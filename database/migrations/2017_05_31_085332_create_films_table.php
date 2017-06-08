<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('films', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('genre', 100);
            $table->text('synopsis')->nullable();
            $table->tinyInteger('release_status');
            $table->date('release_date')->nullable();
            $table->tinyInteger('rating')->nullable();
            //$table->tinyInteger('rating')->nullable();
            $table->string('running_time', 100)->nullable();
            $table->string('sell_sheet')->nullable();
            $table->string('hash_tags', 100)->nullable();
            //$table->integer('genre_id')->unsigned();
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
        Schema::dropIfExists('films');
    }
}
