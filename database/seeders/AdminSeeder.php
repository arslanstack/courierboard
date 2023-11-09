<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Admin::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'status' => 1,
            'phone' => '4567812345',
            'username' => 'admin@gmail.com',
            'email_verified_at' => now(),
        ]);
    }
}
