<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Ver14ShopProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_product', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('sku')->unique();
            $table->integer('lazada')->nullable();
            $table->integer('shopee')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_product');
    }
}
