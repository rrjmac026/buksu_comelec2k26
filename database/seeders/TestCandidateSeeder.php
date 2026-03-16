<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Candidate;
use App\Models\College;
use App\Models\Position;
use App\Models\Partylist;
use App\Models\Organization;

class TestCandidateSeeder extends Seeder
{
    public function run(): void
    {
        // ── Helper: resolve IDs by name ─────────────────────────────
        $college  = fn(string $acronym)  => College::where('acronym', $acronym)->value('id');
        $position = fn(string $name)     => Position::where('name', $name)->value('id');
        $party    = fn(string $name)     => Partylist::where('name', $name)->value('id');
        $org      = fn(string $acronym)  => Organization::where('acronym', $acronym)->value('id');

        // ── Shorthand IDs ───────────────────────────────────────────
        $cas  = $college('CAS');
        $con  = $college('CON');
        $cob  = $college('COB');
        $cot  = $college('COT');
        $coe  = $college('COE');
        $cpag = $college('CPAG');

        $ssc = $org('SSC');
        $sbo = $org('SBO');

        $sinagtala = $party('SINAGTALA');
        $banaag    = $party('BANAAG');
        $hiraya    = $party('HIRAYA');

        $president  = $position('President');
        $vp         = $position('Vice President');
        $senator    = $position('Senator');

        // ── Candidates Array ────────────────────────────────────────
        $candidates = [

            // ══════════════════════════════════════════
            //  PRESIDENT
            // ══════════════════════════════════════════

            [
                'first_name'      => 'Roxanne',
                'last_name'       => 'Ortega',
                'middle_name'     => null,
                'position_id'     => $president,
                'partylist_id'    => $sinagtala,
                'organization_id' => $ssc,
                'college_id'      => $cas,
                'course'          => 'Bachelor of Arts in Communication',
                'photo'           => '1773628059_645679763_2960468820828838_6793719293451820377_n.jpg',
                'platform'        => 'Empowering student voices through transparent governance and inclusive campus programs.',
            ],
            [
                'first_name'      => 'Khyle',
                'last_name'       => 'Amacna',
                'middle_name'     => 'Villarin',
                'position_id'     => $president,
                'partylist_id'    => $banaag,
                'organization_id' => $sbo,
                'college_id'      => $cas,
                'course'          => 'Bachelor of Science in Psychology',
                'photo'           => '1773628071_dev2.jpg',
                'platform'        => 'Building a united student body through active leadership and sustainable academic initiatives.',
            ],

            // ══════════════════════════════════════════
            //  VICE PRESIDENT
            // ══════════════════════════════════════════

            [
                'first_name'      => 'Bernardo',
                'last_name'       => 'Dela Cerna III',
                'middle_name'     => 'Cruz',
                'position_id'     => $vp,
                'partylist_id'    => $sinagtala,
                'organization_id' => $ssc,
                'college_id'      => $cot,
                'course'          => 'Bachelor of Science in Information Technology',
                'photo'           => '1773628094_dev3.jpg',
                'platform'        => 'Driving digital innovation and student welfare through collaborative and tech-forward leadership.',
            ],
            [
                'first_name'      => 'Rey Rameses Jude III',
                'last_name'       => 'Macalutas',
                'middle_name'     => 'Sanchez',
                'position_id'     => $vp,
                'partylist_id'    => $banaag,
                'organization_id' => $sbo,
                'college_id'      => $cob,
                'course'          => 'Bachelor of Science in Business Administration',
                'photo'           => '1773628191_44daf0f3-cbc4-4397-8902-9cf1f7ca3635.jpg',
                'platform'        => 'Championing fiscal responsibility, student rights, and meaningful campus engagement.',
            ],

            // ══════════════════════════════════════════
            //  SENATORS
            // ══════════════════════════════════════════

            [
                'first_name'      => 'Winston Hendrix',
                'last_name'       => 'Mansueto',
                'middle_name'     => null,
                'position_id'     => $senator,
                'partylist_id'    => $sinagtala,
                'organization_id' => $ssc,
                'college_id'      => $cob,
                'course'          => 'Bachelor of Science in Accountancy',
                'photo'           => '1773629111_b63feb1b-bb92-4f71-b806-1e4fc2496535.jpg',
                'platform'        => 'Advocating for financial transparency and equitable resource distribution among all student organizations.',
            ],
            [
                'first_name'      => 'Brynth',
                'last_name'       => 'Gunayan',
                'middle_name'     => null,
                'position_id'     => $senator,
                'partylist_id'    => $banaag,
                'organization_id' => $sbo,
                'college_id'      => $coe,
                'course'          => 'Bachelor of Secondary Education',
                'photo'           => '1773628214_625970077_2329589484113115_4196818189688666720_n.jpg',
                'platform'        => 'Strengthening academic support systems and promoting mental health awareness across all colleges.',
            ],
            [
                'first_name'      => 'Kirk John',
                'last_name'       => 'Sieras',
                'middle_name'     => null,
                'position_id'     => $senator,
                'partylist_id'    => $hiraya,
                'organization_id' => $ssc,
                'college_id'      => $cot,
                'course'          => 'Bachelor of Science in Computer Science',
                'photo'           => '1773629430_96b38f69-9142-4a03-9a4c-da2cf191b91e.jpg',
                'platform'        => 'Leveraging technology to modernize student services and improve campus-wide communication.',
            ],
            [
                'first_name'      => 'Karl Angelo',
                'last_name'       => 'Benemerito',
                'middle_name'     => null,
                'position_id'     => $senator,
                'partylist_id'    => $sinagtala,
                'organization_id' => $sbo,
                'college_id'      => $cpag,
                'course'          => 'Bachelor of Public Administration',
                'photo'           => '1773628239_625970077_2329589484113115_4196818189688666720_n.jpg',
                'platform'        => 'Pushing for policy reforms that prioritize student welfare, scholarships, and campus safety.',
            ],
            [
                'first_name'      => 'Merwin',
                'last_name'       => 'Sellote',
                'middle_name'     => null,
                'position_id'     => $senator,
                'partylist_id'    => $banaag,
                'organization_id' => $ssc,
                'college_id'      => $cas,
                'course'          => 'Bachelor of Science in Social Work',
                'photo'           => '1773628253_982e2d73-0241-4628-a86b-6c4a0797b21a.jpg',
                'platform'        => 'Amplifying the voices of marginalized students and building an inclusive campus environment for all.',
            ],
            [
                'first_name'      => 'Niel Nathan',
                'last_name'       => 'Montejo',
                'middle_name'     => null,
                'position_id'     => $senator,
                'partylist_id'    => $hiraya,
                'organization_id' => $sbo,
                'college_id'      => $con,
                'course'          => 'Bachelor of Science in Nursing',
                'photo'           => '1773628268_626313936_1441563960744880_2531056482900615600_n.jpg',
                'platform'        => 'Promoting student health literacy, nursing scholarship programs, and holistic campus wellness initiatives.',
            ],
            [
                'first_name'      => 'Angelo',
                'last_name'       => 'Daulong',
                'middle_name'     => 'Lapido',
                'position_id'     => $senator,
                'partylist_id'    => $banaag,
                'organization_id' => $ssc,
                'college_id'      => $cot,
                'course'          => 'Bachelor of Science in Information Technology',
                'photo'           => '1773629092_d46908a1-9cc1-438a-bc91-b3fad16d9f34.jpg',
                'platform'        => 'eat is all I want',
            ],
            [
                'first_name'      => 'Ernest John',
                'last_name'       => 'Tado',
                'middle_name'     => 'Unemployed',
                'position_id'     => $senator,
                'partylist_id'    => $banaag,
                'organization_id' => $ssc,
                'college_id'      => $cot,
                'course'          => 'Bachelor of Science in Information Technology',
                'photo'           => '1773629401_6bf732f9-8253-4f20-b04d-c909e325bbc2.jpg',
                'platform'        => 'Unemployed all the way',
            ],

        ];

        // ── Insert ──────────────────────────────────────────────────
        foreach ($candidates as $data) {
            Candidate::updateOrCreate(
                [
                    'first_name'  => $data['first_name'],
                    'last_name'   => $data['last_name'],
                    'position_id' => $data['position_id'],
                ],
                $data
            );
        }

        $this->command->info('✅ Candidates seeded: 2 Presidents, 2 Vice Presidents, 8 Senators.');
    }
}