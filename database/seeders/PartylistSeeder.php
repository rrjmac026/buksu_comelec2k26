<?php

namespace Database\Seeders;

use App\Models\Partylist;
use Illuminate\Database\Seeder;

class PartylistSeeder extends Seeder
{
    public function run(): void
    {
        $partylists = [
            
            [
                'name' => 'SILAK',
                'acronym' => 'SLK',
                'description' => 'SILAK - Student Political Party'
            ],
            [
                'name' => 'BANAAG',
                'acronym' => 'BNG',
                'description' => 'BANAAG - Student Political Party'
            ],
            [
                'name' => 'HIRAYA',
                'acronym' => 'HRY',
                'description' => 'HIRAYA - Student Political Party'
            ],
        ];

        foreach ($partylists as $partylist) {
            Partylist::create($partylist);
        }
    }
}
