<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Candidate;
use App\Models\College;
use App\Models\Position;
use App\Models\Partylist;
use App\Models\Organization;

class CandidateSeeder extends Seeder
{
    public function run(): void
    {
        // ── Resolve all lookup IDs up-front with diagnostics ────────
        $resolve = function (string $model, string $column, string $value): int {
            $id = $model::where($column, $value)->value('id');
            if ($id === null) {
                throw new \RuntimeException(
                    "[CandidateSeeder] Could not resolve {$model} where {$column} = '{$value}'. " .
                    "Make sure the required seeders have run first."
                );
            }
            return (int) $id;
        };

        // ── Colleges ─────────────────────────────────────────────────
        // SQL college_id mapping:
        //   1 = CON, 2 = COT, 3 = CAS, 4 = CPAG, 5 = COB, 6 = COE
        $con  = $resolve(College::class, 'acronym', 'CON');
        $cot  = $resolve(College::class, 'acronym', 'COT');
        $cas  = $resolve(College::class, 'acronym', 'CAS');
        $cpag = $resolve(College::class, 'acronym', 'CPAG');
        $cob  = $resolve(College::class, 'acronym', 'COB');
        $coe  = $resolve(College::class, 'acronym', 'COE');

        // ── Organizations ─────────────────────────────────────────────
        // SQL organization_id mapping:
        //   1 = SSC, 2 = SBO
        $ssc = $resolve(Organization::class, 'acronym', 'SSC');
        $sbo = $resolve(Organization::class, 'acronym', 'SBO');

        // ── Partylists ────────────────────────────────────────────────
        // SQL partylist_id mapping:
        //   2 = SILAK, 3 = BANAAG, 4 = HIRAYA
        $silak  = $resolve(Partylist::class, 'name', 'SILAK');
        $banaag = $resolve(Partylist::class, 'name', 'BANAAG');
        $hiraya = $resolve(Partylist::class, 'name', 'HIRAYA');

        // ── Positions ─────────────────────────────────────────────────
        // SQL position_id mapping:
        //   2 = Vice President, 3 = Senator, 4 = Governor, 5 = Vice Governor
        //   6 = Secretary, 7 = Associate Secretary, 8 = Treasurer
        //   9 = Associate Treasurer, 10 = Auditor, 11 = Associate Auditor
        //   12 = Public Relation Officer, 13 = Second Year Representative
        //   14 = Third Year Representative, 15 = Fourth Year Representative
        $vicePresident  = $resolve(Position::class, 'name', 'Vice President');
        $senator        = $resolve(Position::class, 'name', 'Senator');
        $governor       = $resolve(Position::class, 'name', 'Governor');
        $viceGovernor   = $resolve(Position::class, 'name', 'Vice Governor');
        $secretary      = $resolve(Position::class, 'name', 'Secretary');
        $assocSecretary = $resolve(Position::class, 'name', 'Associate Secretary');
        $treasurer      = $resolve(Position::class, 'name', 'Treasurer');
        $assocTreasurer = $resolve(Position::class, 'name', 'Associate Treasurer');
        $auditor        = $resolve(Position::class, 'name', 'Auditor');
        $assocAuditor   = $resolve(Position::class, 'name', 'Associate Auditor');
        $pro            = $resolve(Position::class, 'name', 'Public Relation Officer');
        $secondYearRep  = $resolve(Position::class, 'name', 'Second Year Representative');
        $thirdYearRep   = $resolve(Position::class, 'name', 'Third Year Representative');
        $fourthYearRep  = $resolve(Position::class, 'name', 'Fourth Year Representative');

        $this->command->info('✅ All IDs resolved. Seeding candidates...');

        // ── Candidates — mirrors SQL dump (candidate_id 1–79) ─────────
        $candidates = [

            // ══════════════════════════════════════════════════════════
            //  IDs 1–11 | COLLEGE OF NURSING (CON) — HIRAYA / SBO
            // ══════════════════════════════════════════════════════════

            // 1
            ['first_name' => 'Nhelfer',              'last_name' => 'Garig',      'middle_name' => null,          'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $secondYearRep,  'college_id' => $con,  'course' => 'BSN',          'photo' => '1775905606_2ND REPRESENTATIVE_ Garig, Nhelfer.JPG'],
            // 2
            ['first_name' => 'Regina Georzee',       'last_name' => 'Domo',       'middle_name' => 'Jamito',      'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $thirdYearRep,   'college_id' => $con,  'course' => 'BSN',          'photo' => '1775906006_3RD LEVEL REPRESETATIVE _ Domo, Regina Georzee J_.JPG'],
            // 3
            ['first_name' => 'Paulene Danica Reign', 'last_name' => 'Sencil',     'middle_name' => 'Timones',     'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $fourthYearRep,  'college_id' => $con,  'course' => 'BSN',          'photo' => '1775906296_4TH LEVEL REPRENTATIVE I SENCIL, PAULENE DANICA REIGN T.JPG'],
            // 4
            ['first_name' => 'Julia Isabelle',       'last_name' => 'Plasos',     'middle_name' => null,          'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $assocAuditor,   'college_id' => $con,  'course' => 'BSN',          'photo' => '1775907660_ASSOCIATE AUDITOR_ Plasos, Julia Isabelle_.JPG'],
            // 5
            ['first_name' => 'Francis',              'last_name' => 'Zoe',        'middle_name' => null,          'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $assocSecretary, 'college_id' => $con,  'course' => 'BSN',          'photo' => '1775908359_ASSOCIATE SECRETARY_ Cuello, Francis Zoe.JPG'],
            // 6
            ['first_name' => 'Xylexa Kaye',          'last_name' => 'Chan',       'middle_name' => null,          'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $assocTreasurer, 'college_id' => $con,  'course' => 'BSN',          'photo' => '1775910076_ASSOCIATE TREASURER_ Chan, Xylexa Kaye.JPG'],
            // 7
            ['first_name' => 'Queen Zandarra',       'last_name' => 'Pendatun',   'middle_name' => 'Lapuz',       'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $auditor,        'college_id' => $con,  'course' => 'BSN',          'photo' => '1775910558_AUDITOR _ Pendatun, Queen Zandarra L_.JPG'],
            // 8
            ['first_name' => 'Ann Francis',          'last_name' => 'Waban',      'middle_name' => 'Belnas',      'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $governor,       'college_id' => $con,  'course' => 'BSN',          'photo' => '1775910636_GOVERNOR I Waban, Ann Francis S.JPG'],
            // 9
            ['first_name' => 'Regine Mae',           'last_name' => 'Sebandal',   'middle_name' => 'Mortejo',     'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $pro,            'college_id' => $con,  'course' => 'BSN',          'photo' => '1775910717_PUBLIC RELATIONS OFFICER _ Sebandal, Regine Mae M_.JPG'],
            // 10
            ['first_name' => 'Tisha Nigella',        'last_name' => 'Encabo',     'middle_name' => 'De Asis',     'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $secretary,      'college_id' => $con,  'course' => 'BSN',          'photo' => '1775910787_SECRETARY_ Encabo, Tisha Nigella.JPG'],
            // 11
            ['first_name' => 'Alexa Iris',           'last_name' => 'Ledres',     'middle_name' => 'Villaruel',   'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $viceGovernor,   'college_id' => $con,  'course' => 'BSN',          'photo' => '1775910881_VICE-GOVERNOR_ Ledres, Alexa Iris.JPG'],

            // ══════════════════════════════════════════════════════════
            //  IDs 12–22 | COLLEGE OF EDUCATION (COE) — SILAK / SBO
            // ══════════════════════════════════════════════════════════

            // 12
            ['first_name' => 'Carl Ian',             'last_name' => 'Dahao',      'middle_name' => 'Fernandez',   'partylist_id' => $silak,  'organization_id' => $sbo, 'position_id' => $secondYearRep,  'college_id' => $coe,  'course' => 'COE',          'photo' => '1775910954_2ND YEAR REPRESENTATIVE, CARL IAN DAHAO.JPG'],
            // 13
            ['first_name' => 'Michael',              'last_name' => 'Tinoy',      'middle_name' => 'Ticar',       'partylist_id' => $silak,  'organization_id' => $sbo, 'position_id' => $thirdYearRep,   'college_id' => $coe,  'course' => 'COE',          'photo' => '1775911008_3RD YEAR REPRESENTATIVE, MICHAEL TINOY.JPG'],
            // 14
            ['first_name' => 'Rheanna Maryen',       'last_name' => 'Tandog',     'middle_name' => 'Gabales',     'partylist_id' => $silak,  'organization_id' => $sbo, 'position_id' => $assocSecretary, 'college_id' => $coe,  'course' => 'COE',          'photo' => '1775911197_ASSOCIATE SECRETARY, RHEANNA MARYEN TANDOG.JPG'],
            // 15
            ['first_name' => 'Joshua',               'last_name' => 'Gawangan',   'middle_name' => null,          'partylist_id' => $silak,  'organization_id' => $sbo, 'position_id' => $auditor,        'college_id' => $coe,  'course' => 'COE',          'photo' => '1775911236_AUDITOR, JOSHUA GAWANGAN.JPG'],
            // 16
            ['first_name' => 'Roan',                 'last_name' => 'Lanzaderas', 'middle_name' => null,          'partylist_id' => $silak,  'organization_id' => $sbo, 'position_id' => $governor,       'college_id' => $coe,  'course' => 'BSED-MATH',    'photo' => '1775911399_GOVERNOR, ROAN LANZADERAS.JPG'],
            // 17
            ['first_name' => 'Ella',                 'last_name' => 'Nobesis',    'middle_name' => null,          'partylist_id' => $silak,  'organization_id' => $sbo, 'position_id' => $pro,            'college_id' => $coe,  'course' => 'BEED',         'photo' => '1775911604_PUBLIC RELATIONS OFFICER, ELLA  NOBESIS.JPG'],
            // 18
            ['first_name' => 'Golemeer',             'last_name' => 'Rambuyon',   'middle_name' => 'Quilinguin',  'partylist_id' => $silak,  'organization_id' => $sbo, 'position_id' => $treasurer,      'college_id' => $coe,  'course' => 'BSED-MATH',    'photo' => '1775912981_TREASURER, GOLEMEER RAMBUYON.JPG'],
            // 19
            ['first_name' => 'Nashrea',              'last_name' => 'Dumagpi',    'middle_name' => 'Meliston',    'partylist_id' => $silak,  'organization_id' => $sbo, 'position_id' => $viceGovernor,   'college_id' => $coe,  'course' => 'BSED-SOCSTUD', 'photo' => '1775913062_VICE GOVERNOR, NASHREA DUMAGPI.JPG'],
            // 20
            ['first_name' => 'Corrine May',          'last_name' => 'Molina',     'middle_name' => null,          'partylist_id' => $silak,  'organization_id' => $sbo, 'position_id' => $fourthYearRep,  'college_id' => $coe,  'course' => 'BECED',        'photo' => '1775913635_4TH YEAR REPRESENTATIVE, CORRINE MAY MOLINA.JPG'],
            // 21
            ['first_name' => 'Patrick Charles',      'last_name' => 'Melendez',   'middle_name' => 'Casulla',     'partylist_id' => $silak,  'organization_id' => $sbo, 'position_id' => $assocTreasurer, 'college_id' => $coe,  'course' => 'BSED-ENG',     'photo' => '1775913682_ASSOCIATE TREASURER, PATRICK CHARLES MELENDEZ.JPG'],
            // 22
            ['first_name' => 'Jade Ross',            'last_name' => 'Montañez',   'middle_name' => 'Ruiz',        'partylist_id' => $silak,  'organization_id' => $sbo, 'position_id' => $secretary,      'college_id' => $coe,  'course' => 'BEED',         'photo' => '1775913733_SECRETARY, JADE ROSS MONTAÑEZ.JPG'],

            // ══════════════════════════════════════════════════════════
            //  IDs 23–32 | COLLEGE OF TECHNOLOGIES (COT) — HIRAYA / SBO
            //  (ID 24: Ochavillo is COB / SSC per the SQL dump)
            // ══════════════════════════════════════════════════════════

            // 23
            ['first_name' => 'Jehoiakim Jezer',      'last_name' => 'Luna',       'middle_name' => 'Mantilla',    'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $secondYearRep,  'college_id' => $cot,  'course' => 'BSIT',         'photo' => '1775916151_2ND_YEAR_REP_LUNA.JPG'],
            // 24 — college=COB, org=SSC (as in SQL)
            ['first_name' => 'Josine',               'last_name' => 'Ochavillo',  'middle_name' => 'Tagadiad',    'partylist_id' => $hiraya, 'organization_id' => $ssc, 'position_id' => $fourthYearRep,  'college_id' => $cob,  'course' => 'BSBA-FM A',    'photo' => '1775916352_4th Year Representative_Ochavillo.JPG'],
            // 25
            ['first_name' => 'Stephen',              'last_name' => 'Ga',         'middle_name' => 'Tanallon',    'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $assocTreasurer, 'college_id' => $cot,  'course' => 'BS-FT',        'photo' => '1775916428_ASSOCIATE TREASURER_GA.JPG'],
            // 26
            ['first_name' => 'Christian Joshua',     'last_name' => 'Defensor',   'middle_name' => 'Gonzales',    'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $assocSecretary, 'college_id' => $cot,  'course' => 'BS-FT',        'photo' => '1775916471_ASSOCIATE_SECRETARY_DEFENSOR.JPG'],
            // 27
            ['first_name' => 'Joanna Nicole',        'last_name' => 'Yroy',       'middle_name' => 'Parreño',     'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $auditor,        'college_id' => $cot,  'course' => 'BSIT',         'photo' => '1775916499_AUDITOR_YROY.JPG'],
            // 28
            ['first_name' => 'Jeff Ivan',            'last_name' => 'Mayor',      'middle_name' => 'Biosano',     'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $governor,       'college_id' => $cot,  'course' => 'BSIT',         'photo' => '1775916597_GOVERNOR_MAYOR.JPG'],
            // 29
            ['first_name' => 'Peter Victor',         'last_name' => 'Dawis',      'middle_name' => 'D',           'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $pro,            'college_id' => $cot,  'course' => 'BSIT',         'photo' => '1775916633_PRO_DAWIS.JPG'],
            // 30
            ['first_name' => 'Kimverly',             'last_name' => 'Suelo',      'middle_name' => 'Pabio',       'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $secretary,      'college_id' => $cot,  'course' => 'BSIT',         'photo' => '1775916727_SECRETARY_SUELO.JPG'],
            // 31
            ['first_name' => 'Bianca Nicolette',     'last_name' => 'Garcia',     'middle_name' => 'Manlangatan', 'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $treasurer,      'college_id' => $cot,  'course' => 'BSEMC-DAT',    'photo' => '1775916759_TREASURER_GARCIA.JPG'],
            // 32
            ['first_name' => 'Carlitos Mari',        'last_name' => 'Simene',     'middle_name' => 'Partosa',     'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $viceGovernor,   'college_id' => $cot,  'course' => 'BSIT',         'photo' => '1775916817_VICE_GOVERNOR_SIMENE.JPG'],

            // ══════════════════════════════════════════════════════════
            //  IDs 33–43 | COLLEGE OF BUSINESS (COB) — BANAAG / SBO
            // ══════════════════════════════════════════════════════════

            // 33
            ['first_name' => 'Joshua',               'last_name' => 'Manaran',    'middle_name' => 'Tumangday',   'partylist_id' => $banaag, 'organization_id' => $sbo, 'position_id' => $fourthYearRep,  'college_id' => $cob,  'course' => 'BS-HM',        'photo' => '1775916878_4th Year Representative_Joshua Manaran.JPG'],
            // 34
            ['first_name' => 'Lian Carl',            'last_name' => 'Viloria',    'middle_name' => 'Talatala',    'partylist_id' => $banaag, 'organization_id' => $sbo, 'position_id' => $viceGovernor,   'college_id' => $cob,  'course' => 'BSBA-FM A',    'photo' => '1775916951_Vice Governor_Lian Carl Viloria.JPG'],
            // 35
            ['first_name' => 'Reginald',             'last_name' => 'Omboy',      'middle_name' => 'Alcayde',     'partylist_id' => $banaag, 'organization_id' => $sbo, 'position_id' => $secondYearRep,  'college_id' => $cob,  'course' => 'BS-HM',        'photo' => '1775916998_2nd Year Representative_Reginald Omboy.JPG'],
            // 36
            ['first_name' => 'Khiet Warren',         'last_name' => 'Gumban',     'middle_name' => 'Benigay',     'partylist_id' => $banaag, 'organization_id' => $sbo, 'position_id' => $thirdYearRep,   'college_id' => $cob,  'course' => 'BS-HM',        'photo' => '1775917083_3rd Year Representative_Khiet Warren Gumban.JPG'],
            // 37
            ['first_name' => 'Allaiza Mae',          'last_name' => 'Niedo',      'middle_name' => 'Cabalida',    'partylist_id' => $banaag, 'organization_id' => $sbo, 'position_id' => $assocSecretary, 'college_id' => $cob,  'course' => 'BSA',          'photo' => '1775917115_Associate Secretary_Allaiza Mae Niedo.JPG'],
            // 38
            ['first_name' => 'Hannah Dale',          'last_name' => 'Fernandez',  'middle_name' => 'Sundo',       'partylist_id' => $banaag, 'organization_id' => $sbo, 'position_id' => $assocTreasurer, 'college_id' => $cob,  'course' => 'BSA',          'photo' => '1775917148_Associate Treasurer_ Hannah Dale Fernandez.JPG'],
            // 39
            ['first_name' => 'Alyssa Gwyn',          'last_name' => 'Colipano',   'middle_name' => 'Aurita',      'partylist_id' => $banaag, 'organization_id' => $sbo, 'position_id' => $auditor,        'college_id' => $cob,  'course' => 'BSA',          'photo' => '1775917188_Auditor_Alyssa Gwyn Colipano.JPG'],
            // 40
            ['first_name' => 'Aliah',                'last_name' => 'Namocot',    'middle_name' => 'Sardido',     'partylist_id' => $banaag, 'organization_id' => $sbo, 'position_id' => $governor,       'college_id' => $cob,  'course' => 'BSBA-FM A',    'photo' => '1775917216_Governor_Aliah Namocot.JPG'],
            // 41
            ['first_name' => 'Joshua Jave',          'last_name' => 'Dinlayan',   'middle_name' => 'Tan Nery',    'partylist_id' => $banaag, 'organization_id' => $sbo, 'position_id' => $pro,            'college_id' => $cob,  'course' => 'BS-HM',        'photo' => '1775917246_Public Relations Officer_Joshua Jave Dinlayan.JPG'],
            // 42
            ['first_name' => 'Methusilah',           'last_name' => 'Vito',       'middle_name' => 'Padre-E',     'partylist_id' => $banaag, 'organization_id' => $sbo, 'position_id' => $secretary,      'college_id' => $cob,  'course' => 'BS-HM',        'photo' => '1775917270_Secretary_Methusilah Vito.JPG'],
            // 43
            ['first_name' => 'Jeanneil',             'last_name' => 'Lira',       'middle_name' => 'Cuyos',       'partylist_id' => $banaag, 'organization_id' => $sbo, 'position_id' => $treasurer,      'college_id' => $cob,  'course' => 'BSA',          'photo' => '1775917313_Treasurer_Jeanneil Lira.JPG'],

            // ══════════════════════════════════════════════════════════
            //  IDs 44–54 | COLLEGE OF ARTS & SCIENCES (CAS) — SILAK / SBO
            // ══════════════════════════════════════════════════════════

            // 44
            ['first_name' => 'Hazel Faith',          'last_name' => 'Lantong',    'middle_name' => 'Allosada',    'partylist_id' => $silak,  'organization_id' => $sbo, 'position_id' => $secondYearRep,  'college_id' => $cas,  'course' => 'BS-BIO',       'photo' => '1775917368_2ND YEAR REPRESENTATIVE, HAZEL FAITH LANTONG.JPG'],
            // 45
            ['first_name' => 'Irish Jane',           'last_name' => 'Lofranco',   'middle_name' => 'Palingcod',   'partylist_id' => $silak,  'organization_id' => $sbo, 'position_id' => $thirdYearRep,   'college_id' => $cas,  'course' => 'AB-ECON',      'photo' => '1775917404_3RD YEAR REPRESENTATIVE, IRISH JANE LOFRANCO_.JPG'],
            // 46
            ['first_name' => 'Margalo Clarrise',     'last_name' => 'Fernandez',  'middle_name' => 'Jagunos',     'partylist_id' => $silak,  'organization_id' => $sbo, 'position_id' => $fourthYearRep,  'college_id' => $cas,  'course' => 'AB-ECON',      'photo' => '1775917436_4TH YEAR REPRESENTATIVE, MARGALO FERNANDEZ.JPG'],
            // 47
            ['first_name' => 'Coleen',               'last_name' => 'Vestidas',   'middle_name' => 'Cañete',      'partylist_id' => $silak,  'organization_id' => $sbo, 'position_id' => $secretary,      'college_id' => $cas,  'course' => 'AB-SOCIO',     'photo' => '1775917492_ASSOCIATE SECRETARY, COLEEN VESTIDAS.JPG'],
            // 48
            ['first_name' => 'Kennan Jemm',          'last_name' => 'Tejero',     'middle_name' => 'Gomez',       'partylist_id' => $silak,  'organization_id' => $sbo, 'position_id' => $assocTreasurer, 'college_id' => $cas,  'course' => 'BS-BIO',       'photo' => '1775917530_ASSOCIATE TREASURER, KENNAN JEMM TEJERO.JPG'],
            // 49
            ['first_name' => 'Christopher',          'last_name' => 'Dumaque',    'middle_name' => 'Fernandez',   'partylist_id' => $silak,  'organization_id' => $sbo, 'position_id' => $auditor,        'college_id' => $cas,  'course' => 'AB-PHILO',     'photo' => '1775917555_AUDITOR, CHRISTOPHER DUMAQUE_.JPG'],
            // 50
            ['first_name' => 'Camilo Jr.',           'last_name' => 'Anaya',      'middle_name' => 'Abella',      'partylist_id' => $silak,  'organization_id' => $sbo, 'position_id' => $governor,       'college_id' => $cas,  'course' => 'AB-PHILO',     'photo' => '1775917597_GOVERNOR, CAMILO ANAYA.JPG'],
            // 51
            ['first_name' => 'Jayvee',               'last_name' => 'Okinlay',    'middle_name' => 'Baculbacul',  'partylist_id' => $silak,  'organization_id' => $sbo, 'position_id' => $pro,            'college_id' => $cas,  'course' => 'BS-BIO',       'photo' => '1775917625_PUBLIC RELATIONS OFFICER, JAYVEE OKINLAY.JPG'],
            // 52
            ['first_name' => 'Aliah Faye',           'last_name' => 'Badajos',    'middle_name' => 'Sario',       'partylist_id' => $silak,  'organization_id' => $sbo, 'position_id' => $secretary,      'college_id' => $cas,  'course' => 'AB-ENG',       'photo' => '1775917651_SECRETARY, ALIAH FAYE BADAJOS.JPG'],
            // 53
            ['first_name' => 'Justine Mark',         'last_name' => 'Longcob',    'middle_name' => 'Lagat',       'partylist_id' => $silak,  'organization_id' => $sbo, 'position_id' => $treasurer,      'college_id' => $cas,  'course' => 'BS-MATH',      'photo' => '1775917683_TREASURER, JUSTINE MARK LONGCOB.JPG'],
            // 54
            ['first_name' => 'Billy Joel',           'last_name' => 'Briones',    'middle_name' => 'Caingcoy',    'partylist_id' => $silak,  'organization_id' => $sbo, 'position_id' => $viceGovernor,   'college_id' => $cas,  'course' => 'AB-ENG',       'photo' => '1775917712_VICE GOVERNOR, BILLY JOEL BRIONES.JPG'],

            // ══════════════════════════════════════════════════════════
            //  IDs 55–66 | SSC SENATORS + VICE PRESIDENT — HIRAYA / SSC
            // ══════════════════════════════════════════════════════════

            // 55
            ['first_name' => 'Edric Lance',          'last_name' => 'Gabrinez',   'middle_name' => 'Opiala',      'partylist_id' => $hiraya, 'organization_id' => $ssc, 'position_id' => $senator,        'college_id' => $coe,  'course' => 'BPED',         'photo' => '1775918291_Edric Lance Gabrinez - Senator_.JPG'],
            // 56
            ['first_name' => 'Jan Mark',             'last_name' => 'Abao',       'middle_name' => 'Villarta',    'partylist_id' => $hiraya, 'organization_id' => $ssc, 'position_id' => $senator,        'college_id' => $cas,  'course' => 'BS-ES',        'photo' => '1775918616_Jan Mark Abao-Senator_Pic 2.JPG'],
            // 57
            ['first_name' => 'Jasmin',               'last_name' => 'Cantina',    'middle_name' => 'Pacres',      'partylist_id' => $hiraya, 'organization_id' => $ssc, 'position_id' => $senator,        'college_id' => $coe,  'course' => 'BSED-SCI',     'photo' => '1775918687_Jasmin Cantina-Senator-Pic1.JPG'],
            // 58
            ['first_name' => 'Karl Andre',           'last_name' => 'Barete',     'middle_name' => 'Gabisay',     'partylist_id' => $hiraya, 'organization_id' => $ssc, 'position_id' => $senator,        'college_id' => $coe,  'course' => 'BSED-SOCSTUD', 'photo' => '1775918733_Karl Andre G. Barete - Senator (Pic 2).JPG'],
            // 59
            ['first_name' => 'Marvin',               'last_name' => 'Vacalares',  'middle_name' => 'Cadoyac',     'partylist_id' => $hiraya, 'organization_id' => $ssc, 'position_id' => $senator,        'college_id' => $cot,  'course' => 'BSAT',         'photo' => '1775918788_Marvin Vacalares- Senator.JPG'],
            // 60
            ['first_name' => 'Prinze Wayne',         'last_name' => 'Chacon',     'middle_name' => 'Encarguez',   'partylist_id' => $hiraya, 'organization_id' => $ssc, 'position_id' => $senator,        'college_id' => $cas,  'course' => 'AB-ENG',       'photo' => '1775918844_Prinze Wayne Chacon _ senator.JPG'],
            // 61
            ['first_name' => 'Angela',               'last_name' => 'Vegafria',   'middle_name' => 'Calamba',     'partylist_id' => $hiraya, 'organization_id' => $ssc, 'position_id' => $senator,        'college_id' => $coe,  'course' => 'BECED',        'photo' => '1775918883_Angela C. Vegafria_Senator.JPG'],
            // 62
            ['first_name' => 'Chona Mae',            'last_name' => 'Nalda',      'middle_name' => 'Enriquez',    'partylist_id' => $hiraya, 'organization_id' => $ssc, 'position_id' => $senator,        'college_id' => $cas,  'course' => 'BS-ES',        'photo' => '1775919022_Chona Mae Nalda-Senator_ Pic 1.JPG'],
            // 63
            ['first_name' => 'Jamal',                'last_name' => 'Langcap',    'middle_name' => 'Ampuan',      'partylist_id' => $hiraya, 'organization_id' => $ssc, 'position_id' => $senator,        'college_id' => $cob,  'course' => 'BSA',          'photo' => '1775919086_Jamal A. Langcap_Senator.JPG'],
            // 64
            ['first_name' => 'Joseph',               'last_name' => 'Ginolos',    'middle_name' => 'Baja',        'partylist_id' => $hiraya, 'organization_id' => $ssc, 'position_id' => $vicePresident,  'college_id' => $coe,  'course' => 'BSED-ENG',     'photo' => '1775919160_Joseph Ginolos-Vice President-Pic1.JPG'],
            // 65
            ['first_name' => 'Kizza Jean',           'last_name' => 'Muralla',    'middle_name' => 'Kilem',       'partylist_id' => $hiraya, 'organization_id' => $ssc, 'position_id' => $senator,        'college_id' => $coe,  'course' => 'BSED-SCI',     'photo' => '1775919233_Kizza Muralla_Senator_Pic1.JPG'],
            // 66
            ['first_name' => 'Rodren Jay',           'last_name' => 'Sumbongan',  'middle_name' => 'Daming',      'partylist_id' => $hiraya, 'organization_id' => $ssc, 'position_id' => $senator,        'college_id' => $cas,  'course' => 'AB-PHILO',     'photo' => '1775919305_Rodren Jay Sumbongan - Senator_Pic 2.JPG'],

            // ══════════════════════════════════════════════════════════
            //  IDs 67–68 | LATE ADDITIONS — COT / CAS — HIRAYA / SBO
            // ══════════════════════════════════════════════════════════

            // 67 — CAS 2nd Year Rep
            ['first_name' => 'Keno Gabriel',         'last_name' => 'Saligoyan',  'middle_name' => null,          'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $secondYearRep,  'college_id' => $cas,  'course' => 'BSDC',         'photo' => '1775976678_2ND YEAR REPRESENTATIVE.JPG'],
            // 68 — COT 3rd Year Rep
            ['first_name' => 'Kyle Christopher',     'last_name' => 'Salvador',   'middle_name' => 'Cabactulan',  'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $thirdYearRep,   'college_id' => $cot,  'course' => 'BSET',         'photo' => '1775977369_3RD_YEAR_REP.JPG'],

            // ══════════════════════════════════════════════════════════
            //  IDs 69–79 | COLLEGE OF PUBLIC ADMIN & GOVERNANCE (CPAG)
            //             — HIRAYA / SBO
            // ══════════════════════════════════════════════════════════

            // 69
            ['first_name' => 'Jhon Joshua',          'last_name' => 'Alipaopao',  'middle_name' => 'Hermosada',   'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $governor,       'college_id' => $cpag, 'course' => 'BPA',          'photo' => null],
            // 70
            ['first_name' => 'Jhunine',              'last_name' => 'Pontillas',  'middle_name' => 'Perez',       'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $viceGovernor,   'college_id' => $cpag, 'course' => 'BPA',          'photo' => null],
            // 71
            ['first_name' => 'Prencess Michien',     'last_name' => 'Barace',     'middle_name' => null,          'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $secretary,      'college_id' => $cpag, 'course' => 'BPA',          'photo' => null],
            // 72
            ['first_name' => 'Princess Loraine',     'last_name' => 'Tapulgo',    'middle_name' => 'Quirog',      'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $assocSecretary, 'college_id' => $cpag, 'course' => 'BPA',          'photo' => null],
            // 73
            ['first_name' => 'Karl David',           'last_name' => 'Saqui',      'middle_name' => 'Valdez',      'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $treasurer,      'college_id' => $cpag, 'course' => 'BPA',          'photo' => null],
            // 74
            ['first_name' => 'Janeth',               'last_name' => 'Casas',      'middle_name' => 'Magtortor',   'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $assocTreasurer, 'college_id' => $cpag, 'course' => 'BPA',          'photo' => null],
            // 75
            ['first_name' => 'Ferdie John Luis',     'last_name' => 'Jamora',     'middle_name' => 'Talondata',   'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $auditor,        'college_id' => $cpag, 'course' => 'BPA',          'photo' => null],
            // 76
            ['first_name' => 'Princess',             'last_name' => 'Delfin',     'middle_name' => 'Montañez',    'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $pro,            'college_id' => $cpag, 'course' => 'BPA',          'photo' => null],
            // 77
            ['first_name' => 'Zyrylle Keyth',        'last_name' => 'Saguinhon',  'middle_name' => 'Lumod',       'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $fourthYearRep,  'college_id' => $cpag, 'course' => 'BPA',          'photo' => null],
            // 78
            ['first_name' => 'Gabriela Kim',         'last_name' => 'Casundo',    'middle_name' => 'Maston',      'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $thirdYearRep,   'college_id' => $cpag, 'course' => 'BPA',          'photo' => null],
            // 79
            ['first_name' => 'Lynci',                'last_name' => 'Edralin',    'middle_name' => 'Sibayan',     'partylist_id' => $hiraya, 'organization_id' => $sbo, 'position_id' => $secondYearRep,  'college_id' => $cpag, 'course' => 'BPA',          'photo' => null],
        ];

        // ── Insert / Update ───────────────────────────────────────────
        $count = 0;
        foreach ($candidates as $data) {
            Candidate::updateOrCreate(
                [
                    'first_name'  => $data['first_name'],
                    'last_name'   => $data['last_name'],
                    'position_id' => $data['position_id'],
                    'college_id'  => $data['college_id'],
                ],
                $data
            );
            $count++;
        }

        $this->command->info("✅ CandidateSeeder complete: {$count} candidates seeded.");
    }
}