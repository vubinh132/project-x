<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class Ver9AuthTokenSeeder extends Seeder
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
                'key' => 'L_TOKEN',
            ]
        ];
        DB::table('setting_keys')->insert($keys);
        $values = [
            [
                'setting_key_id' => 4,
                'value' => '',
                'choose' => true
            ]
        ];
        DB::table('setting_values')->insert($values);
    }
}

