<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@uyaconnect.com'],
            [
                'name' => 'UYA Admin',
                'password' => Hash::make('12345678'), // Change to your desired secure password
                'role' => 'admin',
                'gender' => 'Male',
                'age' => 25,
                'contact_number' => '09123456789',
                'address' => 'GMA, Cavite',
                'email_verified_at' => now(),
            ]
        );
    }
}
