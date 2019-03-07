<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class Ver15RoleAndUserSeeder extends Seeder
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
                'name' => 'Ecommerce Platform',
                'code' => 'ecommerce_platform',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Provider',
                'code' => 'provider',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('roles')->insert($roles);

        $users = [
            [
                'username' => 'lazada',
                'role_id' => 2,
                'email' => 'lazada@mailinator.com',
                'password' => bcrypt('123456'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'username' => 'seudo',
                'role_id' => 3,
                'email' => 'seudo@mailinator.com',
                'password' => bcrypt('123456'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
        DB::table('users')->insert($users);
    }
}
