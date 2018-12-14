<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class Ver13ApiKeySeeder extends Seeder
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
                'key' => 'API_KEY',
            ]
        ];
        DB::table('setting_keys')->insert($keys);
        $values = [
            [
                'setting_key_id' => 5,
                'value' => '',
                'choose' => true
            ]
        ];
        DB::table('setting_values')->insert($values);
    }
}

