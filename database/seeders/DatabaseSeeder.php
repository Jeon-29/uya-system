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
            // Main Admin Account
            [
                'name' => 'UYA Admin',
                'email' => 'admin@uyaconnect.com',
                'password' => Hash::make('Admin123!'),
                'role' => 'admin',
                'gender' => 'Male',
                'age' => 25,
                'contact_number' => '09123456789',
                'address' => 'Silang, Cavite',
                'email_verified_at' => now(),
            ],
            // Additional Admins
            [
                'name' => 'Nayeon',
                'email' => 'nayeon@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Jihyo',
                'email' => 'jihyo@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
            // Officers
            [
                'name' => 'Jeongyeon',
                'email' => 'jeongyeon@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'officer',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'JYP',
                'email' => 'jyp@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'officer',
                'email_verified_at' => now(),
            ],
            // Members
            [
                'name' => 'Momo',
                'email' => 'momo@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'member',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Sana Minatozaki',
                'email' => 'sana@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'member',
                'address' => 'Taguig City',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Mina',
                'email' => 'mina@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'member',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Dahyun',
                'email' => 'dahyun@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'member',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Chaeyoung',
                'email' => 'chaeyoung@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'member',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Tzuyu',
                'email' => 'tzuyu@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'member',
                'email_verified_at' => now(),
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
