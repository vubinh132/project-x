<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Order;

class Ver15UpdateOrderStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status', 2)->change();
        });

        Order::where('status', '1')->update(['status' => 'N']);
        Order::where('status', '2')->update(['status' => 'P']);
        Order::where('status', '3')->update(['status' => 'I']);
        Order::where('status', '4')->update(['status' => 'C']);
        Order::where('status', '5')->update(['status' => 'RN']);
        Order::where('status', '6')->update(['status' => 'L']);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Order::where('status', 'N')->update(['status' => '1']);
        Order::where('status', 'P')->update(['status' => '2']);
        Order::where('status', 'I')->update(['status' => '3']);
        Order::where('status', 'C')->update(['status' => '4']);
        Order::where('status', 'RN')->update(['status' => '5']);
        Order::where('status', 'L')->update(['status' => '6']);

        Schema::table('orders', function (Blueprint $table) {
            $table->integer('status')->change();
        });
    }
}
