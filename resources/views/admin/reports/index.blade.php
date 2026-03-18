<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,800;0,900;1,700&family=Barlow+Condensed:wght@300;400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --g:      #f9b40f;
        --g-lt:   #fcd558;
        --g-dk:   #c98a00;
        --v:      #380041;
        --v-md:   #520060;
        --v-lt:   #6b0080;
        --v-xl:   #1e0025;
        --ink:    #0e0013;
        --cream:  #fffbf0;
        --glass:  rgba(22,0,28,0.72);
        --b:      rgba(249,180,15,0.14);
        --b2:     rgba(249,180,15,0.07);
        --muted:  rgba(255,251,240,0.50);
        --dim:    rgba(255,251,240,0.24);
        --green:  #22c55e;
    }
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}

    .wrap{
        font-family:'DM Sans',sans-serif;
        color:var(--cream);
        min-height:100vh;
        padding:0 0 60px;
        background:var(--ink);
        overflow-x:hidden;
        position:relative;
    }
    .wrap::before{
        content:'';position:fixed;inset:0;pointer-events:none;z-index:0;
        background:
            radial-gradient(ellipse 800px 600px at 0% 0%, rgba(56,0,65,.9) 0%, transparent 60%),
            radial-gradient(ellipse 600px 500px at 100% 100%, rgba(82,0,96,.7) 0%, transparent 55%),
            radial-gradient(ellipse 400px 300px at 55% 30%, rgba(249,180,15,.04) 0%, transparent 60%);
    }
    .grid-bg{
        position:fixed;inset:0;z-index:0;pointer-events:none;
        background-image:
            linear-gradient(rgba(249,180,15,.03) 1px,transparent 1px),
            linear-gradient(90deg,rgba(249,180,15,.03) 1px,transparent 1px);
        background-size:52px 52px;
    }
    .orb{position:fixed;border-radius:50%;pointer-events:none;z-index:0;filter:blur(90px);}
    .orb1{width:600px;height:600px;top:-200px;left:-150px;background:radial-gradient(circle,rgba(56,0,65,.85),rgba(82,0,96,.5),transparent 70%);opacity:.6;}
    .orb2{width:450px;height:450px;bottom:-150px;right:-100px;background:radial-gradient(circle,rgba(249,180,15,.10),rgba(82,0,96,.35),transparent 70%);opacity:.55;}

    .z1{position:relative;z-index:1;}

    @keyframes fadeUp{from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:translateY(0)}}
    .fu{opacity:0;animation:fadeUp .7s cubic-bezier(.22,1,.36,1) forwards}
    .d0{animation-delay:.04s}.d1{animation-delay:.10s}.d2{animation-delay:.17s}
    .d3{animation-delay:.24s}.d4{animation-delay:.31s}.d5{animation-delay:.38s}
    .d6{animation-delay:.45s}.d7{animation-delay:.52s}

    /* Glass surface */
    .gs{
        background:var(--glass);
        backdrop-filter:blur(24px) saturate(1.4);
        -webkit-backdrop-filter:blur(24px) saturate(1.4);
        border:1px solid var(--b);
        border-radius:20px;
        position:relative;overflow:hidden;
    }
    .gs::before{
        content:'';position:absolute;top:0;left:0;right:0;height:1px;pointer-events:none;
        background:linear-gradient(90deg,transparent 0%,rgba(249,180,15,.6) 40%,rgba(249,180,15,.3) 60%,transparent 100%);
    }
    .gs:hover{border-color:rgba(249,180,15,.30);box-shadow:0 20px 60px rgba(0,0,0,.5),0 0 0 1px rgba(249,180,15,.08) inset;}

    /* Page header */
    .page-header{
        padding:36px 40px 28px;
        display:flex;align-items:flex-end;justify-content:space-between;gap:24px;
        border-bottom:1px solid var(--b2);
    }
    .eyebrow{
        display:inline-flex;align-items:center;gap:10px;
        font-family:'Barlow Condensed',sans-serif;
        font-size:.65rem;font-weight:700;letter-spacing:.15em;text-transform:uppercase;
        color:var(--g);margin-bottom:14px;
    }
    .eyebrow-line{width:32px;height:1px;background:linear-gradient(90deg,var(--g),transparent);}
    .eyebrow-dot{width:5px;height:5px;border-radius:50%;background:var(--g);flex-shrink:0;}
    .page-h1{
        font-family:'Playfair Display',serif;
        font-size:clamp(2rem,3.5vw,3rem);font-weight:900;
        line-height:.95;letter-spacing:-.03em;color:var(--cream);
    }
    .page-h1 em{
        font-style:italic;
        background:linear-gradient(110deg,var(--g) 0%,var(--g-lt) 50%,#fff6c8 100%);
        -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
    }
    .header-sub{font-size:.8rem;color:var(--muted);font-weight:300;margin-top:10px;line-height:1.6;}

    /* Content */
    .content{padding:28px 40px 0;}

    /* Grid of report cards */
    .reports-grid{
        display:grid;
        grid-template-columns:repeat(auto-fill,minmax(300px,1fr));
        gap:16px;
        margin-bottom:32px;
    }

    /* Individual report card */
    .report-card{
        padding:28px 26px 24px;
        cursor:pointer;
        transition:transform .22s cubic-bezier(.4,0,.2,1),box-shadow .22s,border-color .22s;
        text-decoration:none;
        display:block;
        color:inherit;
    }
    .report-card:hover{
        transform:translateY(-5px);
        box-shadow:0 28px 70px rgba(0,0,0,.55),0 0 0 1px rgba(249,180,15,.25) inset;
        border-color:rgba(249,180,15,.35);
        text-decoration:none;
        color:inherit;
    }

    .card-icon-wrap{
        width:52px;height:52px;border-radius:14px;
        display:flex;align-items:center;justify-content:center;
        background:rgba(249,180,15,.08);
        border:1px solid rgba(249,180,15,.2);
        margin-bottom:18px;
        font-size:1.2rem;color:var(--g);
        transition:all .22s;
    }
    .report-card:hover .card-icon-wrap{
        background:linear-gradient(135deg,var(--g),var(--g-lt));
        color:var(--v);border-color:var(--g);
        box-shadow:0 6px 24px rgba(249,180,15,.4);
    }
    .card-title{
        font-family:'Playfair Display',serif;
        font-size:1.15rem;font-weight:800;color:var(--cream);
        margin-bottom:8px;
    }
    .card-desc{
        font-size:.78rem;color:var(--muted);line-height:1.65;
        font-weight:300;
        margin-bottom:20px;
    }
    .card-meta{
        display:flex;align-items:center;gap:12px;
        flex-wrap:wrap;
    }
    .meta-badge{
        font-family:'Barlow Condensed',sans-serif;
        font-size:.6rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;
        padding:3px 10px;border-radius:999px;
        color:rgba(249,180,15,.7);background:rgba(249,180,15,.09);border:1px solid rgba(249,180,15,.18);
    }
    .meta-badge.landscape{
        color:rgba(100,200,255,.7);background:rgba(100,200,255,.08);border-color:rgba(100,200,255,.2);
    }
    .card-cta{
        display:inline-flex;align-items:center;gap:7px;
        font-family:'Barlow Condensed',sans-serif;
        font-size:.68rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;
        color:var(--g);
        transition:gap .2s;
        margin-left:auto;
    }
    .report-card:hover .card-cta{gap:12px;}

    /* Section title */
    .section-title{
        font-family:'Playfair Display',serif;
        font-size:1rem;font-weight:800;color:var(--cream);
        margin-bottom:14px;display:flex;align-items:center;gap:12px;
    }
    .section-title::after{
        content:'';flex:1;height:1px;
        background:linear-gradient(90deg,rgba(249,180,15,.2),transparent);
    }

    /* Info box */
    .info-box{
        padding:16px 20px;
        background:rgba(249,180,15,.04);
        border:1px solid rgba(249,180,15,.15);
        border-left:3px solid var(--g);
        border-radius:10px;
        margin-bottom:24px;
    }
    .info-box p{font-size:.78rem;color:var(--muted);line-height:1.7;}
    .info-box strong{color:var(--g);}

    /* Quick stats strip */
    .quick-stats{
        display:grid;
        grid-template-columns:repeat(4,1fr);
        gap:10px;
        margin-bottom:28px;
    }
    .qs-item{
        padding:16px;text-align:center;
        background:rgba(249,180,15,.04);
        border:1px solid var(--b);border-radius:14px;
    }
    .qs-num{
        font-family:'Playfair Display',serif;
        font-size:1.6rem;font-weight:900;line-height:1;
        background:linear-gradient(135deg,var(--g),var(--g-lt));
        -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
        margin-bottom:4px;
    }
    .qs-lbl{
        font-family:'Barlow Condensed',sans-serif;
        font-size:.6rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;
        color:var(--dim);
    }
</style>

<div class="orb orb1"></div>
<div class="orb orb2"></div>
<div class="grid-bg"></div>

<div class="wrap">

    {{-- Page Header --}}
    <div class="page-header z1 fu d0">
        <div>
            <div class="eyebrow">
                <span class="eyebrow-line"></span>
                <span class="eyebrow-dot"></span>
                Election Management System
            </div>
            <h1 class="page-h1">PDF <em>Reports</em></h1>
            <p class="header-sub">Generate and download official election reports in PDF format.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}"
           style="display:inline-flex;align-items:center;gap:8px;padding:10px 22px;border-radius:10px;background:rgba(249,180,15,.08);border:1px solid var(--b);color:var(--g);font-family:'Barlow Condensed',sans-serif;font-size:.72rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;text-decoration:none;transition:all .2s;">
            <i class="fas fa-arrow-left"></i> Dashboard
        </a>
    </div>

    <div class="content z1">

        {{-- Quick Stats --}}
        @php
            $totalVoters   = \App\Models\User::where('role','voter')->count();
            $totalVoted    = \App\Models\CastedVote::distinct('voter_id')->count('voter_id');
            $totalCands    = \App\Models\Candidate::count();
            $turnoutPct    = $totalVoters > 0 ? round(($totalVoted/$totalVoters)*100,1) : 0;
        @endphp

        <div class="quick-stats fu d1">
            <div class="qs-item">
                <div class="qs-num">{{ number_format($totalVoters) }}</div>
                <div class="qs-lbl">Registered Voters</div>
            </div>
            <div class="qs-item">
                <div class="qs-num">{{ number_format($totalVoted) }}</div>
                <div class="qs-lbl">Votes Cast</div>
            </div>
            <div class="qs-item">
                <div class="qs-num">{{ number_format($totalCands) }}</div>
                <div class="qs-lbl">Candidates</div>
            </div>
            <div class="qs-item">
                <div class="qs-num">{{ $turnoutPct }}%</div>
                <div class="qs-lbl">Voter Turnout</div>
            </div>
        </div>

        <div class="info-box fu d2">
            <p>
                All reports are generated in real-time from live election data.
                <strong>SSC Results</strong>, <strong>All Election Results</strong>, <strong>Voter Turnout</strong>, and <strong>Voter Feedback</strong> use portrait layout (A4).
                <strong>Ballot Log</strong> and <strong>Candidate Summary</strong> use landscape layout for wider tables.
                Data is accurate as of the moment of download.
            </p>
        </div>

        <div class="section-title fu d2">Available Reports</div>

        <div class="reports-grid fu d3">

            {{-- 1. SSC Election Results --}}
            <a href="{{ route('admin.reports.results') }}" class="gs report-card" target="_blank">
                <div class="card-icon-wrap"><i class="fas fa-trophy"></i></div>
                <div class="card-title">SSC Election Results</div>
                <div class="card-desc">
                    Supreme Student Council results for all SSC positions — ranked candidates with vote counts, percentages, and overall turnout summary.
                </div>
                <div class="card-meta">
                    <span class="meta-badge">Portrait · A4</span>
                    <span class="meta-badge">SSC Only</span>
                    <span class="card-cta">Download <i class="fas fa-arrow-right" style="font-size:.6rem;"></i></span>
                </div>
            </a>

            {{-- 2. All Election Results --}}
            <a href="{{ route('admin.reports.by-college') }}" class="gs report-card" target="_blank">
                <div class="card-icon-wrap"><i class="fas fa-building-columns"></i></div>
                <div class="card-title">All Election Results</div>
                <div class="card-desc">
                    Complete report covering SSC positions followed by every college's SBO results — candidates, vote counts, percentages, and per-college voter turnout.
                </div>
                <div class="card-meta">
                    <span class="meta-badge">Portrait · A4</span>
                    <span class="meta-badge">SSC + All Colleges</span>
                    <span class="card-cta">Download <i class="fas fa-arrow-right" style="font-size:.6rem;"></i></span>
                </div>
            </a>

            {{-- 3. Voter Turnout --}}
            <a href="{{ route('admin.reports.turnout') }}" class="gs report-card" target="_blank">
                <div class="card-icon-wrap"><i class="fas fa-chart-pie"></i></div>
                <div class="card-title">Voter Turnout</div>
                <div class="card-desc">
                    Turnout analysis by college with participation rates, plus a full list of voters who have not yet submitted their ballot.
                </div>
                <div class="card-meta">
                    <span class="meta-badge">Portrait · A4</span>
                    <span class="meta-badge">Participation</span>
                    <span class="card-cta">Download <i class="fas fa-arrow-right" style="font-size:.6rem;"></i></span>
                </div>
            </a>

            {{-- 4. Ballot Log --}}
            <a href="{{ route('admin.reports.ballots') }}" class="gs report-card" target="_blank">
                <div class="card-icon-wrap"><i class="fas fa-scroll"></i></div>
                <div class="card-title">Ballot Transaction Log</div>
                <div class="card-desc">
                    Full audit log of every submitted ballot — transaction number, voter name, student number, college, and timestamp.
                </div>
                <div class="card-meta">
                    <span class="meta-badge landscape">Landscape · A4</span>
                    <span class="meta-badge">Audit Trail</span>
                    <span class="card-cta">Download <i class="fas fa-arrow-right" style="font-size:.6rem;"></i></span>
                </div>
            </a>

            {{-- 5. Candidate Summary --}}
            <a href="{{ route('admin.reports.candidates') }}" class="gs report-card" target="_blank">
                <div class="card-icon-wrap"><i class="fas fa-user-tie"></i></div>
                <div class="card-title">Candidate Summary</div>
                <div class="card-desc">
                    All candidates listed with their position, party list, college, organization, course, and total votes — sorted by position then votes.
                </div>
                <div class="card-meta">
                    <span class="meta-badge landscape">Landscape · A4</span>
                    <span class="meta-badge">All Candidates</span>
                    <span class="card-cta">Download <i class="fas fa-arrow-right" style="font-size:.6rem;"></i></span>
                </div>
            </a>

            {{-- 6. Voter Feedback --}}
            <a href="{{ route('admin.reports.feedback') }}" class="gs report-card" target="_blank">
                <div class="card-icon-wrap"><i class="fas fa-comments"></i></div>
                <div class="card-title">Voter Feedback</div>
                <div class="card-desc">
                    All voter feedback submissions with ratings, a visual rating breakdown chart, average score, and individual responses per voter.
                </div>
                <div class="card-meta">
                    <span class="meta-badge">Portrait · A4</span>
                    <span class="meta-badge">Ratings & Comments</span>
                    <span class="card-cta">Download <i class="fas fa-arrow-right" style="font-size:.6rem;"></i></span>
                </div>
            </a>

        </div>

    </div>
</div>
</x-app-layout>