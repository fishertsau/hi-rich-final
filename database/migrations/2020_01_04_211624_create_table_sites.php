<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('tel')->nullable();
            $table->string('fax')->nullable();
            $table->string('address')->nullable();
            $table->string('google_map')->nullable();
            $table->string('email')->nullable();
            $table->boolean('published')->defalut(true);
            $table->tinyInteger('ranking');
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
        Schema::dropIfExists('abouts');
    }
}
