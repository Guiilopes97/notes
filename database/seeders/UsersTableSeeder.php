<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('users')->insert([
            [
                'username' => 'admin@admin.com',
                'password' => bcrypt('123456'),
                'created_at' => now(),
            ],
            [
                'username' => 'admin2@admin.com',
                'password' => bcrypt('123456'),
                'created_at' => now(),
            ],
            [
                'username' => 'admin3@admin.com',
                'password' => bcrypt('123456'),
                'created_at' => now(),
            ],
        ]);

    }
}
