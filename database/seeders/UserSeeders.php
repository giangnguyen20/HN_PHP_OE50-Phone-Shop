<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'fullname' => 'admin',
            'phone' => null,
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'status' => config('user.status_active'),
            'role_id' => config('user.role_admin'),
        ]);
    }
}
