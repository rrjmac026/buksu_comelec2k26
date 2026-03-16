<x-app-layout>
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,800;0,900;1,700&family=Barlow+Condensed:wght@300;400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

{{-- Dashboard styles are in resources/css/dashboard.css, compiled via Vite --}}

{{-- FLOATING ORBS --}}
<div class="orb orb1"></div>
<div class="orb orb2"></div>
<div class="orb orb3"></div>
<div class="grid-bg"></div>
<div class="diag-lines"></div>

<div class="wrap">

  {{-- ══ LIVE TICKER ══ --}}
  <div class="ticker-bar z1">
    <div class="ticker-label">
      <span class="ticker-dot"></span>
      LIVE FEED
    </div>
    <div class="ticker-track">
      <div class="ticker-inner" id="ticker-inner">
        <div class="ticker-item">Election Status <span class="ti-val" id="tk-status">—</span></div>
        <span class="ticker-sep">·</span>
        <div class="ticker-item">Total Voters <span class="ti-val" id="tk-voters">{{ $stats['total_voters'] }}</span></div>
        <span class="ticker-sep">·</span>
        <div class="ticker-item">Votes Cast <span class="ti-val" id="tk-votes">{{ $stats['total_votes'] }}</span></div>
        <span class="ticker-sep">·</span>
        <div class="ticker-item">Turnout <span class="ti-val" id="tk-turnout">{{ $turnoutPct }}%</span></div>
        <span class="ticker-sep">·</span>
        <div class="ticker-item">Candidates <span class="ti-val">{{ $stats['total_candidates'] }}</span></div>
        <span class="ticker-sep">·</span>
        <div class="ticker-item">Positions <span class="ti-val">{{ $stats['total_positions'] }}</span></div>
        <span class="ticker-sep">·</span>
        <div class="ticker-item">Party Lists <span class="ti-val">{{ $stats['total_partylists'] }}</span></div>
        <span class="ticker-sep">·</span>
        <div class="ticker-item">Colleges <span class="ti-val">{{ $stats['total_colleges'] }}</span></div>
        <span class="ticker-sep">·</span>
        {{-- Duplicate for seamless loop --}}
        <div class="ticker-item">Election Status <span class="ti-val">—</span></div>
        <span class="ticker-sep">·</span>
        <div class="ticker-item">Total Voters <span class="ti-val">{{ $stats['total_voters'] }}</span></div>
        <span class="ticker-sep">·</span>
        <div class="ticker-item">Votes Cast <span class="ti-val">{{ $stats['total_votes'] }}</span></div>
        <span class="ticker-sep">·</span>
        <div class="ticker-item">Turnout <span class="ti-val">{{ $turnoutPct }}%</span></div>
        <span class="ticker-sep">·</span>
        <div class="ticker-item">Candidates <span class="ti-val">{{ $stats['total_candidates'] }}</span></div>
        <span class="ticker-sep">·</span>
        <div class="ticker-item">Positions <span class="ti-val">{{ $stats['total_positions'] }}</span></div>
      </div>
    </div>
  </div>

  {{-- ══ PAGE HEADER ══ --}}
  <div class="page-header z1 fu d0">
    <div>
      <div class="eyebrow">
        <span class="eyebrow-line"></span>
        <span class="eyebrow-dot"></span>
        Election Management System
      </div>
      <h1 class="page-h1">Admin <em>Command</em><br>Dashboard</h1>
      <p class="header-sub">
        Welcome back, <strong style="color:var(--g);font-weight:600;">{{ auth()->user()->full_name }}</strong>.
        Here's your live election overview for {{ now()->format('l, F j, Y') }}.
      </p>
    </div>

    <div class="turnout-hero">
      <div class="live-chip"><span class="live-dot2"></span>Live · Auto-refresh 10s</div>
      <div class="th-label">Voter Turnout</div>
      <div id="th-pct" class="th-number">{{ $turnoutPct }}%</div>
      <div class="th-sub">
        <span id="th-voted">{{ number_format($votedCount) }}</span> of
        <span id="th-total">{{ number_format($stats['total_voters']) }}</span> voters
      </div>
      <div class="th-bar">
        <div id="th-bar-fill" class="th-fill" style="width:{{ $turnoutPct }}%"></div>
      </div>
    </div>
  </div>

  <div class="content z1">

  {{-- ══ BENTO STAT TILES ══ --}}
  @php
  $tiles = [
    ['id'=>'st-voters',    'n'=>$stats['total_voters'],     'lbl'=>'Total Voters',   'icon'=>'fa-users',            'badge'=>'Registered', 'sub'=>'Registered accounts', 'delay'=>'d1'],
    ['id'=>'st-votes',     'n'=>$stats['total_votes'],      'lbl'=>'Votes Cast',     'icon'=>'fa-check-to-slot',    'badge'=>'Ballots',    'sub'=>'Submitted ballots',   'delay'=>'d2'],
    ['id'=>'st-cands',     'n'=>$stats['total_candidates'], 'lbl'=>'Candidates',     'icon'=>'fa-user-tie',         'badge'=>'Running',    'sub'=>'Active candidates',   'delay'=>'d3'],
    ['id'=>'st-pos',       'n'=>$stats['total_positions'],  'lbl'=>'Positions',      'icon'=>'fa-list-check',       'badge'=>'Open',       'sub'=>'Elected positions',   'delay'=>'d4'],
    ['id'=>'st-party',     'n'=>$stats['total_partylists'], 'lbl'=>'Party Lists',    'icon'=>'fa-flag',             'badge'=>'Parties',    'sub'=>'Competing parties',   'delay'=>'d5'],
    ['id'=>'st-colleges',  'n'=>$stats['total_colleges'],   'lbl'=>'Colleges',       'icon'=>'fa-building-columns', 'badge'=>'Units',      'sub'=>'Academic units',      'delay'=>'d6'],
    ['id'=>'st-orgs',      'n'=>$stats['total_orgs'],       'lbl'=>'Organizations',  'icon'=>'fa-sitemap',          'badge'=>'Active',     'sub'=>'Student orgs',        'delay'=>'d7'],
  ];
  @endphp

  <div class="bento fu d1">
    @foreach($tiles as $t)
    <div class="gs tile {{ $t['delay'] }}">
      <div class="tile-top">
        <div class="tile-icon"><i class="fas {{ $t['icon'] }}"></i></div>
        <div class="tile-badge">{{ $t['badge'] }}</div>
      </div>
      <div id="{{ $t['id'] }}" class="tile-num">{{ $t['n'] }}</div>
      <div class="tile-label">{{ $t['lbl'] }}</div>
      <div class="tile-sub"><span class="tile-sub-dot"></span>{{ $t['sub'] }}</div>
      <div class="sparkline">
        @for($s=0;$s<8;$s++)
        <div class="spark-bar {{ $s===7?'active':'' }}" style="height:{{ rand(20,100) }}%;"></div>
        @endfor
      </div>
    </div>
    @endforeach

    <div class="gs tile-lg fu d2">
      <div class="tile-lg-l">
        <div class="tile-top">
          <div class="tile-icon"><i class="fas fa-chart-pie"></i></div>
          <div class="tile-badge">Live</div>
        </div>
        <div id="st-remaining" class="tile-num">{{ number_format($notVoted) }}</div>
        <div class="tile-label">Still to Vote</div>
        <div class="tile-sub"><span class="tile-sub-dot"></span>Pending ballots</div>
      </div>
      <div class="tile-lg-r">
        <div>
          <div class="tile-label" style="margin-bottom:8px;">Participation</div>
          <div style="height:5px;background:rgba(249,180,15,.08);border-radius:99px;margin-bottom:6px;">
            <div id="part-bar" style="height:100%;border-radius:99px;background:linear-gradient(90deg,var(--g),var(--g-lt));transition:width 1s;width:{{ $turnoutPct }}%"></div>
          </div>
          <div style="display:flex;justify-content:space-between;">
            <span style="font-family:'Barlow Condensed',sans-serif;font-size:.6rem;color:var(--muted);">Voted</span>
            <span style="font-family:'Barlow Condensed',sans-serif;font-size:.6rem;color:var(--g);font-weight:700;" id="part-pct">{{ $turnoutPct }}%</span>
          </div>
        </div>
        <div>
          <div style="font-family:'Barlow Condensed',sans-serif;font-size:.58rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--dim);margin-bottom:6px;">Recent activity</div>
          <div id="mini-feed" style="display:flex;flex-direction:column;gap:4px;"></div>
        </div>
      </div>
    </div>
  </div>

  {{-- ══ ANALYTICS ROW ══ --}}
  <div class="analytics-grid fu d3">

    <div class="gs" style="overflow:hidden;">
      <div class="panel-head">
        <div><div class="panel-eye">Today</div><div class="panel-title">Voters per Hour</div></div>
        <span style="font-size:.6rem;color:var(--dim);">UTC+8</span>
      </div>
      <div class="chart-wrap">
        <div style="height:140px;position:relative;"><canvas id="chartLine"></canvas></div>
      </div>
    </div>

    <div class="gs" style="overflow:hidden;">
      <div class="panel-head">
        <div><div class="panel-eye">Breakdown</div><div class="panel-title">Votes by Position</div></div>
      </div>
      <div class="chart-wrap">
        <div style="height:140px;position:relative;"><canvas id="chartBar"></canvas></div>
      </div>
    </div>

    <div class="gs" style="overflow:hidden;">
      <div class="panel-head">
        <div><div class="panel-eye">Summary</div><div class="panel-title">Turnout</div></div>
      </div>
      <div class="donut-panel">
        <div class="donut-wrap">
          <canvas id="chartDonut" width="130" height="130" style="display:block;"></canvas>
          <div class="donut-center">
            <div id="donut-pct" class="donut-pct">{{ $turnoutPct }}%</div>
            <div class="donut-sub">turnout</div>
          </div>
        </div>
        <div class="donut-legend">
          <div class="dl-row">
            <div class="dl-label"><div class="dl-dot" style="background:var(--g);"></div>Voted</div>
            <div class="dl-val" id="dl-voted">{{ $turnoutPct }}%</div>
          </div>
          <div class="dl-row">
            <div class="dl-label"><div class="dl-dot" style="background:rgba(56,0,65,.9);border:1px solid var(--b);"></div>Pending</div>
            <div class="dl-val" id="dl-pend" style="color:var(--muted);">{{ round(100-$turnoutPct,1) }}%</div>
          </div>
          <div class="still-box">
            <div class="still-lbl">Still to vote</div>
            <span id="still-val" class="still-val">{{ number_format($notVoted) }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- ══ BOTTOM ROW ══ --}}
  <div class="bottom-grid fu d4">

    <div class="gs" style="display:flex;flex-direction:column;overflow:hidden;">
      <div class="feed-head">
        <div><div class="panel-eye">Real-time</div><div class="panel-title">Ballot Activity</div></div>
        <span style="font-family:'Barlow Condensed',sans-serif;font-size:.6rem;font-weight:700;letter-spacing:.08em;color:rgba(34,197,94,.7);">● LIVE</span>
      </div>
      <div id="feed-list" class="feed-scroll" style="flex:1;">
        @foreach($recentVotes as $vote)
        <div class="feed-item">
          <div class="feed-av">{{ strtoupper(substr($vote->voter?->full_name ?? 'U',0,1)) }}</div>
          <div style="flex:1;min-width:0;">
            <div class="feed-name">{{ $vote->voter?->full_name ?? 'Unknown' }}</div>
            <div class="feed-txn">{{ Str::limit($vote->transaction_number ?? '—',20) }}</div>
            <div class="feed-time">{{ $vote->voted_at?->diffForHumans() ?? '—' }}</div>
          </div>
          <div class="feed-status"></div>
        </div>
        @endforeach
      </div>
      <div class="feed-footer">
        <a href="{{ route('admin.votes.index') }}" class="btn-all">
          All ballots <i class="fas fa-arrow-right" style="font-size:.6rem;"></i>
        </a>
      </div>
    </div>

    <div class="gs" style="overflow:hidden;">
      <div class="panel-head">
        <div><div class="panel-eye">Administrators</div><div class="panel-title">Team</div></div>
        <div style="display:flex;align-items:center;gap:5px;">
          <span style="width:7px;height:7px;border-radius:50%;background:var(--green);box-shadow:0 0 6px var(--green);display:inline-block;"></span>
          <span style="font-family:'Barlow Condensed',sans-serif;font-size:.6rem;color:var(--dim);">{{ $teamMembers->count() }} online</span>
        </div>
      </div>
      <div class="team-panel">
        @foreach($teamMembers->take(5) as $m)
        <div class="m-item">
          <div class="m-av">{{ strtoupper(substr($m->full_name,0,1)) }}</div>
          <div style="flex:1;min-width:0;">
            <div class="m-name">{{ $m->full_name }}</div>
            <div class="m-role">{{ $m->role }}</div>
          </div>
        </div>
        @endforeach
        <div class="hdiv">
          <span style="font-family:'Barlow Condensed',sans-serif;font-size:.62rem;color:var(--dim);">{{ $teamMembers->count() }} member{{ $teamMembers->count()!=1?'s':'' }}</span>
          <a href="#" class="link-gold">Manage →</a>
        </div>
      </div>
      <div style="padding:14px 20px 18px;border-top:1px solid var(--b2);">
        <div class="panel-eye" style="margin-bottom:10px;">System Health</div>
        @php $sys=[['l'=>'Uptime','v'=>'99.9%','p'=>99],['l'=>'Response','v'=>'42ms','p'=>85],['l'=>'CPU','v'=>'23%','p'=>23]]; @endphp
        @foreach($sys as $s)
        <div class="sys-row">
          <span class="sys-lbl">{{ $s['l'] }}</span>
          <div class="sys-track"><div class="sys-fill" style="width:{{ $s['p'] }}%;"></div></div>
          <span class="sys-val">{{ $s['v'] }}</span>
        </div>
        @endforeach
      </div>
    </div>

    <div class="gs" style="overflow:hidden;">
      <div class="panel-head">
        <div><div class="panel-eye">Rankings</div><div class="panel-title">Top Candidates</div></div>
        <a href="{{ route('admin.votes.results') }}" class="link-gold">Results →</a>
      </div>
      <div class="lb-panel" id="lb-list">
        @foreach($topCandidates as $i => $c)
        @php $pct=$stats['total_votes']>0?round(($c->votes_count/$stats['total_votes'])*100,1):0; @endphp
        <div class="lb-item">
          <div class="lb-rank {{ $i===0?'r1':($i===1?'r2':($i===2?'r3':'')) }}">{{ $i+1 }}</div>
          <div class="lb-av">{{ strtoupper(substr($c->first_name,0,1)) }}</div>
          <div style="flex:1;min-width:0;">
            <div class="lb-name">{{ $c->first_name }} {{ $c->last_name }}</div>
            <div class="lb-pos">{{ $c->position?->name ?? '—' }}</div>
            <div class="lb-prog"><div class="lb-fill" style="width:{{ $pct }}%"></div></div>
          </div>
          <div>
            <div class="lb-votes">{{ $c->votes_count }}</div>
            <div class="lb-pct">{{ $pct }}%</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>

  </div>
  </div>{{-- /content --}}
