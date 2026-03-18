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
        --green:#22c55e;
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
    .d0{animation-delay:.04s}.d1{animation-delay:.10s}.d2{animation-delay:.17s}.d3{animation-delay:.24s}
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

    /* Count badge */
    .count-badge{display:inline-flex;align-items:center;gap:8px;padding:6px 16px;border-radius:999px;background:rgba(249,180,15,.08);border:1px solid rgba(249,180,15,.2);font-family:'Barlow Condensed',sans-serif;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--g);margin-bottom:20px;}

    /* Table */
    .ballot-table{border-radius:14px;overflow:hidden;margin-bottom:28px;}
    .bt-header{display:grid;grid-template-columns:2fr 1.5fr .8fr .8fr 1.4fr;gap:12px;padding:12px 20px;background:rgba(0,0,0,.35);border-bottom:1px solid var(--b2);}
    .bt-th{font-family:'Barlow Condensed',sans-serif;font-size:.58rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--dim);}
    .bt-th.center{text-align:center;}
    .bt-row{display:grid;grid-template-columns:2fr 1.5fr .8fr .8fr 1.4fr;gap:12px;align-items:center;padding:14px 20px;border-bottom:1px solid var(--b2);transition:background .18s;}
    .bt-row:last-child{border-bottom:none;}
    .bt-row:hover{background:rgba(249,180,15,.04);}

    .voter-name{font-size:.88rem;font-weight:500;color:var(--cream);}
    .voter-meta{font-size:.72rem;color:var(--muted);margin-top:2px;}
    .txn-code{font-family:'Barlow Condensed',sans-serif;font-size:.78rem;font-weight:600;color:rgba(249,180,15,.6);letter-spacing:.05em;}
    .voted-count{text-align:center;}
    .vc-num{font-family:'Barlow Condensed',sans-serif;font-size:1rem;font-weight:700;color:var(--green);}
    .vc-total{font-family:'Barlow Condensed',sans-serif;font-size:.65rem;color:var(--dim);}
    .ts-cell{font-size:.78rem;color:var(--muted);}
    .ts-date{font-weight:500;color:var(--cream);}
    .ts-time{font-size:.7rem;color:var(--dim);}

    /* Status pill */
    .status-pill{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:999px;font-family:'Barlow Condensed',sans-serif;font-size:.58rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;}
    .pill-full{color:rgba(34,197,94,.8);background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.2);}
    .pill-partial{color:rgba(249,180,15,.8);background:rgba(249,180,15,.1);border:1px solid rgba(249,180,15,.2);}

    /* Pagination */
    .pagination-wrap{display:flex;justify-content:center;align-items:center;gap:8px;padding-top:8px;}
    .pagination-wrap .page-link{display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 10px;border-radius:8px;background:rgba(249,180,15,.06);border:1px solid var(--b);color:var(--muted);font-family:'Barlow Condensed',sans-serif;font-size:.72rem;font-weight:700;letter-spacing:.05em;text-decoration:none;transition:all .2s;}
    .pagination-wrap .page-link:hover,.pagination-wrap .page-link.active{background:rgba(249,180,15,.15);border-color:rgba(249,180,15,.35);color:var(--g);}
    .pagination-wrap .page-link.disabled{opacity:.35;pointer-events:none;}

    .no-data{padding:40px;text-align:center;color:var(--muted);font-size:.85rem;}
</style>

<div class="orb orb1"></div>
<div class="orb orb2"></div>
<div class="grid-bg"></div>

<div class="wrap">
    <div class="page-header z1 fu d0">
        <div>
            <div class="eyebrow"><span class="eyebrow-line"></span><span class="eyebrow-dot"></span>Reports</div>
            <h1 class="page-h1">Ballot <em>Transaction Log</em></h1>
            <p class="header-sub">Full audit trail of submitted ballots · generated {{ now('Asia/Manila')->format('F j, Y H:i:s T') }}</p>
        </div>
        <a href="{{ route('admin.reports.index') }}" class="back-btn"><i class="fas fa-arrow-left"></i> Reports</a>
    </div>

    <div class="content z1">

        <div class="count-badge fu d1">
            <i class="fas fa-scroll"></i>
            {{ number_format($transactions->total()) }} ballot{{ $transactions->total() !== 1 ? 's' : '' }} recorded
        </div>

        <div class="gs ballot-table fu d2">
            @if($transactions->isEmpty())
                <div class="no-data"><i class="fas fa-inbox" style="font-size:1.5rem;opacity:.3;display:block;margin-bottom:10px;"></i>No ballots have been submitted yet.</div>
            @else
                <div class="bt-header">
                    <span class="bt-th">Voter</span>
                    <span class="bt-th">Transaction #</span>
                    <span class="bt-th center">Voted</span>
                    <span class="bt-th center">Status</span>
                    <span class="bt-th">Timestamp</span>
                </div>
                @foreach($transactions as $txn)
                    @php
                        $voter = $txn->voter;
                        $isFull = $txn->positions_voted >= $txn->positions_count;
                    @endphp
                    <div class="bt-row">
                        <div>
                            <div class="voter-name">{{ $voter ? $voter->first_name . ' ' . $voter->last_name : 'Unknown Voter' }}</div>
                            <div class="voter-meta">
                                {{ $voter?->student_number ?? '—' }}
                                @if($voter?->college)· {{ $voter->college->acronym }}@endif
                            </div>
                        </div>
                        <div class="txn-code">{{ $txn->transaction_number }}</div>
                        <div class="voted-count">
                            <div class="vc-num">{{ $txn->positions_voted }}</div>
                            <div class="vc-total">/ {{ $txn->positions_count }}</div>
                        </div>
                        <div>
                            <span class="status-pill {{ $isFull ? 'pill-full' : 'pill-partial' }}">
                                <i class="fas {{ $isFull ? 'fa-check' : 'fa-circle-half-stroke' }}"></i>
                                {{ $isFull ? 'Complete' : 'Partial' }}
                            </span>
                        </div>
                        <div class="ts-cell">
                            <div class="ts-date">{{ \Carbon\Carbon::parse($txn->voted_at)->timezone('Asia/Manila')->format('M j, Y') }}</div>
                            <div class="ts-time">{{ \Carbon\Carbon::parse($txn->voted_at)->timezone('Asia/Manila')->format('H:i:s T') }}</div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        {{-- Pagination --}}
        @if($transactions->hasPages())
        <div class="pagination-wrap fu d3">
            @if($transactions->onFirstPage())
                <span class="page-link disabled"><i class="fas fa-chevron-left"></i></span>
            @else
                <a href="{{ $transactions->previousPageUrl() }}" class="page-link"><i class="fas fa-chevron-left"></i></a>
            @endif

            @foreach($transactions->getUrlRange(max(1,$transactions->currentPage()-2), min($transactions->lastPage(),$transactions->currentPage()+2)) as $page => $url)
                <a href="{{ $url }}" class="page-link {{ $page == $transactions->currentPage() ? 'active' : '' }}">{{ $page }}</a>
            @endforeach

            @if($transactions->hasMorePages())
                <a href="{{ $transactions->nextPageUrl() }}" class="page-link"><i class="fas fa-chevron-right"></i></a>
            @else
                <span class="page-link disabled"><i class="fas fa-chevron-right"></i></span>
            @endif
        </div>
        @endif

    </div>
</div>
</x-app-layout>