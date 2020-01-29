<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('title_en')->default('')->nullable();

            $table->text('briefing')->nullable();

            $table->integer('cat_id')->unsinged()->nullable();
            $table->mediumText('body')->nullable();
            $table->integer('ranking')->default(0);
            $table->string('photoPath')->nullable();
            $table->string('pdfPath')->nullable();

            $table->boolean('published');
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
        Schema::dropIfExists('products');
    }
}
