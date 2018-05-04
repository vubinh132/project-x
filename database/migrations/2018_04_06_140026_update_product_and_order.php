<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProductAndOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('display_name')->nullable();

        });
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('selling_web')->nullable();
            $table->string('phone')->nullable()->change();
            $table->text('address')->nullable()->change();
            $table->dropUnique('orders_code_unique');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->text('code')->nullable()->change();

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
            $table->dropColumn('display_name');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('selling_web');
        });
    }
}
