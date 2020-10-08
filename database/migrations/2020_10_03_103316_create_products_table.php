<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->integer('merch_id');
            $table->string('name');
            $table->text('detail');
            $table->string('curr');
            $table->double('price');
            $table->double('salesPrice');
            $table->string('category');
            $table->string('sub_category');
            $table->string('prodType');
            $table->string('prodClass');
            $table->string('brandName')->nullable();
            $table->string('sku')->nullable();
            $table->string('img1')->nullable();
            $table->string('img2')->nullable();
            $table->string('img3')->nullable();
            $table->string('img4')->nullable();
            $table->string('maincolor')->nullable();
            $table->string('size')->nullable();
            $table->string('prodKeywords')->nullable();
            $table->boolean('same_day_delivery')->default('0');
            $table->string('saleStartDate')->nullable();
            $table->string('saleEndDate')->nullable();
            $table->double('discount_id')->nullable();
            $table->boolean('variety')->nullable();
            $table->string('condition')->default('New');
            $table->string('stock_status')->default('instock');
            $table->integer('stock')->nullable();
            $table->string('updated_by')->nullable();
            $table->boolean('prod_deleted')->default('0');
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
