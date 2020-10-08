<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shippings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('seller_id');
            $table->string('buyer_id');
            $table->integer('merch_id');
            $table->integer('prod_id');
            $table->string('prod_name');
            $table->string('prod_weight');
            $table->string('curr')->nullable();
            $table->integer('shp_amount')->nullable();
            $table->string('t_code');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address');
            $table->string('zip_code')->nullable();
            $table->string('area')->nullable();
            $table->string('state');
            $table->string('country');
            $table->string('from');
            $table->string('tracking_code');
            $table->string('company_name')->nullable();
            $table->string('parcel_type')->nullable();
            $table->string('start_date_and_time')->nullable();
            $table->string('end_date_and_time')->nullable();
            $table->boolean('consigment_approved')->default('0');
            $table->string('approved_by');
            $table->string('carrier_id');
            $table->string('issual_id')->nullable();
            $table->boolean('confirmed')->default('0');
            $table->string('confirmed_code')->nullable();
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
        Schema::dropIfExists('shippings');
    }
}
