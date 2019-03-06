<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Ver15UpdateUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['has_password', 'fb_uid', 'google_uid']);
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->renameColumn('full_name', 'username');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('has_password')->default(true);
            $table->string('fb_uid')->nullable();
            $table->string('google_uid')->nullable();
            $table->dropColumn(['first_name', 'last_name']);
            $table->renameColumn('username', 'full_name');
        });
    }
}
