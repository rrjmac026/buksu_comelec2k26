<x-app-layout>
    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }
        :root {
            --gold:      #f9b40f;
            --gold-lt:   #fcd558;
            --gold-dk:   #c98a00;
            --gold-pale: rgba(249,180,15,0.1);
            --violet:    #380041;
            --violet-md: #520060;
            --violet-lt: #6b0080;
            --cream:     #fffbf0;
            --ink:       #1a0020;
            --glass:     rgba(30,0,37,0.7);
            --glass-border: rgba(249,180,15,0.15);
            --radius-lg: 16px;
            --radius-md: 12px;
            --radius-sm: 8px;
        }

        @keyframes vd-pulse      { 0%,100%{opacity:1} 50%{opacity:.4} }
        @keyframes vd-fadeUp     { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:translateY(0)} }
        @keyframes vd-checkBounce{ 0%{transform:scale(0)} 60%{transform:scale(1.15)} 100%{transform:scale(1)} }
        @keyframes vd-quoteSlide { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }
        @keyframes vd-spin       { to{transform:rotate(360deg)} }
        @keyframes vd-shimmer    { 0%{background-position:200% 0} 100%{background-position:-200% 0} }

        body { font-family: 'DM Sans', sans-serif; }

        /* ── Glass Card ── */
        .vd-gc {
            background: var(--glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--radius-lg);
            box-shadow: 0 4px 30px rgba(0,0,0,0.3), inset 0 1px 0 rgba(249,180,15,0.06);
            animation: vd-fadeUp .5s ease both;
            position: relative;
            overflow: hidden;
        }
        .vd-gc::before {
            content:'';
            position:absolute; top:0; left:0; right:0; height:1px;
            background:linear-gradient(90deg,transparent,rgba(249,180,15,0.3),transparent);
            pointer-events:none;
        }

        /* ── Typography ── */
        .vd-section-label {
            font-size:.62rem; font-weight:700; letter-spacing:.1em;
            text-transform:uppercase; color:rgba(249,180,15,0.5); margin:0;
        }
        .vd-card-title {
            font-family:'Playfair Display',serif; font-size:.95rem; font-weight:800;
            color:var(--cream); letter-spacing:.01em; margin:0;
        }
        .vd-stat-num {
            font-family:'Playfair Display',serif; font-size:1.6rem; font-weight:900;
            background:linear-gradient(135deg,var(--gold) 0%,var(--gold-lt) 60%,#fff3c4 100%);
            -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
            line-height:1;
        }

        /* ── Icon Box ── */
        .vd-icon-box {
            width:40px; height:40px; border-radius:var(--radius-sm);
            display:flex; align-items:center; justify-content:center;
            font-size:.9rem; flex-shrink:0; color:#fff;
        }

        /* ── Progress ── */
        .vd-prog-track { height:6px; border-radius:99px; background:rgba(249,180,15,0.08); overflow:hidden; }
        .vd-prog-fill  { height:100%; border-radius:99px; transition:width 1.2s cubic-bezier(.4,0,.2,1); }

        /* ── Status Banner ── */
        .vd-status-banner {
            border-radius:var(--radius-lg); padding:20px;
            position:relative; overflow:hidden;
            animation:vd-fadeUp .4s ease both;
        }
        .vd-status-banner::after {
            content:''; position:absolute; top:0; left:0; right:0; height:1px;
            background:linear-gradient(90deg,transparent,rgba(249,180,15,0.4),transparent);
            pointer-events:none;
        }
        .vd-status-banner.voted     { background:linear-gradient(135deg,rgba(52,211,153,0.12),rgba(16,185,129,0.06)); border:1px solid rgba(52,211,153,0.2); }
        .vd-status-banner.not-voted { background:linear-gradient(135deg,rgba(56,0,65,0.8),rgba(82,0,96,0.6)); border:1px solid rgba(249,180,15,0.2); }

        .vd-check-icon {
            width:52px; height:52px; border-radius:50%;
            display:flex; align-items:center; justify-content:center;
            flex-shrink:0; font-size:1.4rem;
            animation:vd-checkBounce .6s cubic-bezier(.4,0,.2,1) .3s both;
        }

        /* ── CTA Button ── */
        .vd-cta-btn {
            display:inline-flex; align-items:center; gap:7px;
            padding:11px 20px; border-radius:var(--radius-sm);
            background:linear-gradient(135deg,#f9b40f,#fcd558);
            color:#380041; font-size:.78rem; font-weight:700; text-decoration:none;
            box-shadow:0 4px 20px rgba(249,180,15,0.35), inset 0 1px 0 rgba(255,255,255,0.2);
            border:1px solid rgba(249,180,15,0.5);
            transition:all .2s; white-space:nowrap;
        }
        .vd-cta-btn:hover { transform:translateY(-2px); box-shadow:0 8px 28px rgba(249,180,15,0.5); }
        .vd-cta-btn-full { width:100%; justify-content:center; }

        /* ── Countdown ── */
        .vd-countdown-box {
            display:flex; flex-direction:column; align-items:center;
            padding:10px 14px; border-radius:var(--radius-sm);
            background:rgba(56,0,65,0.7); border:1px solid rgba(249,180,15,0.15);
            flex:1;
        }
        .vd-countdown-num {
            font-family:'Playfair Display',serif; font-size:1.4rem; font-weight:900;
            background:linear-gradient(135deg,var(--gold),var(--gold-lt));
            -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
            line-height:1;
        }
        .vd-countdown-lbl { font-size:.58rem; color:rgba(249,180,15,0.5); font-weight:600; letter-spacing:.08em; text-transform:uppercase; margin-top:3px; }
        .vd-countdown-sep {
            display:flex; align-items:center; padding-bottom:18px;
            font-family:'Playfair Display',serif; font-size:1.2rem;
            color:rgba(249,180,15,0.3); font-weight:900;
        }

        /* ── Info Row ── */
        .vd-info-row {
            display:flex; align-items:center; justify-content:space-between;
            padding:9px 0; border-bottom:1px solid rgba(249,180,15,0.07);
        }
        .vd-info-row:last-child { border-bottom:none; }

        /* ══════════════════════════════════════
           WELCOME BANNER
        ══════════════════════════════════════ */
        .welcome-banner {
            background:linear-gradient(135deg,rgba(56,0,65,0.85),rgba(82,0,96,0.75));
            border:1px solid rgba(249,180,15,0.2);
            border-radius:var(--radius-lg);
            padding:20px;
            margin-bottom:16px;
            animation:vd-fadeUp .5s ease both;
            position:relative; overflow:hidden;
        }
        .welcome-banner::before {
            content:''; position:absolute; top:0; left:0; right:0; height:1px;
            background:linear-gradient(90deg,transparent,rgba(249,180,15,0.35),transparent);
        }
        .welcome-inner {
            display:flex; flex-direction:column; gap:14px;
        }
        .welcome-date {
            display:inline-flex; align-self:flex-start;
            padding:8px 16px; border-radius:var(--radius-sm);
            background:rgba(249,180,15,0.1); border:1px solid rgba(249,180,15,0.25);
        }

        /* ══════════════════════════════════════
           STAT CARDS GRID  (2×2 on mobile, 4×1 on desktop)
        ══════════════════════════════════════ */
        .vd-stat-grid {
            display:grid;
            grid-template-columns: repeat(2, 1fr);
            gap:12px;
            margin-bottom:16px;
        }
        @media (min-width:768px) {
            .vd-stat-grid { grid-template-columns: repeat(4, 1fr); gap:16px; }
        }

        /* ══════════════════════════════════════
           MAIN CONTENT GRID  (stack on mobile, 3-col on desktop)
        ══════════════════════════════════════ */
        .vd-main-grid {
            display:grid;
            grid-template-columns: 1fr;
            gap:14px;
            margin-bottom:16px;
        }
        @media (min-width:900px) {
            .vd-main-grid { grid-template-columns: 1fr 1fr; gap:20px; margin-bottom:20px; }
        }

        /* ══════════════════════════════════════
           STATUS BANNER — mobile layout
        ══════════════════════════════════════ */
        .status-inner {
            display:flex; flex-direction:column; gap:14px;
        }
        .status-top { display:flex; align-items:flex-start; gap:14px; }
        .status-body { flex:1; }
        @media (min-width:640px) {
            .status-inner { flex-direction:row; align-items:center; gap:18px; }
            .status-top { display:contents; }
        }

        /* ══════════════════════════════════════
           TURNOUT RING — horizontal on mobile
        ══════════════════════════════════════ */
        .turnout-inner {
            display:flex; flex-direction:row; gap:18px; align-items:center;
        }
        .turnout-ring { flex-shrink:0; }
        .turnout-legend { flex:1; }
        @media (min-width:900px) {
            .turnout-inner { flex-direction:column; align-items:center; }
            .turnout-legend { width:100%; }
        }

        /* ══════════════════════════════════════
           COUNTDOWN — horizontal time blocks on mobile
        ══════════════════════════════════════ */
        .countdown-boxes {
            display:flex; gap:6px; margin-bottom:14px;
        }

        /* ══════════════════════════════════════
           BIBLE QUOTE CARD
        ══════════════════════════════════════ */
        .bible-card {
            background: linear-gradient(135deg, rgba(26,0,32,0.9), rgba(56,0,65,0.8));
            border: 1px solid rgba(249,180,15,0.15);
            border-radius: var(--radius-lg);
            padding: 18px 20px;
            position: relative;
            overflow: hidden;
            animation: vd-fadeUp .5s ease .2s both;
        }
        .bible-card::before {
            content:'';
            position:absolute; top:0; left:0; right:0; height:1px;
            background:linear-gradient(90deg,transparent,rgba(249,180,15,0.3),transparent);
        }
        .bible-card::after {
            content: '\201C';
            position: absolute; top: -10px; right: 12px;
            font-family: 'Playfair Display', serif;
            font-size: 7rem; font-weight: 900;
            color: rgba(249,180,15,0.04);
            line-height: 1; pointer-events:none; user-select:none;
        }
        .bible-card-header {
            display:flex; align-items:center; justify-content:space-between;
            margin-bottom:14px;
        }
        .bible-card-label {
            display:flex; align-items:center; gap:7px;
            font-size:.78rem; font-weight:700; letter-spacing:.1em;
            text-transform:uppercase; color:rgba(249,180,15,0.5);
        }
        .bible-card-label i { font-size:.72rem; color:rgba(249,180,15,0.65); }
        .bible-refresh-btn {
            display:inline-flex; align-items:center; gap:4px;
            padding:4px 10px; border-radius:6px;
            border:1px solid rgba(249,180,15,0.18); background:transparent;
            font-size:.6rem; font-weight:700; color:rgba(249,180,15,0.45);
            cursor:pointer; transition:all .18s; font-family:'DM Sans',sans-serif;
        }
        .bible-refresh-btn:hover {
            border-color:rgba(249,180,15,0.4); color:#f9b40f;
            background:rgba(249,180,15,0.06);
        }
        .bible-refresh-btn.spinning i { animation:vd-spin .6s linear infinite; }
        .bible-quote-text {
            font-family:'Playfair Display',serif;
            font-size:1.15rem; font-style:italic; font-weight:700;
            color:rgba(255,251,240,0.75); line-height:1.75;
            margin-bottom:14px; position:relative; z-index:1;
        }
        .bible-quote-ref {
            display:inline-flex; align-items:center; gap:6px;
            padding:6px 16px; border-radius:99px;
            background:rgba(249,180,15,0.08); border:1px solid rgba(249,180,15,0.18);
            font-size:.85rem; font-weight:700; color:rgba(249,180,15,0.75);
            letter-spacing:.04em;
        }
        .bible-skeleton {
            height:12px; border-radius:6px;
            background:linear-gradient(90deg,rgba(249,180,15,0.05) 25%,rgba(249,180,15,0.1) 50%,rgba(249,180,15,0.05) 75%);
            background-size:200% 100%;
            animation:vd-shimmer 1.5s infinite;
            margin-bottom:6px;
        }

        /* ══════════════════════════════════════
           MISC SPACING
        ══════════════════════════════════════ */
        .mb-3  { margin-bottom:12px; }
        .mb-4  { margin-bottom:16px; }
        .mb-5  { margin-bottom:20px; }
        .p-4   { padding:16px; }
        .p-5   { padding:20px; }

        ::-webkit-scrollbar { width:4px; }
        ::-webkit-scrollbar-track { background:transparent; }
        ::-webkit-scrollbar-thumb { background:rgba(249,180,15,0.2); border-radius:99px; }
    </style>

    {{-- ═══════════════════════════════════════════
         WELCOME BANNER
    ═══════════════════════════════════════════ --}}
    <div class="welcome-banner">
        <div class="welcome-inner">
            <div>
                <h2 style="font-family:'Playfair Display',serif;font-size:1.35rem;font-weight:900;color:#fffbf0;margin:0 0 6px 0;line-height:1.25;">
                    Welcome, {{ $voter->full_name }}! 👋
                </h2>
                <p style="font-size:.8rem;color:rgba(255,251,240,0.6);margin:0;line-height:1.6;">
                    {{ $hasVoted
                        ? "Thank you for casting your vote! Your participation helps shape the future of our organization."
                        : "You're invited to participate in this important election. Your voice matters—cast your vote now!" }}
                </p>
            </div>
            <div class="welcome-date">
                <span style="font-family:'Playfair Display',serif;font-size:.88rem;font-weight:800;background:linear-gradient(135deg,#f9b40f,#fcd558);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                    {{ now()->format('l, F j, Y') }}
                </span>
            </div>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('error'))
    <div style="display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.25);margin-bottom:14px;animation:vd-fadeUp .4s ease both;">
        <i class="fas fa-circle-xmark" style="color:#f87171;font-size:.85rem;flex-shrink:0;"></i>
        <span style="font-size:.75rem;font-weight:600;color:#f87171;">{{ session('error') }}</span>
    </div>
    @endif
    @if(session('info'))
    <div style="display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);background:rgba(249,180,15,0.08);border:1px solid rgba(249,180,15,0.2);margin-bottom:14px;animation:vd-fadeUp .4s ease both;">
        <i class="fas fa-circle-info" style="color:#f9b40f;font-size:.85rem;flex-shrink:0;"></i>
        <span style="font-size:.75rem;font-weight:600;color:#f9b40f;">{{ session('info') }}</span>
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
                    <div style="font-family:'Playfair Display',serif;font-size:.95rem;font-weight:800;color:#fffbf0;margin-bottom:5px;line-height:1.25;">
                        {{ $hasVoted ? 'Your vote has been recorded!' : "You haven't voted yet" }}
                    </div>
                    <div style="font-size:.75rem;color:rgba(255,251,240,0.55);line-height:1.6;">
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
                        <div style="padding:10px 14px;border-radius:var(--radius-sm);background:rgba(52,211,153,0.08);border:1px solid rgba(52,211,153,0.2);text-align:center;">
                            <div style="font-size:.62rem;color:rgba(255,251,240,0.35);margin-bottom:3px;">Voted on</div>
                            <div style="font-family:'Playfair Display',serif;font-size:.78rem;color:#34d399;font-weight:700;">
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
                    <a href="{{ route('voter.vote.intro') }}" class="vd-cta-btn vd-cta-btn-full">
                        <i class="fas fa-vote-yea"></i> Cast My Vote Now
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
         MAIN GRID  (Profile | Turnout | Countdown)
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
                    <div style="font-size:.88rem;font-weight:700;color:#fffbf0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $voter->full_name }}</div>
                    <div style="font-size:.68rem;color:rgba(255,251,240,0.4);margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $voter->email }}</div>
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
                    <i class="fas {{ $info['icon'] }}" style="width:14px;text-align:center;font-size:.7rem;color:rgba(249,180,15,0.4);flex-shrink:0;"></i>
                    <span style="font-size:.7rem;color:rgba(255,251,240,0.4);">{{ $info['label'] }}</span>
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
</x-app-layout>