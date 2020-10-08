<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAdvertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_adverts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('merch_id');
            $table->integer('user_id');
            $table->integer('amount_paid');
            $table->integer('amount_remaining');
            $table->integer('tot_clicks');
            $table->integer('remaining_clicks');
            $table->boolean('status')->default('0');
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
        Schema::dropIfExists('product_adverts');
    }
}
