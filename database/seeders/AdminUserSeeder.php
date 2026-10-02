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
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (! $email || ! $password) {
            $this->command?->warn('ADMIN_EMAIL or ADMIN_PASSWORD not set; skipping admin seed.');
            return;
        }

        $user = User::firstOrNew(['email' => $email]);

        // Only set the password when the admin is first created,
        // so a later deploy never overwrites a password changed in the app.
        if (! $user->exists) {
            $user->password = Hash::make($password);
        }

        $user->forceFill([
            'name' => 'UYA Admin',
            'role' => 'admin',
            'gender' => 'Male',
            'age' => 25,
            'contact_number' => '09123456789',
            'address' => 'GMA, Cavite',
            'email_verified_at' => now(),
        ])->save();
    }
}
