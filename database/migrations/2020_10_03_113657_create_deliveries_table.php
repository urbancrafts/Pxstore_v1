<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('seller_id');
            $table->string('buyer_id');
            $table->integer('merch_id');
            $table->integer('prod_id');
            $table->string('prod_name');
            $table->string('prod_weight');
            $table->string('curr')->nullable();
            $table->integer('amount')->nullable();
            $table->string('t_code');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address');
            $table->string('zip_code')->nullable();
            $table->string('area')->nullable();
            $table->string('state');
            $table->string('country');
            $table->string('delivery_option')->default('payment');
            $table->string('start_date_and_time')->nullable();
            $table->string('end_date_and_time')->nullable();
            $table->boolean('delivery_approved')->default('0');
            $table->string('approved_by');
            $table->string('carrier_id');
            $table->string('issuer_id')->nullable();
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
        Schema::dropIfExists('deliveries');
    }
}
