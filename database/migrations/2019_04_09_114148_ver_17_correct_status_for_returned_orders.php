<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Order;

class Ver17CorrectStatusForReturnedOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Order::where('returned', true)->update(['status' => Order::STATUS['RECEIVED']]);
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['returned']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('returned')->nullable();
        });
        Order::where('status', Order::STATUS['RECEIVED'])->update(['returned' => true, 'status' => Order::STATUS['NOT_RECEIVED']]);
    }
}
