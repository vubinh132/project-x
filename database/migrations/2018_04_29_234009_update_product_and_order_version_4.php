<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProductAndOrderVersion4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('name', 'sku');
            $table->renameColumn('display_name', 'name');
            $table->dropColumn('quantity');

        });
        Schema::table('orders', function (Blueprint $table) {

            $table->dropColumn('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('quantity');
            $table->renameColumn('name', 'display_name');
            $table->renameColumn('sku', 'name');

        });
        Schema::table('orders', function (Blueprint $table) {
            $table->bigInteger('price')->nullable();
        });
    }
}
