<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->string('merch_name')->nullable();
            $table->string('merch_type')->default('seller');
            $table->string('store_category')->nullable();
            $table->string('office_tel')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('email')->nullable();
            $table->text('office_address');
            $table->string('zip_code');
            $table->string('area')->nullable();
            $table->string('state');
            $table->string('country');
            $table->string('country_code');
            $table->string('curr');
            $table->string('reg_no')->nullable();
            $table->string('cac_cert')->nullable();
            $table->text('detail')->nullable();
            $table->string('logo')->nullable();
            $table->integer('merch_score')->nullable();
            $table->integer('returnCount')->nullable(); //Order Return Count
            $table->boolean('status')->default('0'); //merchant active status
            $table->boolean('deleted')->default('0'); //deleted status
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
        Schema::dropIfExists('merchants');
    }
}
