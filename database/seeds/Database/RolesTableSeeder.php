<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Admin',
                'code' => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'allows_login_cms' => true
            ]
        ];

        DB::table('roles')->insert($roles);
    }
}
