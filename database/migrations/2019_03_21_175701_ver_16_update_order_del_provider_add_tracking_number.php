<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Order;
use App\Models\User;

class Ver16UpdateOrderDelProviderAddTrackingNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $seudoId = User::where('username', 'seudo')->first()->id;
        Order::where('provider', '1')->update(['selling_web' => $seudoId]);
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['provider']);
            $table->string('tracking_number')->nullable();
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
            $table->dropColumn(['tracking_number']);
            $table->int('provider')->nullable();
        });
        $seudoId = User::where('username', 'seudo')->first()->id;
        Order::where('selling_web', $seudoId)->update(['provider' => 1]);
    }
}
