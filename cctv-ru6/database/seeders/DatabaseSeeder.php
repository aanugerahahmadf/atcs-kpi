<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            BuildingSeeder::class,
        ]);

        // Create Super Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Admin123!'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('Super Admin');

        $this->call([
            RoomSeeder::class,
            CctvSeeder::class,
        ]);
    }
}
