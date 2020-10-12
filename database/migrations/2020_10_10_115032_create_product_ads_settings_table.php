<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAdsSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_ads_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('duration_days');
            $table->integer('amount');
            $table->string('curr');
            $table->integer('clicks');
            $table->integer('per_click');
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
        Schema::dropIfExists('product_ads_settings');
    }
}
