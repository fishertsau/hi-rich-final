<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('title_en')->nullable();
            $table->mediumText('body')->nullable();
            $table->mediumText('body_en')->nullable();
            $table->boolean('published')->default(true);
            $table->dateTime('published_since')->nullable();
            $table->dateTime('published_until')->nullable();
            $table->integer('ranking')->default(0);
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
        Schema::dropIfExists('news');
    }
}
