<?php

use Illuminate\Database\Seeder;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $roles = Role::all()->pluck('name')->all();
        // $randomRoles = \Arr::random($roles);

        DB::table('users')->insert([
            [
                'id' => Str::uuid(),
                'name' => 'User',
                'email' => 'user@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('admin'),
                'role_id' => Role::where('name', 'user')->first()->id
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('admin'),
                'role_id' => Role::where('name', 'admin')->first()->id
            ]
        ]);
    }
}
