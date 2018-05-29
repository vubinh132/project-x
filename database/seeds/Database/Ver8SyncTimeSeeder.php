<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class Ver8SyncTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $keys = [
            [
                'key' => 'SYNC_TIME',
            ]
        ];
        DB::table('setting_keys')->insert($keys);
        $values = [
            [
                'setting_key_id' => 3,
                'value' => '100',
                'choose' => true
            ]
        ];
        DB::table('setting_values')->insert($values);
    }
}

