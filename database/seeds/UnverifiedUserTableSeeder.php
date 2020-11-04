<?php

use Illuminate\Database\Seeder;

class UnverifiedUserTableSeeder extends Seeder
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
            'name' => 'Unverified User',
            'email' => 'unverifieduser@gmail.com',
            'email_verified_at' => null,
            'password' => bcrypt('admin'),
            'role_id' => '1fe7a5f3-a91d-4b9d-9773-58276e84bd98'
        ]);
    }
}
