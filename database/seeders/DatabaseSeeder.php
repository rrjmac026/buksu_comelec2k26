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
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            CollegeSeeder::class,
            PositionSeeder::class,
            OrganizationSeeder::class,
        ]);

        // Admin Seeders
        User::updateOrCreate(
            ['email' => '1901102366@student.buksu.edu.ph'],
            [
                'name' => 'Admin Jam Macalutas',
                'password' => Hash::make('gwaposijam123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => '2101103309@student.buksu.edu.ph'],
            [
                'name' => 'Admin Khyle Amacna',
                'password' => Hash::make('gwaposikhyle123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => '2001102491@student.buksu.edu.ph'],
            [
                'name' => 'Admin Bernardo Dela Cerna',
                'password' => Hash::make('gwaposibernard123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@student.buksu.edu.ph'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password'),
                'role' => 'voter',
            ]
        );
        
    }
}
