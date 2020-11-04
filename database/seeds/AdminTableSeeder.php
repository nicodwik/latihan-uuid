<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class AdminTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => Str::uuid(),
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('admin'),
            'role_id' => '539f8051-164f-4e90-a3c0-cc6776143069'
        ]);
    }
}
