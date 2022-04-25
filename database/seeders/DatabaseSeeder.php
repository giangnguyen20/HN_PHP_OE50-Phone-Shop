<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            Model::unguard();
            $this->call([
                RoleSeeder::class,
                UserSeeder::class,
            ]);
            Model::reguard();
        });
    }
}
