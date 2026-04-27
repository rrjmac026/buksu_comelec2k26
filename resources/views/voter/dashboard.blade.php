
<x-app-layout>
    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/voter/dashboard.css'])

    {{-- ── Background ambient orbs (exact admin/landing page sizes) ── --}}
    <div class="vd-orb vd-orb-1"></div>
    <div class="vd-orb vd-orb-2"></div>
    <div class="vd-orb vd-orb-3"></div>

    {{-- ── Page content wrapper ── --}}
    <div class="vd-page-content">

    {{-- ═══════════════════════════════════════════
         WELCOME BANNER
    ═══════════════════════════════════════════ --}}
    <div class="welcome-banner">
        <div class="welcome-banner-grid"></div>
        <div class="welcome-inner">
            <div>
                <h2 class="welcome-title"
                    style="font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:900;color:#fffbf0;margin:0 0 7px 0;line-height:1.25;text-shadow:0 2px 20px rgba(249,180,15,0.15);">
                    Welcome, {{ $voter->full_name }}! 👋
                </h2>
                <p class="welcome-sub"
                   style="font-size:.82rem;color:rgba(255,251,240,0.62);margin:0;line-height:1.65;max-width:520px;">
                    {{ $hasVoted
                        ? "Thank you for casting your vote! Your participation helps shape the future of our organization."
                        : "You're invited to participate in this important election. Your voice matters—cast your vote now!" }}
                </p>
            </div>
            <div class="welcome-date">
                <span style="font-family:'Playfair Display',serif;font-size:.9rem;font-weight:800;background:linear-gradient(135deg,#f9b40f,#fcd558);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                    {{ now()->format('l, F j, Y') }}
                </span>
            </div>
        </div>
    </div>

    @php
        $electionStatus = $electionStatus ?? \App\Models\ElectionSetting::status();
        $normalizedElectionStatus = $electionStatus === 'upcoming' ? 'not_started' : $electionStatus;
        $voteBlocked = in_array($normalizedElectionStatus, ['not_started', 'ended'], true);
        $voteTooltip = $normalizedElectionStatus === 'not_started'
            ? 'Voting will be available once the election starts'
            : 'Voting is closed because the election has ended';
    @endphp

    {{-- ── Election Status Banner ── --}}
    @if(in_array($electionStatus, ['upcoming', 'not_started'], true))
    <div class="vd-election-banner upcoming">
        <div class="vd-election-banner-icon"><i class="fas fa-hourglass-start"></i></div>
        <div style="flex:1;">
            <div class="vd-election-banner-title">Election Coming Soon</div>
            <div class="vd-election-banner-sub">The election has not opened yet. Voting will be enabled once it begins. Stay tuned!</div>
        </div>
        <span class="vd-election-banner-chip">UPCOMING</span>
    </div>

    @elseif($electionStatus === 'ended')
    <div class="vd-election-banner ended">
        <div class="vd-election-banner-icon"><i class="fas fa-flag-checkered"></i></div>
        <div style="flex:1;">
            <div class="vd-election-banner-title">Election Has Ended</div>
            <div class="vd-election-banner-sub">The voting period is now closed. Thank you to everyone who participated!</div>
        </div>
        <span class="vd-election-banner-chip">ENDED</span>
    </div>

    @elseif($electionStatus === 'ongoing')
    <div class="vd-election-banner live">
        <div class="vd-election-banner-icon">
            <span class="vd-live-dot"></span>
            <i class="fas fa-circle-dot"></i>
        </div>
        <div style="flex:1;">
            <div class="vd-election-banner-title">Election is Live!</div>
            <div class="vd-election-banner-sub">Voting is now open. Cast your ballot before the election closes.</div>
        </div>
        <span class="vd-election-banner-chip">LIVE NOW</span>
    </div>
    @endif

    {{-- Flash Messages --}}
    @if(session('error'))
    <div class="vd-flash error">
        <i class="fas fa-circle-xmark" style="flex-shrink:0;"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif
    @if(session('info'))
    <div class="vd-flash info">
        <i class="fas fa-circle-info" style="flex-shrink:0;"></i>
        <span>{{ session('info') }}</span>
    </div>
    @endif

    {{-- ═══════════════════════════════════════════
         STATUS BANNER
    ═══════════════════════════════════════════ --}}
    <div class="vd-status-banner {{ $hasVoted ? 'voted' : 'not-voted' }} mb-4">
        <div class="status-inner">
            {{-- Icon + Text --}}
            <div class="status-top">
                <div class="vd-check-icon"
                     style="background:{{ $hasVoted ? 'rgba(52,211,153,0.15)' : 'rgba(249,180,15,0.12)' }};
                            border:2px solid {{ $hasVoted ? 'rgba(52,211,153,0.35)' : 'rgba(249,180,15,0.3)' }};">
                    <i class="fas {{ $hasVoted ? 'fa-check-double' : 'fa-ballot-check' }}"
                       style="color:{{ $hasVoted ? '#34d399' : '#f9b40f' }};"></i>
                </div>
                <div class="status-body">
                    <div class="status-banner-title"
                         style="font-family:'Playfair Display',serif;font-size:.95rem;font-weight:800;color:#fffbf0;margin-bottom:5px;line-height:1.25;">
                        {{ $hasVoted ? 'Your vote has been recorded!' : "You haven't voted yet" }}
                    </div>
                    <div class="status-banner-sub"
                         style="font-size:.75rem;color:rgba(255,251,240,0.55);line-height:1.6;">
                        @if($hasVoted)
                            Thank you for participating. Your vote is anonymous and securely stored. Results will be announced after the election period ends.
                        @else
                            The election is currently open. Exercise your right to vote and make your voice heard. Every vote counts toward shaping the leadership of your organization.
                        @endif
                    </div>
                </div>
            </div>

            {{-- CTA / Voted date --}}
            <div style="flex-shrink:0;">
                @if($hasVoted)
                    <div style="display:flex;flex-direction:column;gap:8px;align-items:flex-end;">
                        {{-- Voted-on timestamp --}}
                        <div class="voted-on-box"
                             style="padding:10px 14px;border-radius:var(--radius-sm);background:rgba(52,211,153,0.08);border:1px solid rgba(52,211,153,0.2);text-align:center;">
                            <div class="voted-on-label"
                                 style="font-size:.62rem;color:rgba(255,251,240,0.35);margin-bottom:3px;">Voted on</div>
                            <div class="voted-on-date"
                                 style="font-family:'Playfair Display',serif;font-size:.78rem;color:#34d399;font-weight:700;">
                                {{ $myVotes->first()?->voted_at?->format('M d, Y · g:i A') ?? '—' }}
                            </div>
                        </div>
                        {{-- Voting Details button --}}
                        <a href="{{ route('voter.vote.details') }}"
                           style="display:inline-flex;align-items:center;gap:7px;
                                  padding:9px 18px;border-radius:var(--radius-sm);
                                  background:linear-gradient(135deg,#f9b40f,#fcd558);
                                  color:#380041;font-size:.72rem;font-weight:800;
                                  text-decoration:none;white-space:nowrap;
                                  box-shadow:0 4px 16px rgba(249,180,15,0.3),inset 0 1px 0 rgba(255,255,255,0.2);
                                  transition:all .2s;font-family:'DM Sans',sans-serif;">
                            <i class="fas fa-receipt" style="font-size:.7rem;"></i>
                            View Voting Details
                        </a>
                    </div>
                @else
                    <a href="{{ route('voter.vote.intro') }}"
                       class="vd-cta-btn vd-cta-btn-full {{ $voteBlocked ? 'opacity-70 cursor-not-allowed' : '' }}"
                       data-election-guard="vote"
                       title="{{ $voteBlocked ? $voteTooltip : '' }}"
                       aria-disabled="{{ $voteBlocked ? 'true' : 'false' }}">
                            <i class="fas fa-vote-yea"></i> Cast My Vote Now
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
         MAIN GRID  (Profile | Bible Quote)
    ═══════════════════════════════════════════ --}}
    <div class="vd-main-grid">

        {{-- MY PROFILE --}}
        <div class="vd-gc p-5" style="animation-delay:.12s;">
            {{-- Avatar row --}}
            <div style="display:flex;align-items:center;gap:14px;margin-bottom:16px;padding-bottom:14px;border-bottom:1px solid rgba(249,180,15,0.08);">
                <div style="width:50px;height:50px;border-radius:14px;background:linear-gradient(135deg,#f9b40f,#fcd558);display:flex;align-items:center;justify-content:center;font-size:1.15rem;font-weight:900;color:#380041;flex-shrink:0;box-shadow:0 0 18px rgba(249,180,15,0.4);font-family:'Playfair Display',serif;">
                    {{ strtoupper(substr($voter->full_name, 0, 1)) }}
                </div>
                <div style="min-width:0;">
                    <div class="profile-name" style="font-size:.88rem;font-weight:700;color:#fffbf0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $voter->full_name }}</div>
                    <div class="profile-email" style="font-size:.68rem;color:rgba(255,251,240,0.4);margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $voter->email }}</div>
                    <div style="display:inline-flex;align-items:center;gap:4px;margin-top:5px;padding:2px 9px;border-radius:20px;background:rgba(52,211,153,0.1);border:1px solid rgba(52,211,153,0.2);">
                        <span style="width:5px;height:5px;border-radius:50%;background:#34d399;display:inline-block;"></span>
                        <span style="font-size:.6rem;font-weight:700;color:#34d399;letter-spacing:.06em;">{{ strtoupper($voter->status ?? 'Active') }}</span>
                    </div>
                </div>
            </div>

            {{-- Info rows --}}
            @php
                $infos = [
                    ['label'=>'Student No.', 'value'=>$voter->student_number ?: '—',                             'icon'=>'fa-id-card'],
                    ['label'=>'College',     'value'=>$voter->college?->name ?: '—',                             'icon'=>'fa-building-columns'],
                    ['label'=>'Course',      'value'=>$voter->course ?: '—',                                     'icon'=>'fa-book'],
                    ['label'=>'Year Level',  'value'=>$voter->year_level ? 'Year '.$voter->year_level : '—',     'icon'=>'fa-graduation-cap'],
                    ['label'=>'Sex',         'value'=>$voter->sex ? ucfirst($voter->sex) : '—',                  'icon'=>'fa-venus-mars'],
                ];
            @endphp
            @foreach($infos as $info)
            <div class="vd-info-row">
                <div style="display:flex;align-items:center;gap:8px;">
                    <i class="fas {{ $info['icon'] }} info-icon" style="width:14px;text-align:center;font-size:.7rem;color:rgba(249,180,15,0.4);flex-shrink:0;"></i>
                    <span class="info-label" style="font-size:.7rem;color:rgba(255,251,240,0.4);">{{ $info['label'] }}</span>
                </div>
                <span style="font-size:.72rem;font-weight:600;color:rgba(249,180,15,0.85);text-align:right;max-width:55%;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ $info['value'] }}
                </span>
            </div>
            @endforeach
        </div>

        {{-- BIBLE QUOTE CARD --}}
        <div class="bible-card"
             x-data="{
                 quote: '',
                 reference: '',
                 loading: true,
                 spinning: false,
                 async fetchQuote() {
                     this.spinning = true;
                     this.loading  = true;
                     try {
                         const res  = await fetch('https://labs.bible.org/api/?passage=random&type=json');
                         const data = await res.json();
                         this.quote     = data[0].text;
                         this.reference = data[0].bookname + ' ' + data[0].chapter + ':' + data[0].verse;
                     } catch {
                         this.quote     = 'Choose some wise, understanding and respected men from each of your tribes, and I will set them over you.';
                         this.reference = 'Deuteronomy 1:13';
                     }
                     this.loading  = false;
                     this.spinning = false;
                 }
             }"
             x-init="fetchQuote(); setInterval(() => fetchQuote(), 20000)">

            <div class="bible-card-header">
                <div class="bible-card-label">
                    <i class="fas fa-book-bible"></i>
                    Verse of the Moment
                </div>
                <button class="bible-refresh-btn"
                        :class="{ spinning: spinning }"
                        @click="fetchQuote()"
                        :disabled="spinning">
                    <i class="fas fa-sync-alt"></i>
                    New Verse
                </button>
            </div>

            {{-- Loading skeleton --}}
            <div x-show="loading"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-end="opacity-0">
                <div class="bible-skeleton" style="width:100%;"></div>
                <div class="bible-skeleton" style="width:88%;"></div>
                <div class="bible-skeleton" style="width:72%;margin-bottom:14px;"></div>
                <div class="bible-skeleton" style="width:40%;height:22px;border-radius:99px;"></div>
            </div>

            {{-- Quote --}}
            <div x-show="!loading"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0">
                <p class="bible-quote-text" x-text="'\u201C' + quote + '\u201D'"></p>
                <span class="bible-quote-ref">
                    <i class="fas fa-bookmark" style="font-size:.55rem;"></i>
                    <span x-text="reference"></span>
                </span>
            </div>
        </div>
        {{-- END BIBLE QUOTE CARD --}}

    </div>

    {{-- close .vd-page-content --}}
    </div>

</x-app-layout>