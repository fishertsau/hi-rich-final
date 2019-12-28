<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject')->default('default-subject');
            $table->text('message')->nullable();
            $table->string('company_name');
            $table->string('contact')->default('default-contact');
            $table->string('address')->default('default-address');
            $table->string('tel');
            $table->string('fax')->nullable();
            $table->string('email');
            $table->string('material');
            $table->string('purpose');
            $table->string('spec');
            $table->string('estimated_qty');
            $table->string('viscosity');
            $table->string('surface_treatment');
            $table->string('packing');
            $table->string('print_out');
            $table->boolean('processed')->default(false);
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
        Schema::dropIfExists('inquiries');
    }
}
