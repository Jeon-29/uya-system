<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            // Admins
            [
                'name' => 'Nayeon',
                'email' => 'nayeon@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
            ],
            [
                'name' => 'Jihyo',
                'email' => 'jihyo@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
            ],
            // Officers
            [
                'name' => 'Jeongyeon',
                'email' => 'jeongyeon@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'officer',
            ],
            [
                'name' => 'JYP',
                'email' => 'jyp@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'officer',
            ],
            // Members
            [
                'name' => 'Momo',
                'email' => 'momo@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'member',
            ],
            [
                'name' => 'Sana',
                'email' => 'sana@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'member',
            ],
            [
                'name' => 'Mina',
                'email' => 'mina@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'member',
            ],
            [
                'name' => 'Dahyun',
                'email' => 'dahyun@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'member',
            ],
            [
                'name' => 'Chaeyoung',
                'email' => 'chaeyoung@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'member',
            ],
            [
                'name' => 'Tzuyu',
                'email' => 'tzuyu@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'member',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
