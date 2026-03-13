<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        Position::where('name', 'Senator')->update(['max_votes' => 12]);
        $positions = [
            ['name' => 'President',                  'sort_order' => 1],
            ['name' => 'Vice President',              'sort_order' => 2],
            ['name' => 'Senator',                     'sort_order' => 3],
            ['name' => 'Governor',                    'sort_order' => 4],
            ['name' => 'Vice Governor',               'sort_order' => 5],
            ['name' => 'Secretary',                   'sort_order' => 6],
            ['name' => 'Associate Secretary',         'sort_order' => 7],
            ['name' => 'Treasurer',                   'sort_order' => 8],
            ['name' => 'Associate Treasurer',         'sort_order' => 9],
            ['name' => 'Auditor',                     'sort_order' => 10],
            ['name' => 'Public Relation Officer',     'sort_order' => 11],
            ['name' => 'Second Year Representative',  'sort_order' => 12],
            ['name' => 'Third Year Representative',   'sort_order' => 13],
            ['name' => 'Fourth Year Representative',  'sort_order' => 14],
        ];

        foreach ($positions as $position) {
            DB::table('positions')->updateOrInsert(
                ['name' => $position['name']],
                ['sort_order' => $position['sort_order']]
            );
        }
    }
}