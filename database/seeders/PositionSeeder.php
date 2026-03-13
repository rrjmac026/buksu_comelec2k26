<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Position;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            ['name' => 'President',                 'sort_order' => 1,  'max_votes' => 1],
            ['name' => 'Vice President',             'sort_order' => 2,  'max_votes' => 1],
            ['name' => 'Senator',                    'sort_order' => 3,  'max_votes' => 12],
            ['name' => 'Governor',                   'sort_order' => 4,  'max_votes' => 1],
            ['name' => 'Vice Governor',              'sort_order' => 5,  'max_votes' => 1],
            ['name' => 'Secretary',                  'sort_order' => 6,  'max_votes' => 1],
            ['name' => 'Associate Secretary',        'sort_order' => 7,  'max_votes' => 1],
            ['name' => 'Treasurer',                  'sort_order' => 8,  'max_votes' => 1],
            ['name' => 'Associate Treasurer',        'sort_order' => 9,  'max_votes' => 1],
            ['name' => 'Auditor',                    'sort_order' => 10, 'max_votes' => 1],
            ['name' => 'Public Relation Officer',    'sort_order' => 11, 'max_votes' => 1],
            ['name' => 'Second Year Representative', 'sort_order' => 12, 'max_votes' => 1],
            ['name' => 'Third Year Representative',  'sort_order' => 13, 'max_votes' => 1],
            ['name' => 'Fourth Year Representative', 'sort_order' => 14, 'max_votes' => 1],
        ];

        foreach ($positions as $position) {
            DB::table('positions')->updateOrInsert(
                ['name' => $position['name']],
                [
                    'sort_order' => $position['sort_order'],
                    'max_votes'  => $position['max_votes'],
                ]
            );
        }
    }
}