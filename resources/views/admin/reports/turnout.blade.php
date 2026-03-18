<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,800;0,900;1,700&family=Barlow+Condensed:wght@300;400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --g:#f9b40f;--g-lt:#fcd558;--g-dk:#c98a00;
        --v:#380041;--v-md:#520060;--v-lt:#6b0080;--v-xl:#1e0025;
        --ink:#0e0013;--cream:#fffbf0;--glass:rgba(22,0,28,0.72);
        --b:rgba(249,180,15,0.14);--b2:rgba(249,180,15,0.07);
        --muted:rgba(255,251,240,0.50);--dim:rgba(255,251,240,0.24);
        --green:#22c55e;--red:#ef4444;
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

    /* Hero turnout */
    .hero-turnout{
        display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;
        margin-bottom:28px;
    }
    .hero-card{padding:28px;text-align:center;}
    .hero-num{font-family:'Playfair Display',serif;font-size:2.5rem;font-weight:900;line-height:1;margin-bottom:6px;}
    .hero-num.gold{background:linear-gradient(135deg,var(--g),var(--g-lt));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
    .hero-num.green{color:var(--green);}
    .hero-num.red{color:var(--red);}
    .hero-lbl{font-family:'Barlow Condensed',sans-serif;font-size:.62rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--dim);}

    /* Big overall bar */
    .overall-bar-section{padding:24px 32px;margin-bottom:28px;}
    .ob-label{display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;}
    .ob-title{font-family:'Barlow Condensed',sans-serif;font-size:.75rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted);}
    .ob-pct{font-family:'Playfair Display',serif;font-size:1.8rem;font-weight:900;color:var(--g);}
    .ob-track{height:12px;background:rgba(255,251,240,.08);border-radius:6px;overflow:hidden;position:relative;}
    .ob-voted{height:100%;background:linear-gradient(90deg,var(--g),var(--g-lt));border-radius:6px;transition:width .8s ease;}
    .ob-not{position:absolute;top:0;right:0;height:100%;background:rgba(239,68,68,.2);border-radius:0 6px 6px 0;}
    .ob-legend{display:flex;gap:20px;margin-top:10px;}
    .legend-item{display:flex;align-items:center;gap:7px;font-family:'Barlow Condensed',sans-serif;font-size:.62rem;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:var(--muted);}
    .legend-dot{width:8px;height:8px;border-radius:50%;}

    /* Section title */
    .section-title{font-family:'Playfair Display',serif;font-size:1rem;font-weight:800;color:var(--cream);margin-bottom:14px;display:flex;align-items:center;gap:12px;}
    .section-title::after{content:'';flex:1;height:1px;background:linear-gradient(90deg,rgba(249,180,15,.2),transparent);}

    /* College turnout table */
    .turnout-table{border-radius:14px;overflow:hidden;}
    .tt-header{display:grid;grid-template-columns:1fr 100px 100px 100px 200px;gap:12px;padding:10px 20px;background:rgba(0,0,0,.3);border-bottom:1px solid var(--b2);}
    .tt-th{font-family:'Barlow Condensed',sans-serif;font-size:.58rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--dim);}
    .tt-th.right{text-align:right;}
    .tt-row{display:grid;grid-template-columns:1fr 100px 100px 100px 200px;gap:12px;align-items:center;padding:14px 20px;border-bottom:1px solid var(--b2);transition:background .2s;}
    .tt-row:last-child{border-bottom:none;}
    .tt-row:hover{background:rgba(249,180,15,.04);}
    .tt-college-name{font-size:.88rem;font-weight:500;color:var(--cream);}
    .tt-num{font-family:'Barlow Condensed',sans-serif;font-size:.9rem;font-weight:700;color:var(--cream);text-align:right;}
    .tt-pct{font-family:'Barlow Condensed',sans-serif;font-size:.9rem;font-weight:700;text-align:right;}
    .pct-high{color:var(--green);}
    .pct-mid{color:var(--g);}
    .pct-low{color:var(--red);}
    .bar-cell{display:flex;align-items:center;gap:8px;}
    .bar-track{flex:1;height:6px;background:rgba(255,251,240,.08);border-radius:3px;overflow:hidden;}
    .bar-fill{height:100%;background:linear-gradient(90deg,var(--g),var(--g-lt));border-radius:3px;}
    .bar-pct-label{font-family:'Barlow Condensed',sans-serif;font-size:.62rem;font-weight:700;color:var(--muted);min-width:36px;text-align:right;}
