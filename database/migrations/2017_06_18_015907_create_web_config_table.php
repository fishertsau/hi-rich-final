<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_config', function (Blueprint $table) {
            $table->increments('id');

            //company info
            $table->string('company_name')->nullable();
            $table->string('address')->nullable();
            $table->string('tel')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();

            //marketing introduction
            $table->string('slogan')->nullable();
            $table->string('slogan_sub')->nullable();
            $table->text('product')->nullable();
            $table->text('place')->nullable();
            $table->string('service_week')->nullable();
            $table->string('service_hour')->nullable();

            //site header info
            $table->string('title')->nullable();
            $table->string('keywords')->nullable();
            $table->string('description')->nullable();
            $table->string('meta')->nullable();

            //mail setting
            $table->string('mail_service_provider')->nullable();
            $table->string('mail_receivers')->nullable();

            //others
            $table->mediumText('contact_ok')->nullable();
            $table->string('copyright_declare')->nullable();
            $table->string('logoA_photoPath')->default('')->nullable();
            $table->string('logoB_photoPath')->default('')->nullable();
            $table->string('pdfPath')->default('')->nullable();

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
        Schema::dropIfExists('web_config');
    }
}
