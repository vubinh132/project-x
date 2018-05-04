<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Settings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_keys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->unique();
        });
        Schema::create('setting_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('setting_key_id');
            $table->string('value');
            $table->string('description')->nullable();
            $table->boolean('choose')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting_values');
        Schema::dropIfExists('setting_keys');
    }
}