</div>{{-- /wrap --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
    (() => {
    Chart.defaults.color = 'rgba(249,180,15,0.38)';
    Chart.defaults.font.family = "'DM Sans', sans-serif";

    const tip = {
        backgroundColor:'rgba(14,0,19,.97)',
        borderColor:'rgba(249,180,15,.25)',borderWidth:1,
        titleColor:'rgba(249,180,15,.7)',bodyColor:'#fffbf0',
        padding:10,cornerRadius:8,
    };
    const grd = {color:'rgba(249,180,15,.04)',drawBorder:false};
    const tck = {font:{size:8},color:'rgba(249,180,15,.35)',maxRotation:0};

    const cL = document.getElementById('chartLine').getContext('2d');
    const lg = cL.createLinearGradient(0,0,0,140);
    lg.addColorStop(0,'rgba(249,180,15,.28)');
    lg.addColorStop(1,'rgba(249,180,15,.01)');
    const lineChart = new Chart(cL,{
        type:'line',
        data:{labels:[],datasets:[{label:'Voters',data:[],borderColor:'#f9b40f',backgroundColor:lg,borderWidth:2.5,fill:true,tension:.44,pointBackgroundColor:'#f9b40f',pointBorderColor:'rgba(14,0,19,.9)',pointBorderWidth:2,pointRadius:3.5,pointHoverRadius:6}]},
        options:{responsive:true,maintainAspectRatio:false,animation:{duration:500},plugins:{legend:{display:false},tooltip:tip},scales:{x:{grid:grd,border:{display:false},ticks:{...tck,maxTicksLimit:8}},y:{grid:grd,border:{display:false},ticks:{...tck,maxTicksLimit:4},beginAtZero:true}}}
    });

    const cB = document.getElementById('chartBar').getContext('2d');
    const barChart = new Chart(cB,{
        type:'bar',
        data:{labels:[],datasets:[{label:'Votes',data:[],backgroundColor:'rgba(249,180,15,.55)',borderColor:'rgba(249,180,15,.9)',borderWidth:1,borderRadius:{topLeft:5,topRight:5},borderSkipped:false,barPercentage:.5}]},
        options:{responsive:true,maintainAspectRatio:false,animation:{duration:500},plugins:{legend:{display:false},tooltip:tip},scales:{x:{grid:grd,border:{display:false},ticks:{...tck,maxTicksLimit:6}},y:{grid:grd,border:{display:false},ticks:{...tck,maxTicksLimit:4},beginAtZero:true}}}
    });

    const cD = document.getElementById('chartDonut').getContext('2d');
    const donutChart = new Chart(cD,{
        type:'doughnut',
        data:{labels:['Voted','Not Yet'],datasets:[{data:[{{ $votedCount }},{{ $notVoted > 0 ? $notVoted : ($votedCount > 0 ? 0 : 1) }}],backgroundColor:['rgba(249,180,15,.88)','rgba(56,0,65,.75)'],borderColor:['rgba(249,180,15,.5)','rgba(249,180,15,.07)'],borderWidth:2,hoverOffset:8}]},
        options:{responsive:false,maintainAspectRatio:false,cutout:'66%',animation:{duration:900},plugins:{legend:{display:false},tooltip:tip}}
    });

    function animN(el,to){
        if(!el) return;
        const isF=el.textContent.includes('%');
        const from=parseFloat(el.textContent.replace(/[^0-9.]/g,''))||0;
        if(Math.abs(from-to)<.5) return;
        const steps=22,dur=450;let s=0;
        const t=setInterval(()=>{s++;const v=from+(to-from)*(s/steps);el.textContent=isF?v.toFixed(1)+'%':Math.round(v).toLocaleString();if(s>=steps){el.textContent=isF?to.toFixed(1)+'%':to.toLocaleString();clearInterval(t);}},dur/steps);
    }

    function renderMini(votes){
        const el=document.getElementById('mini-feed'); if(!el||!votes?.length) return;
        el.innerHTML=votes.slice(0,3).map(v=>`
        <div style="display:flex;align-items:center;gap:7px;padding:4px 0;border-bottom:1px solid rgba(249,180,15,.06);">
            <div style="width:22px;height:22px;border-radius:7px;background:linear-gradient(135deg,var(--v-md),var(--v-lt));display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-size:.62rem;font-weight:900;color:var(--g);flex-shrink:0;">${(v.voter||'U')[0].toUpperCase()}</div>
            <div style="flex:1;min-width:0;">
            <div style="font-size:.62rem;font-weight:600;color:var(--cream);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${v.voter}</div>
            <div style="font-size:.56rem;color:var(--dim);">${v.voted_at}</div>
            </div>
            <div style="width:5px;height:5px;border-radius:50%;background:var(--green);flex-shrink:0;box-shadow:0 0 6px var(--green);"></div>
        </div>`).join('');
    }

    function renderFeed(votes){
        const el=document.getElementById('feed-list'); if(!el||!votes?.length) return;
        el.innerHTML=votes.map(v=>`
        <div class="feed-item">
        <div class="feed-av">${(v.voter||'U')[0].toUpperCase()}</div>
        <div style="flex:1;min-width:0;">
            <div class="feed-name">${v.voter}</div>
            <div class="feed-txn">${(v.transaction||'—').substring(0,20)}</div>
            <div class="feed-time">${v.voted_at}</div>
        </div>
        <div class="feed-status"></div>
        </div>`).join('');
    }

    function renderLB(cands,total){
        const el=document.getElementById('lb-list'); if(!el||!cands?.length) return;
        el.innerHTML=cands.map((c,i)=>{
        const pct=total>0?((c.votes/total)*100).toFixed(1):0;
        const rc=i===0?'r1':i===1?'r2':i===2?'r3':'';
        return `<div class="lb-item">
            <div class="lb-rank ${rc}">${i+1}</div>
            <div class="lb-av">${(c.name||'U')[0].toUpperCase()}</div>
            <div style="flex:1;min-width:0;">
            <div class="lb-name">${c.name}</div>
            <div class="lb-pos">${c.position}</div>
            <div class="lb-prog"><div class="lb-fill" style="width:${pct}%"></div></div>
            </div>
            <div>
            <div class="lb-votes">${c.votes}</div>
            <div class="lb-pct">${pct}%</div>
            </div>
        </div>`;
        }).join('');
    }

    async function poll(){
        try{
        const r=await fetch('{{ route('admin.dashboard.live') }}',{headers:{'Accept':'application/json','X-Requested-With':'XMLHttpRequest'}});
        if(!r.ok) return;
        const d=await r.json();

        const map={'st-voters':d.stats.total_voters,'st-votes':d.stats.total_votes,'st-cands':d.stats.total_candidates,'st-pos':d.stats.total_positions,'st-party':d.stats.total_partylists,'st-colleges':d.stats.total_colleges,'st-orgs':d.stats.total_orgs};
        Object.entries(map).forEach(([id,v])=>animN(document.getElementById(id),v));

        const {voted,not_voted}=d.turnout;
        const total=voted+not_voted;
        const pct=total>0?parseFloat(((voted/total)*100).toFixed(1)):0;
        const nPct=parseFloat((100-pct).toFixed(1));

        const thEl=document.getElementById('th-pct'); if(thEl) thEl.textContent=pct.toFixed(1)+'%';
        const thV=document.getElementById('th-voted'); if(thV) thV.textContent=voted.toLocaleString();
        const thT=document.getElementById('th-total'); if(thT) thT.textContent=d.stats.total_voters.toLocaleString();
        const thB=document.getElementById('th-bar-fill'); if(thB) thB.style.width=pct+'%';

        const dpEl=document.getElementById('donut-pct'); if(dpEl) dpEl.textContent=pct.toFixed(1)+'%';
        const dlV=document.getElementById('dl-voted'); if(dlV) dlV.textContent=pct.toFixed(1)+'%';
        const dlP=document.getElementById('dl-pend');  if(dlP) dlP.textContent=nPct.toFixed(1)+'%';
        const stV=document.getElementById('still-val'); if(stV) stV.textContent=not_voted.toLocaleString();

        animN(document.getElementById('st-remaining'),not_voted);
        const ppEl=document.getElementById('part-pct'); if(ppEl) ppEl.textContent=pct.toFixed(1)+'%';
        const pbEl=document.getElementById('part-bar'); if(pbEl) pbEl.style.width=pct+'%';

        const tkS=document.getElementById('tk-status'); if(tkS) tkS.textContent=d.stats.total_votes>0?'Ongoing':'Upcoming';
        const tkVo=document.getElementById('tk-voters'); if(tkVo) tkVo.textContent=d.stats.total_voters.toLocaleString();
        const tkVt=document.getElementById('tk-votes');  if(tkVt) tkVt.textContent=d.stats.total_votes.toLocaleString();
        const tkTu=document.getElementById('tk-turnout');if(tkTu) tkTu.textContent=pct.toFixed(1)+'%';

        donutChart.data.datasets[0].data=[voted,not_voted>0?not_voted:(voted>0?0:1)];
        donutChart.update('active');
        if(d.hourly?.labels?.length){lineChart.data.labels=d.hourly.labels;lineChart.data.datasets[0].data=d.hourly.data;lineChart.update('active');}
        if(d.votesByPosition?.length){barChart.data.labels=d.votesByPosition.map(p=>p.label);barChart.data.datasets[0].data=d.votesByPosition.map(p=>p.count);barChart.update('active');}

        renderFeed(d.recentVotes);
        renderMini(d.recentVotes);
        renderLB(d.topCandidates,d.stats.total_votes);
        }catch(e){console.warn('poll:',e);}
    }

    poll();
    setInterval(poll,10000);
    })();
</script>

</x-app-layout>