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
            PartylistSeeder::class,
        ]);

        // Admin Seeders
        User::updateOrCreate(
            ['email' => '1901102366@student.buksu.edu.ph'],
            [
                'first_name' => 'Admin Jam',
                'last_name' => 'Macalutas',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => '2101103309@student.buksu.edu.ph'],
            [
                'first_name' => 'Admin Khyle',
                'last_name' => 'Amacna',
                'password' => Hash::make('gwaposikhyle123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => '2001102491@student.buksu.edu.ph'],
            [
                'first_name' => 'Admin Bernardo',
                'last_name' => 'Dela Cerna III',
                'password' => Hash::make('gwaposibernard123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@student.buksu.edu.ph'],
            [
                'first_name' => 'Regular',
                'last_name' => 'User',
                'password' => Hash::make('password'),
                'role' => 'voter',
            ]
        );

        \DB::table('users')->updateOrInsert(
            ['email' => 'prototypecapstone@gmail.com'],
            [
                'first_name' => 'Putangina Mo',
                'last_name' => 'Bobo Ka',
                'password'   => null,
                'role'       => 'voter',
                'status'     => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        
    }
}
