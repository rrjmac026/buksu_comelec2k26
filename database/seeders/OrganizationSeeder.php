<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationSeeder extends Seeder
{
    public function run()
    {
        // Sample organizations
        $organizations = [
            [
                'name' => 'Supreme Student Council',
                'acronym' => 'SSC',
                'description' => 'The official student government of BukSU.',
                'college_id' => null, // Ensure this matches an existing college_id
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Student Body Organization',
                'acronym' => 'SBO',
                'description' => 'The official student government of BukSU.',
                'college_id' => null, // Ensure this matches an existing college_id
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ];

        foreach ($organizations as $org) {
            DB::table('organizations')->updateOrInsert(
                ['acronym' => $org['acronym']],
                $org
            );
        }
    }
}
