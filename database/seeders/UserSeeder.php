<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'fname' => 'John',
            'lname' => 'Doe',
            'phone' => '4567812345',
            'email' => 'john@gmail.com',
            'email_verified_at' => now(),
            'account_no' => rand(100000, 999999),
            'username' => 'john@gmail.com',
            'password' => Hash::make('123456')
        ]);
    }
}
