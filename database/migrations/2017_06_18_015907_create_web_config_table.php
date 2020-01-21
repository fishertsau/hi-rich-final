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

            //product display control
            // todo: remove this ??? 
            $table->tinyInteger('product_show_per_page')->unsigned()->default(20)->nullable();

            //company info
            $table->string('company_name')->nullable();
            $table->string('address')->nullable();
            $table->string('tel')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();

            //marketing introduction
            $table->string('slogan')->nullable();
            $table->string('slogan_sub')->nullable();
            $table->mediumText('product')->nullable();
            $table->mediumText('place')->nullable();
            $table->mediumText('location')->nullable();
            $table->mediumText('service_hour')->nullable();

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
            $table->string('photoPath')->nullable();
            $table->string('pdfPath')->nullable();

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
