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
            PartylistSeeder::class,
            // CollegeSeeder::class,
            // PositionSeeder::class,
            // OrganizationSeeder::class,
            // CandidateSeeder::class,
            // FacultyStaffSeeder::class,
            // TestCandidateSeeder::class
        ]);

        // Admin Seeders
        User::updateOrCreate(
            ['email' => 'macalutasreyramesesjudeiii@gmail.com'],
            [
                'first_name' => 'Admin Jam',
                'last_name' => 'Macalutas',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'amacna.khyle@gmail.com'],
            [
                'first_name' => 'Admin Khyle',
                'last_name' => 'Amacna',
                'password' => Hash::make('gwaposikhyle123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'yudai.bernard@gmail.com'],
            [
                'first_name' => 'Admin Bernardo',
                'last_name' => 'Dela Cerna III',
                'password' => Hash::make('gwaposibernard123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'adminkleviejun@gmail.com'],
            [
                'first_name' => 'Admin Klevie Jun',
                'last_name' => 'Caseres',
                'password' => Hash::make('A9v!Q7x#L2p@Z5mK'),
                'role' => 'admin',
            ]
        );

        
    }
}
