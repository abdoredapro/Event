<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin', 
            'email' => 'admin@gmail.com',
            'phone' => '01014318965',
            'password' => bcrypt(78957895),
            'username' => 'admin.pro',
            'gender' => 'male',
        ]);

        $user->assignRole('admin');
    }
}