</style>

<div class="orb orb1"></div>
<div class="orb orb2"></div>
<div class="grid-bg"></div>

<div class="wrap">
    <div class="page-header z1 fu d0">
        <div>
            <div class="eyebrow"><span class="eyebrow-line"></span><span class="eyebrow-dot"></span>Reports</div>
            <h1 class="page-h1">Voter <em>Turnout</em></h1>
            <p class="header-sub">Participation analysis by college · generated {{ now('Asia/Manila')->format('F j, Y H:i:s T') }}</p>
        </div>
        <a href="{{ route('admin.reports.index') }}" class="back-btn"><i class="fas fa-arrow-left"></i> Reports</a>
    </div>

    <div class="content z1">

        @php
            $notVoted = $totalVoters - $totalVoted;
            $overallPct = $totalVoters > 0 ? round(($totalVoted / $totalVoters) * 100, 1) : 0;
        @endphp

        {{-- Hero cards --}}
        <div class="hero-turnout fu d1">
            <div class="gs hero-card">
                <div class="hero-num gold">{{ number_format($totalVoters) }}</div>
                <div class="hero-lbl">Registered Voters</div>
            </div>
            <div class="gs hero-card">
                <div class="hero-num green">{{ number_format($totalVoted) }}</div>
                <div class="hero-lbl">Votes Cast</div>
            </div>
            <div class="gs hero-card">
                <div class="hero-num red">{{ number_format($notVoted) }}</div>
                <div class="hero-lbl">Did Not Vote</div>
            </div>
        </div>

        {{-- Overall turnout bar --}}
        <div class="gs overall-bar-section fu d2">
            <div class="ob-label">
                <span class="ob-title">Overall Voter Turnout</span>
                <span class="ob-pct">{{ $overallPct }}%</span>
            </div>
            <div class="ob-track">
                <div class="ob-voted" style="width:{{ $overallPct }}%"></div>
            </div>
            <div class="ob-legend">
                <div class="legend-item"><div class="legend-dot" style="background:var(--g);"></div>Voted ({{ number_format($totalVoted) }})</div>
                <div class="legend-item"><div class="legend-dot" style="background:rgba(239,68,68,.5);"></div>Not Voted ({{ number_format($notVoted) }})</div>
            </div>
        </div>

        {{-- Per-college breakdown --}}
        <div class="section-title fu d3">Turnout by College</div>

        <div class="gs turnout-table fu d4">
            <div class="tt-header">
                <span class="tt-th">College</span>
                <span class="tt-th right">Registered</span>
                <span class="tt-th right">Voted</span>
                <span class="tt-th right">Not Voted</span>
                <span class="tt-th">Participation</span>
            </div>
            @foreach($collegeStats as $cs)
                @php
                    $cPct = $cs['percentage'];
                    $pctClass = $cPct >= 70 ? 'pct-high' : ($cPct >= 40 ? 'pct-mid' : 'pct-low');
                @endphp
                <div class="tt-row">
                    <div class="tt-college-name">{{ $cs['name'] }}</div>
                    <div class="tt-num">{{ number_format($cs['totalVoters']) }}</div>
                    <div class="tt-num" style="color:var(--green);">{{ number_format($cs['votedCount']) }}</div>
                    <div class="tt-num" style="color:var(--red);">{{ number_format($cs['notVoted']) }}</div>
                    <div class="bar-cell">
                        <div class="bar-track"><div class="bar-fill" style="width:{{ $cPct }}%"></div></div>
                        <span class="bar-pct-label {{ $pctClass }}">{{ $cPct }}%</span>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>
</x-app-layout>