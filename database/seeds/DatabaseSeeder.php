<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        //seed for setting
        $this->call(SettingsTableSeeder::class);
        //seed for note
        $this->call(NotesTableSeeder::class);
    }
}
