<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'     => str_random(4),
            'email'    => str_random(4) . '@xiaozi.com',
            'password' => bcrypt('111111'),
        ]);
    }
}
