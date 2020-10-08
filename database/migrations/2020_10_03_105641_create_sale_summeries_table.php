<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleSummeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_summeries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('seller_id');
            $table->string('buyer_id');
            $table->integer('merch_id');
            $table->text('prod_ids');
            $table->text('prod_imgs');
            $table->string('prod_names');
            $table->integer('qntys');
            $table->string('curr');
            $table->integer('tot_price');
            $table->integer('tot_discount');
            $table->string('trnc_code');
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
        Schema::dropIfExists('sale_summeries');
    }
}
