<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,800;0,900;1,700&family=Barlow+Condensed:wght@300;400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --g:     #f9b40f; --g-lt: #fcd558; --g-dk: #c98a00;
        --v:     #380041; --v-md: #520060; --v-lt: #6b0080; --v-xl: #1e0025;
        --ink:   #0e0013; --cream: #fffbf0; --glass: rgba(22,0,28,0.72);
        --b:     rgba(249,180,15,0.14); --b2: rgba(249,180,15,0.07);
        --muted: rgba(255,251,240,0.50); --dim: rgba(255,251,240,0.24);
        --green: #22c55e; --red: #ef4444;
    }
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    .wrap{font-family:'DM Sans',sans-serif;color:var(--cream);min-height:100vh;padding:0 0 60px;background:var(--ink);overflow-x:hidden;position:relative;}
    .wrap::before{content:'';position:fixed;inset:0;pointer-events:none;z-index:0;background:radial-gradient(ellipse 800px 600px at 0% 0%,rgba(56,0,65,.9) 0%,transparent 60%),radial-gradient(ellipse 600px 500px at 100% 100%,rgba(82,0,96,.7) 0%,transparent 55%);}
    .grid-bg{position:fixed;inset:0;z-index:0;pointer-events:none;background-image:linear-gradient(rgba(249,180,15,.03) 1px,transparent 1px),linear-gradient(90deg,rgba(249,180,15,.03) 1px,transparent 1px);background-size:52px 52px;}
    .orb{position:fixed;border-radius:50%;pointer-events:none;z-index:0;filter:blur(90px);}
    .orb1{width:600px;height:600px;top:-200px;left:-150px;background:radial-gradient(circle,rgba(56,0,65,.85),rgba(82,0,96,.5),transparent 70%);opacity:.6;}
    .orb2{width:450px;height:450px;bottom:-150px;right:-100px;background:radial-gradient(circle,rgba(249,180,15,.10),rgba(82,0,96,.35),transparent 70%);opacity:.55;}
    .z1{position:relative;z-index:1;}
    @keyframes fadeUp{from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:translateY(0)}}
    .fu{opacity:0;animation:fadeUp .7s cubic-bezier(.22,1,.36,1) forwards}
    .d0{animation-delay:.04s}.d1{animation-delay:.10s}.d2{animation-delay:.17s}.d3{animation-delay:.24s}.d4{animation-delay:.31s}.d5{animation-delay:.38s}
    .gs{background:var(--glass);backdrop-filter:blur(24px) saturate(1.4);-webkit-backdrop-filter:blur(24px) saturate(1.4);border:1px solid var(--b);border-radius:20px;position:relative;overflow:hidden;}
    .gs::before{content:'';position:absolute;top:0;left:0;right:0;height:1px;pointer-events:none;background:linear-gradient(90deg,transparent 0%,rgba(249,180,15,.6) 40%,rgba(249,180,15,.3) 60%,transparent 100%);}

    .page-header{padding:36px 40px 28px;display:flex;align-items:flex-end;justify-content:space-between;gap:24px;border-bottom:1px solid var(--b2);}
    .eyebrow{display:inline-flex;align-items:center;gap:10px;font-family:'Barlow Condensed',sans-serif;font-size:.65rem;font-weight:700;letter-spacing:.15em;text-transform:uppercase;color:var(--g);margin-bottom:14px;}
    .eyebrow-line{width:32px;height:1px;background:linear-gradient(90deg,var(--g),transparent);}
    .eyebrow-dot{width:5px;height:5px;border-radius:50%;background:var(--g);flex-shrink:0;}
    .page-h1{font-family:'Playfair Display',serif;font-size:clamp(2rem,3.5vw,3rem);font-weight:900;line-height:.95;letter-spacing:-.03em;color:var(--cream);}
    .page-h1 em{font-style:italic;background:linear-gradient(110deg,var(--g) 0%,var(--g-lt) 50%,#fff6c8 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
    .header-sub{font-size:.8rem;color:var(--muted);font-weight:300;margin-top:10px;line-height:1.6;}
    .content{padding:28px 40px 0;}
    .back-btn{display:inline-flex;align-items:center;gap:8px;padding:10px 22px;border-radius:10px;background:rgba(249,180,15,.08);border:1px solid var(--b);color:var(--g);font-family:'Barlow Condensed',sans-serif;font-size:.72rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;text-decoration:none;transition:all .2s;}
    .back-btn:hover{background:rgba(249,180,15,.15);color:var(--g);}

    /* Stats strip */
    .stats-strip{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:28px;}
    .stat-box{padding:20px;text-align:center;background:rgba(249,180,15,.04);border:1px solid var(--b);border-radius:14px;}
    .stat-num{font-family:'Playfair Display',serif;font-size:2rem;font-weight:900;line-height:1;background:linear-gradient(135deg,var(--g),var(--g-lt));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;margin-bottom:4px;}
    .stat-lbl{font-family:'Barlow Condensed',sans-serif;font-size:.6rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--dim);}

    /* Position block */
    .position-block{margin-bottom:24px;}
    .position-header{
        display:flex;align-items:center;gap:16px;padding:16px 24px;
        background:linear-gradient(135deg,rgba(56,0,65,.7),rgba(82,0,96,.4));
        border:1px solid rgba(249,180,15,.2);border-radius:14px 14px 0 0;
    }
    .pos-icon{width:38px;height:38px;border-radius:10px;background:rgba(249,180,15,.12);border:1px solid rgba(249,180,15,.25);display:flex;align-items:center;justify-content:center;font-size:.9rem;color:var(--g);}
    .pos-name{font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:800;color:var(--cream);}
    .pos-count{margin-left:auto;font-family:'Barlow Condensed',sans-serif;font-size:.65rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);}

    /* Candidate rows */
    .candidates-table{border:1px solid var(--b);border-top:none;border-radius:0 0 14px 14px;overflow:hidden;}
    .cand-row{
        display:grid;grid-template-columns:32px 1fr 120px 120px 80px 90px;
        align-items:center;gap:12px;padding:14px 20px;
        border-bottom:1px solid var(--b2);
        transition:background .2s;
    }
    .cand-row:last-child{border-bottom:none;}
    .cand-row:hover{background:rgba(249,180,15,.04);}
    .cand-row.winner{background:rgba(249,180,15,.06);}
    .cand-row.winner .cand-name{color:var(--g);}

    .th{font-family:'Barlow Condensed',sans-serif;font-size:.58rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--dim);padding:10px 20px;background:rgba(0,0,0,.3);display:grid;grid-template-columns:32px 1fr 120px 120px 80px 90px;gap:12px;border-top:1px solid var(--b2);}

    .rank-badge{width:28px;height:28px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-family:'Barlow Condensed',sans-serif;font-size:.7rem;font-weight:800;}
    .rank-1{background:linear-gradient(135deg,#f9b40f,#fcd558);color:var(--v);}
    .rank-2{background:rgba(200,200,220,.15);color:#c8c8d8;border:1px solid rgba(200,200,220,.2);}
    .rank-3{background:rgba(180,120,60,.15);color:#c8905a;border:1px solid rgba(180,120,60,.2);}
    .rank-n{background:rgba(255,251,240,.06);color:var(--dim);border:1px solid var(--b2);}

    .cand-name{font-size:.88rem;font-weight:500;color:var(--cream);}
    .cand-badge{display:inline-flex;align-items:center;padding:2px 8px;border-radius:999px;font-family:'Barlow Condensed',sans-serif;font-size:.58rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;}
    .badge-college{color:rgba(100,200,255,.7);background:rgba(100,200,255,.08);border:1px solid rgba(100,200,255,.18);}
    .badge-party{color:rgba(249,180,15,.7);background:rgba(249,180,15,.08);border:1px solid rgba(249,180,15,.18);}
    .vote-count{font-family:'Barlow Condensed',sans-serif;font-size:1rem;font-weight:700;color:var(--cream);text-align:right;}
    .vote-pct{font-family:'Barlow Condensed',sans-serif;font-size:.85rem;color:var(--muted);text-align:right;}
    .bar-wrap{width:100%;height:4px;background:rgba(255,251,240,.08);border-radius:2px;overflow:hidden;}
    .bar-fill{height:100%;border-radius:2px;background:linear-gradient(90deg,var(--g),var(--g-lt));transition:width .6s ease;}

    /* Crown icon for winner */
    .crown{color:var(--g);font-size:.7rem;margin-left:6px;}

    .section-title{font-family:'Playfair Display',serif;font-size:1rem;font-weight:800;color:var(--cream);margin-bottom:14px;display:flex;align-items:center;gap:12px;}
    .section-title::after{content:'';flex:1;height:1px;background:linear-gradient(90deg,rgba(249,180,15,.2),transparent);}

    .no-data{padding:32px;text-align:center;color:var(--muted);font-size:.82rem;}
</style>

<div class="orb orb1"></div>
<div class="orb orb2"></div>
<div class="grid-bg"></div>

<div class="wrap">
    <div class="page-header z1 fu d0">
        <div>
            <div class="eyebrow"><span class="eyebrow-line"></span><span class="eyebrow-dot"></span>Reports</div>
            <h1 class="page-h1">Election <em>Results</em></h1>
            <p class="header-sub">All positions · ranked by votes · generated {{ now('Asia/Manila')->format('F j, Y H:i:s T') }}</p>
        </div>
        <a href="{{ route('admin.reports.index') }}" class="back-btn"><i class="fas fa-arrow-left"></i> Reports</a>
    </div>

    <div class="content z1">

        {{-- Stats --}}
        <div class="stats-strip fu d1">
            <div class="stat-box">
                <div class="stat-num">{{ number_format($totalVoters) }}</div>
                <div class="stat-lbl">Registered Voters</div>
            </div>
            <div class="stat-box">
                <div class="stat-num">{{ number_format($totalVoted) }}</div>
                <div class="stat-lbl">Votes Cast</div>
            </div>
            <div class="stat-box">
                <div class="stat-num">{{ $totalVoters > 0 ? round(($totalVoted/$totalVoters)*100,1) : 0 }}%</div>
                <div class="stat-lbl">Voter Turnout</div>
            </div>
        </div>

        {{-- SSC Positions --}}
        <div class="section-title fu d2">Supreme Student Council (SSC)</div>

        @foreach($sscPositions as $i => $position)
        <div class="position-block gs fu d{{ min($i+3,7) }}">
            <div class="position-header">
                <div class="pos-icon"><i class="fas fa-star"></i></div>
                <div class="pos-name">{{ $position->name }}</div>
                <div class="pos-count">{{ $position->candidates->count() }} candidate{{ $position->candidates->count() !== 1 ? 's' : '' }}</div>
            </div>
            @if($position->candidates->isEmpty())
                <div class="no-data">No candidates for this position.</div>
            @else
                <div class="th">
                    <span>#</span><span>Candidate</span><span>College</span><span>Party</span><span style="text-align:right">Votes</span><span style="text-align:right">%</span>
                </div>
                <div class="candidates-table">
                    @foreach($position->candidates as $idx => $candidate)
                        @php
                            $pct = $totalVoted > 0 ? round(($candidate->vote_count / $totalVoted) * 100, 2) : 0;
                            $maxVotes = $position->candidates->max('vote_count') ?: 1;
                            $barWidth = $maxVotes > 0 ? round(($candidate->vote_count / $maxVotes) * 100) : 0;
                        @endphp
                        <div class="cand-row {{ $idx === 0 ? 'winner' : '' }}">
                            <div class="rank-badge {{ $idx === 0 ? 'rank-1' : ($idx === 1 ? 'rank-2' : ($idx === 2 ? 'rank-3' : 'rank-n')) }}">{{ $idx + 1 }}</div>
                            <div>
                                <div class="cand-name">
                                    {{ $candidate->first_name }} {{ $candidate->last_name }}
                                    @if($idx === 0)<i class="fas fa-crown crown"></i>@endif
                                </div>
                                <div class="bar-wrap" style="margin-top:5px;"><div class="bar-fill" style="width:{{ $barWidth }}%"></div></div>
                            </div>
                            <div><span class="cand-badge badge-college">{{ $candidate->college->acronym ?? '—' }}</span></div>
                            <div><span class="cand-badge badge-party">{{ $candidate->partylist->acronym ?? '—' }}</span></div>
                            <div class="vote-count">{{ number_format($candidate->vote_count) }}</div>
                            <div class="vote-pct">{{ $pct }}%</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        @endforeach

        {{-- College Results --}}
        @foreach($collegeResults as $college)
        <div style="margin-top:32px;">
            <div class="section-title fu d2">{{ $college['name'] }}</div>
            @if(count($college['positions']) === 0)
                <div class="gs" style="padding:20px;"><div class="no-data">No candidates found for this college.</div></div>
            @else
                @foreach($college['positions'] as $i => $position)
                <div class="position-block gs fu d{{ min($i+2,7) }}" style="margin-bottom:16px;">
                    <div class="position-header">
                        <div class="pos-icon"><i class="fas fa-user-tie"></i></div>
                        <div class="pos-name">{{ $position->name }}</div>
                        <div class="pos-count">{{ $position->candidates->count() }} candidate{{ $position->candidates->count() !== 1 ? 's' : '' }}</div>
                    </div>
                    @if($position->candidates->isEmpty())
                        <div class="no-data">No candidates.</div>
                    @else
                        <div class="th">
                            <span>#</span><span>Candidate</span><span>College</span><span>Party</span><span style="text-align:right">Votes</span><span style="text-align:right">%</span>
                        </div>
                        <div class="candidates-table">
                            @foreach($position->candidates as $idx => $candidate)
                                @php
                                    $pct = $college['totalVoted'] > 0 ? round(($candidate->vote_count / $college['totalVoted']) * 100, 2) : 0;
                                    $maxVotes = $position->candidates->max('vote_count') ?: 1;
                                    $barWidth = $maxVotes > 0 ? round(($candidate->vote_count / $maxVotes) * 100) : 0;
                                @endphp
                                <div class="cand-row {{ $idx === 0 ? 'winner' : '' }}">
                                    <div class="rank-badge {{ $idx === 0 ? 'rank-1' : ($idx === 1 ? 'rank-2' : ($idx === 2 ? 'rank-3' : 'rank-n')) }}">{{ $idx + 1 }}</div>
                                    <div>
                                        <div class="cand-name">
                                            {{ $candidate->first_name }} {{ $candidate->last_name }}
                                            @if($idx === 0)<i class="fas fa-crown crown"></i>@endif
                                        </div>
                                        <div class="bar-wrap" style="margin-top:5px;"><div class="bar-fill" style="width:{{ $barWidth }}%"></div></div>
                                    </div>
                                    <div><span class="cand-badge badge-college">{{ $candidate->college->acronym ?? '—' }}</span></div>
                                    <div><span class="cand-badge badge-party">{{ $candidate->partylist->acronym ?? '—' }}</span></div>
                                    <div class="vote-count">{{ number_format($candidate->vote_count) }}</div>
                                    <div class="vote-pct">{{ $pct }}%</div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                @endforeach
            @endif
        </div>
        @endforeach

    </div>
</div>
</x-app-layout>