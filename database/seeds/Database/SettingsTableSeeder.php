<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SettingsTableSeeder extends Seeder
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
                'key' => 'START_DATE',
            ],
            [
                'key' => 'VERSION_DETAILS',
            ]
        ];
        DB::table('setting_keys')->insert($keys);
        $values = [
            [
                'setting_key_id' => 1,
                'value' => '2018-03-05',
                'choose' => true
            ],
            [
                'setting_key_id' => 2,
                'value' => '3|6|2018-04-14',
                'choose' => true
            ]
        ];
        DB::table('setting_values')->insert($values);
    }
}

