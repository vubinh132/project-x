<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Ver13CreateApiData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_data', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('path')->unique();
            $table->integer('number_of_uses')->default(0);
            $table->timestamp('last_time_called')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_data');
    }
}
