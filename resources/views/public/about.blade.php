@extends('layouts.public-site', ['title' => 'About | BukSU COMELEC', 'activePage' => 'about'])

@section('content')
    @php
        $developmentTeam = [
            [
                'name' => 'Rey Rameses Jude "Jam" Macalutas III',
                'role' => 'System Developer / Lead Developer',
                'avatar' => asset('assets/team/dev1.jpg'),
                'initials' => 'JM',
                'contributions' => [
                    'Built the full-stack system end-to-end',
                    'Designed the overall look and feel of the app',
                    'Kept the codebase clean and running solid',
                ],
            ],
            [
                'name' => 'Khyle Ivan Kim Amacna',
                'role' => 'Head System Developer',
                'avatar' => asset('assets/team/dev2.jpg'),
                'initials' => 'KA',
                'contributions' => [
                    'Led the team and kept everything moving',
                    'Crafted intuitive UI/UX experiences',
                    'Made sure every screen looks just right',
                ],
            ],
            [
                'name' => 'Bernardo DeLa Cerna Jr.',
                'role' => 'System Developer / QA',
                'avatar' => asset('assets/team/dev3.jpg'),
                'initials' => 'BC',
                'contributions' => [
                    'Tested and caught bugs before they cause trouble',
                    'Handled and cleaned up all the messy data',
                    'Made sure the numbers always add up right',
                ],
            ],
        ];

        $commissionTeam = [
            ['name' => 'Mark Ian Mukara', 'role' => 'Adviser', 'initials' => 'MM', 'contributions' => ['Guided the team throughout the system development', 'Reviewed system direction and implementation', 'Provided insights for improvement']],
            ['name' => 'Roxanne Mae Ortega', 'role' => 'Head Commissioner', 'initials' => 'RO', 'contributions' => ['Led COMELEC operations', 'Coordinated election tasks', 'Ensured fair procedures']],
            ['name' => 'Yassin Naga', 'role' => 'Internal Commissioner', 'initials' => 'YN', 'contributions' => ['Managed internal coordination', 'Organized records and updates', 'Maintained communication']],
            ['name' => 'Steven Bagasbas', 'role' => 'External Commissioner', 'initials' => 'SB', 'contributions' => ['Handled external communication', 'Managed announcements', 'Coordinated stakeholders']],
            ['name' => 'Khisia Faith Llanera', 'role' => 'Logistics Commissioner', 'initials' => 'KL', 'contributions' => ['Managed election logistics', 'Organized materials and resources', 'Supported operations']],
            ['name' => 'Elaine Mae Furog', 'role' => 'Canvass Commissioner', 'initials' => 'EF', 'contributions' => ['Handled vote validation', 'Ensured accuracy of results', 'Supported transparency']],
            ['name' => 'Rhoda Princess Diones', 'role' => 'Campaign Commissioner', 'initials' => 'RD', 'contributions' => ['Managed campaign processes', 'Monitored campaign guidelines', 'Ensured fairness']],
            ['name' => 'Marian Gewan', 'role' => 'Creatives Commissioner', 'initials' => 'MG', 'contributions' => ['Designed visual materials', 'Supported branding', 'Maintained visual consistency']],
            ['name' => 'Axiel Ivan Pacquiao', 'role' => 'Local Campaign Commissioner', 'initials' => 'AP', 'contributions' => ['Assisted local campaigns', 'Coordinated communication', 'Monitored activities']],
            ['name' => 'Kurt Kein Daguyo', 'role' => 'Local Campaign Commissioner', 'initials' => 'KD', 'contributions' => ['Supported campaign coordination', 'Ensured guidelines compliance', 'Assisted updates']],
            ['name' => 'Owen Jerusalem', 'role' => 'Local Creatives Commissioner', 'initials' => 'OJ', 'contributions' => ['Assisted design materials', 'Supported layouts', 'Maintained consistency']],
            ['name' => 'Gerardo Aranas Jr', 'role' => 'Local Creatives Commissioner', 'initials' => 'GA', 'contributions' => ['Helped design visuals', 'Assisted content creation', 'Improved presentation']],
        ];
    @endphp

    <section class="public-page-shell">
        <header class="page-header reveal">
            <h1 class="page-title">Meet the Team</h1>
            <p class="page-subtitle">The people behind the secure and reliable voting system.</p>
        </header>

        <section class="team-group">
            <div class="team-title-row reveal">
                <h2 class="team-title">Development Team</h2>
                <span class="team-line"></span>
            </div>
            <div class="team-grid">
                @foreach ($developmentTeam as $member)
                    <article class="glass-card team-card reveal lift-hover">
                        <div class="team-avatar">
                            <img src="{{ $member['avatar'] }}" alt="{{ $member['name'] }}"
                                onerror="this.style.display='none'; this.parentElement.querySelector('.team-avatar-fallback').style.display='flex';">
                            <div class="team-avatar-fallback" style="display:none;">{{ $member['initials'] }}</div>
                        </div>
                        <h3 class="team-name">{{ $member['name'] }}</h3>
                        <p class="team-role">{{ $member['role'] }}</p>
                        <div class="team-key">Key Contributions</div>
                        <ul class="team-list">
                            @foreach ($member['contributions'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="team-group">
            <div class="team-title-row reveal">
                <h2 class="team-title">COMELEC Commission Team</h2>
                <span class="team-line"></span>
            </div>
            <div class="team-grid">
                @foreach ($commissionTeam as $member)
                    <article class="glass-card team-card reveal lift-hover">
                        <div class="team-avatar">
                            <div class="team-avatar-fallback">{{ $member['initials'] }}</div>
                        </div>
                        <h3 class="team-name">{{ $member['name'] }}</h3>
                        <p class="team-role">{{ $member['role'] }}</p>
                        <div class="team-key">Key Contributions</div>
                        <ul class="team-list">
                            @foreach ($member['contributions'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </article>
                @endforeach
            </div>
        </section>
    </section>
@endsection
