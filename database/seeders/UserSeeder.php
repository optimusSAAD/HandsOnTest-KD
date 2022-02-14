<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
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
            'email' => 'saad@gmail.com',
            'password' => Hash::make('secret'),
        ]);
        DB::table('users')->insert([
            'name' => 'saadb',
            'email' => 'saadb@gmail.com',
            'password' => Hash::make('secret'),
        ]);
        DB::table('users')->insert([
            'name' => 'saad2',
            'email' => 'saad2@gmail.com',
            'password' => Hash::make('secret'),
        ]);
    }
}
