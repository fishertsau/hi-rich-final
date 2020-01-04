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
            $table->tinyInteger('product_show_per_page')->unsigned()->default(20)->nullable();
            $table->boolean('category_photo_enabled')->default(false);

            //company introduction
            $table->string('intro_title')->nullable();
            $table->string('intro_subTitle')->nullable();
            $table->mediumText('intro')->nullable();
            $table->mediumText('intro_en')->nullable();
            $table->mediumText('gear_intro')->nullable();
            $table->mediumText('gear_intro_en')->nullable();

            //company info
            $table->string('category_description')->nullable();
            $table->string('address')->nullable();
            $table->string('address_en')->nullable();
            $table->string('address2')->nullable();
            $table->string('address2_en')->nullable();
            $table->string('tel')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('email2')->nullable();

            //site header info
            $table->string('title')->nullable();
            $table->string('title_en')->nullable();
            $table->string('keywords')->nullable();
            $table->string('keywords_en')->nullable();
            $table->string('description')->nullable();
            $table->string('description_en')->nullable();
            $table->string('meta')->nullable();
            $table->string('meta_en')->nullable();

            //mail setting
            $table->string('mail_service_provider')->nullable();
            $table->string('mail_receivers')->nullable();

            //Social Media
            $table->string('line_id')->nullable();
            $table->string('fb_url')->nullable();
            $table->string('pikebon_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('google_plus_url')->nullable();
            $table->string('pinterest_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('blog_url')->nullable();


            //others
            $table->string('google_map')->nullable();
            $table->mediumText('inquiry_info')->nullable();
            $table->mediumText('inquiry_info_en')->nullable();
            $table->string('google_track_code')->nullable();
            $table->mediumText('contact_ok')->nullable();
            $table->mediumText('contact_ok_en')->nullable();
            $table->mediumText('declare')->nullable();
            $table->mediumText('declare_en')->nullable();

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
