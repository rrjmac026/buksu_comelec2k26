<?php

namespace Database\Seeders;

use App\Models\College;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FacultyStaffSeeder extends Seeder
{
    /**
     * Seed dummy Faculty, Staff, and School Admin voter accounts.
     *
     * Naming convention : "Faculty User 1", "Staff User 1", "School Admin User 1"
     * Email convention  : faculty1@buksu.edu.ph, staff1@buksu.edu.ph, schooladmin1@buksu.edu.ph
     * Default password  : password123
     * Role              : voter
     * Status            : active
     */
    public function run(): void
    {
        $password = Hash::make('password123');

        // Resolve college IDs — cycle round-robin for faculty
        $collegeList   = College::pluck('id')->values()->toArray();
        $totalColleges = count($collegeList);

        // ── FACULTY (20 accounts) ─────────────────────────────────────────
        for ($i = 1; $i <= 20; $i++) {
            $collegeId = $totalColleges > 0
                ? $collegeList[($i - 1) % $totalColleges]
                : null;

            User::updateOrCreate(
                ['email' => "faculty{$i}@buksu.edu.ph"],
                [
                    'first_name'     => 'Faculty',
                    'middle_name'    => null,
                    'last_name'      => "User {$i}",
                    'password'       => $password,
                    'role'           => 'voter',
                    'status'         => 'active',
                    'sex'            => $i % 2 === 0 ? 'male' : 'female',
                    'student_number' => "FAC-{$i}",
                    'college_id'     => $collegeId,
                    'course'         => 'Faculty Member',
                    'year_level'     => null,
                ]
            );
        }

        // ── NON-TEACHING STAFF (15 accounts) ─────────────────────────────
        for ($i = 1; $i <= 15; $i++) {
            User::updateOrCreate(
                ['email' => "staff{$i}@buksu.edu.ph"],
                [
                    'first_name'     => 'Staff',
                    'middle_name'    => null,
                    'last_name'      => "User {$i}",
                    'password'       => $password,
                    'role'           => 'voter',
                    'status'         => 'active',
                    'sex'            => $i % 2 === 0 ? 'male' : 'female',
                    'student_number' => "STF-{$i}",
                    'college_id'     => null,
                    'course'         => 'Non-Teaching Staff',
                    'year_level'     => null,
                ]
            );
        }

        // ── SCHOOL ADMINISTRATORS (10 accounts) ──────────────────────────
        for ($i = 1; $i <= 10; $i++) {
            User::updateOrCreate(
                ['email' => "schooladmin{$i}@buksu.edu.ph"],
                [
                    'first_name'     => 'School Admin',
                    'middle_name'    => null,
                    'last_name'      => "User {$i}",
                    'password'       => $password,
                    'role'           => 'voter',
                    'status'         => 'active',
                    'sex'            => $i % 2 === 0 ? 'male' : 'female',
                    'student_number' => "ADM-{$i}",
                    'college_id'     => null,
                    'course'         => 'School Administrator',
                    'year_level'     => null,
                ]
            );
        }

        $this->command->info('✅ FacultyStaffSeeder done.');
        $this->command->info('   Faculty     : 20  →  faculty1@buksu.edu.ph  –  faculty20@buksu.edu.ph');
        $this->command->info('   Staff       : 15  →  staff1@buksu.edu.ph    –  staff15@buksu.edu.ph');
        $this->command->info('   School Admin: 10  →  schooladmin1@buksu.edu.ph  –  schooladmin10@buksu.edu.ph');
        $this->command->info('   Password    : password');
    }
}