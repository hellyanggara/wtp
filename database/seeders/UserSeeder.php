<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super = User::create([
            'name' => 'Helly Anggara Suwignyo',
            'email' => 'helly.anggara@justnother.com',
            'birth_date' => '1986-06-08',
            'password' => bcrypt('Helsa86as'),
        ]);
        $super->assignRole('super');
        
        $admin = User::create([
            'name' => 'Adito',
            'email' => 'aditya@wtp.test',
            'password' => bcrypt('12345678'),
        ]);
        $admin->assignRole('admin');

        $user = User::create([
            'name' => 'User',
            'email' => 'user@wtp.test',
            'password' => bcrypt('12345678'),
        ]);
        $user->assignRole('user');
    }
}
