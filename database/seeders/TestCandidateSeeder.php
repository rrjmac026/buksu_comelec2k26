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
        // Colleges
        $cas  = $college('CAS');   // College of Arts and Sciences
        $con  = $college('CON');   // College of Nursing
        $cob  = $college('COB');   // College of Business
        $cot  = $college('COT');   // College of Technologies
        $coe  = $college('COE');   // College of Education
        $cpag = $college('CPAG');  // College of Public Administration

        // Organizations
        $ssc = $org('SSC');   // Supreme Student Council
        $sbo = $org('SBO');   // Student Body Organization

        // Partylists
        $sinagtala = $party('SINAGTALA');
        $banaag    = $party('BANAAG');
        $hiraya    = $party('HIRAYA');

        // Positions
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
                'platform'        => 'Championing fiscal responsibility, student rights, and meaningful campus engagement.',
            ],

            // ══════════════════════════════════════════
            //  SENATORS  (6 candidates)
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
                'platform'        => 'Amplifying the voices of marginalized students and building an inclusive campus environment for all.',
            ],
            [
                'first_name'      => 'Niel Nathan',
                'last_name'       => 'Montejo',
                'middle_name'     => null,
                'position_id'     => $senator,
                'partylist_id'    => $hiraya,
                'organization_id' => $sbo,
                'college_id'      => $con,   // CON — College of Nursing
                'course'          => 'Bachelor of Science in Nursing',
                'platform'        => 'Promoting student health literacy, nursing scholarship programs, and holistic campus wellness initiatives.',
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

        $this->command->info('✅ Candidates seeded: 2 Presidents, 2 Vice Presidents, 6 Senators.');
    }
}