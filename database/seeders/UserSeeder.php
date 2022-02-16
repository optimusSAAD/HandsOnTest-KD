<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Saad',
            'address' => 'Dhaka',
            'isadmin' => '1',
            'email' => 'saad@gmail.com',
            'password' => Hash::make('secret'),
        ]);
        DB::table('users')->insert([
            'name' => 'saadb',
            'address' => 'Dhaka',
            'email' => 'saadb@gmail.com',
            'password' => Hash::make('secret'),
            'isadmin' => '1',
        ]);
        DB::table('users')->insert([
            'name' => 'saad2',
            'address' => 'Dhaka',
            'email' => 'saad2@gmail.com',
            'password' => Hash::make('secret'),
            'isadmin' => '1',
        ]);
    }
}
