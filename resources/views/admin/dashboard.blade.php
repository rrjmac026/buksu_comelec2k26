<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,800;0,900;1,700&family=Barlow+Condensed:wght@300;400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
/* ═══════════════════════════════════════════
   DESIGN TOKENS
═══════════════════════════════════════════ */
:root {
  --g:        #f9b40f;   /* gold */
  --g-lt:     #fcd558;   /* gold light */
  --g-dk:     #c98a00;   /* gold dark */
  --g-pale:   #fef3c7;
  --v:        #380041;   /* violet */
  --v-md:     #520060;
  --v-lt:     #6b0080;
  --v-xl:     #1e0025;   /* deepest */
  --ink:      #0e0013;   /* near-black */
  --cream:    #fffbf0;
  --glass:    rgba(22,0,28,0.72);
  --glass2:   rgba(30,0,38,0.82);
  --b:        rgba(249,180,15,0.14);   /* border */
  --b2:       rgba(249,180,15,0.07);
  --b3:       rgba(249,180,15,0.04);
  --muted:    rgba(255,251,240,0.50);
  --dim:      rgba(255,251,240,0.24);
  --green:    #22c55e;
  --red:      #ef4444;
}

*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}

/* ═══════════════════════════════════════════
   PAGE SHELL + ATMOSPHERE
═══════════════════════════════════════════ */
.wrap{
  font-family:'DM Sans',sans-serif;
  color:var(--cream);
  min-height:100vh;
  position:relative;
  padding:0 0 60px;
  background:var(--ink);
  overflow-x:hidden;
}

/* Layered ambient background */
.wrap::before{
  content:'';position:fixed;inset:0;pointer-events:none;z-index:0;
  background:
    radial-gradient(ellipse 800px 600px at 0% 0%, rgba(56,0,65,.9) 0%, transparent 60%),
    radial-gradient(ellipse 600px 500px at 100% 100%, rgba(82,0,96,.7) 0%, transparent 55%),
    radial-gradient(ellipse 400px 300px at 55% 30%, rgba(249,180,15,.04) 0%, transparent 60%),
    radial-gradient(ellipse 300px 400px at 15% 70%, rgba(56,0,65,.5) 0%, transparent 60%);
}

/* Noise grain */
.wrap::after{
  content:'';position:fixed;inset:0;pointer-events:none;z-index:0;opacity:.03;
  background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
  background-size:220px;
}

/* Fine grid */
.grid-bg{
  position:fixed;inset:0;z-index:0;pointer-events:none;
  background-image:
    linear-gradient(rgba(249,180,15,.03) 1px,transparent 1px),
    linear-gradient(90deg,rgba(249,180,15,.03) 1px,transparent 1px);
  background-size:52px 52px;
}

/* Diagonal accent lines (decorative) */
.diag-lines{
  position:fixed;inset:0;z-index:0;pointer-events:none;overflow:hidden;
}
.diag-lines::before{
  content:'';position:absolute;top:-200px;right:-100px;
  width:1px;height:800px;
  background:linear-gradient(180deg,transparent,rgba(249,180,15,.12),transparent);
  transform:rotate(25deg);transform-origin:top center;
}
.diag-lines::after{
  content:'';position:absolute;bottom:-200px;left:-100px;
  width:1px;height:800px;
  background:linear-gradient(180deg,transparent,rgba(249,180,15,.08),transparent);
  transform:rotate(25deg);transform-origin:bottom center;
}

.z1{position:relative;z-index:1;}

/* ═══════════════════════════════════════════
   ANIMATIONS
═══════════════════════════════════════════ */
@keyframes fadeUp   {from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:translateY(0)}}
@keyframes fadeIn   {from{opacity:0}to{opacity:1}}
@keyframes glow     {0%,100%{box-shadow:0 0 8px rgba(249,180,15,.4)}50%{box-shadow:0 0 20px rgba(249,180,15,1),0 0 40px rgba(249,180,15,.3)}}
@keyframes gpulse   {0%,100%{opacity:1}50%{opacity:.3}}
@keyframes tick     {from{transform:translateX(0)}to{transform:translateX(-50%)}}
@keyframes shimmer  {from{transform:translateX(-200%)}to{transform:translateX(200%)}}
@keyframes orb1     {from{transform:translate(0,0)scale(1)}to{transform:translate(60px,40px)scale(1.06)}}
@keyframes orb2     {from{transform:translate(0,0)scale(1)}to{transform:translate(-50px,-40px)scale(1.08)}}
@keyframes countIn  {from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
@keyframes borderPulse{0%,100%{border-color:rgba(249,180,15,.14)}50%{border-color:rgba(249,180,15,.35)}}
@keyframes slideIn  {from{opacity:0;transform:translateX(-10px)}to{opacity:1;transform:translateX(0)}}

.fu{opacity:0;animation:fadeUp .7s cubic-bezier(.22,1,.36,1) forwards}
.d0{animation-delay:.04s}.d1{animation-delay:.10s}.d2{animation-delay:.17s}
.d3{animation-delay:.24s}.d4{animation-delay:.31s}.d5{animation-delay:.38s}
.d6{animation-delay:.45s}.d7{animation-delay:.52s}.d8{animation-delay:.59s}

/* ═══════════════════════════════════════════
   FLOATING ORBS
═══════════════════════════════════════════ */
.orb{position:fixed;border-radius:50%;pointer-events:none;z-index:0;filter:blur(90px);}
.orb1{width:700px;height:700px;top:-250px;left:-200px;background:radial-gradient(circle,rgba(56,0,65,.85),rgba(82,0,96,.5),transparent 70%);animation:orb1 20s ease-in-out infinite alternate;opacity:.6;}
.orb2{width:500px;height:500px;bottom:-150px;right:-150px;background:radial-gradient(circle,rgba(249,180,15,.10),rgba(82,0,96,.35),transparent 70%);animation:orb2 25s ease-in-out infinite alternate;opacity:.55;}
.orb3{width:350px;height:350px;top:45%;left:58%;background:radial-gradient(circle,rgba(249,180,15,.07),rgba(56,0,65,.2),transparent 70%);animation:orb1 18s ease-in-out 5s infinite alternate;opacity:.5;}

/* ═══════════════════════════════════════════
   GLASS SURFACE (base card DNA)
═══════════════════════════════════════════ */
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
/* Shimmer on hover */
.gs::after{
  content:'';position:absolute;top:0;left:0;width:40%;height:100%;
  background:linear-gradient(90deg,transparent,rgba(249,180,15,.03),transparent);
  transform:translateX(-200%);pointer-events:none;transition:none;
}
.gs:hover::after{animation:shimmer 1s ease forwards;}
.gs:hover{border-color:rgba(249,180,15,.30);box-shadow:0 20px 60px rgba(0,0,0,.5),0 0 0 1px rgba(249,180,15,.08) inset;}

/* ═══════════════════════════════════════════
   LIVE TICKER
═══════════════════════════════════════════ */
.ticker-bar{
  background:rgba(14,0,19,.9);
  border-bottom:1px solid var(--b);
  height:36px;overflow:hidden;display:flex;align-items:center;
  position:relative;
}
.ticker-label{
  flex-shrink:0;padding:0 18px;
  font-family:'Barlow Condensed',sans-serif;
  font-size:.65rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;
  color:var(--g);background:rgba(249,180,15,.1);border-right:1px solid var(--b);
  height:100%;display:flex;align-items:center;gap:8px;white-space:nowrap;
}
.ticker-dot{width:6px;height:6px;border-radius:50%;background:var(--green);animation:gpulse 1.2s infinite;box-shadow:0 0 8px var(--green);}
.ticker-track{overflow:hidden;flex:1;}
.ticker-inner{
  display:flex;align-items:center;gap:48px;
  animation:tick 28s linear infinite;
  white-space:nowrap;width:max-content;
}
.ticker-item{
  font-family:'Barlow Condensed',sans-serif;
  font-size:.72rem;font-weight:500;letter-spacing:.04em;color:var(--muted);
  display:flex;align-items:center;gap:10px;
}
.ticker-item .ti-val{color:var(--g);font-weight:700;font-size:.78rem;}
.ticker-sep{color:rgba(249,180,15,.2);font-size:.8rem;}

/* ═══════════════════════════════════════════
   PAGE HEADER — asymmetric hero layout
═══════════════════════════════════════════ */
.page-header{
  padding:36px 40px 32px;
  display:grid;
  grid-template-columns:1fr auto;
  align-items:end;
  gap:32px;
  border-bottom:1px solid var(--b2);
}
.eyebrow{
  display:inline-flex;align-items:center;gap:10px;
  font-family:'Barlow Condensed',sans-serif;
  font-size:.65rem;font-weight:700;letter-spacing:.15em;text-transform:uppercase;
  color:var(--g);margin-bottom:14px;
}
.eyebrow-line{width:32px;height:1px;background:linear-gradient(90deg,var(--g),transparent);}
.eyebrow-dot{width:5px;height:5px;border-radius:50%;background:var(--g);animation:glow 2s ease-in-out infinite;flex-shrink:0;}
.page-h1{
  font-family:'Playfair Display',serif;
  font-size:clamp(2.4rem,4vw,3.6rem);font-weight:900;
  line-height:.95;letter-spacing:-.03em;color:var(--cream);
}
.page-h1 em{
  font-style:italic;
  background:linear-gradient(110deg,var(--g) 0%,var(--g-lt) 50%,#fff6c8 100%);
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.header-sub{
  font-size:.8rem;color:var(--muted);font-weight:300;margin-top:12px;
  line-height:1.6;max-width:460px;
}

/* Header right — big turnout focal number */
.turnout-hero{
  text-align:right;
  padding:24px 28px;
  background:rgba(249,180,15,.05);
  border:1px solid var(--b);
  border-radius:16px;
  position:relative;overflow:hidden;
  min-width:240px;
}
.turnout-hero::before{
  content:'TURNOUT';
  position:absolute;bottom:-8px;right:16px;
  font-family:'Barlow Condensed',sans-serif;
  font-size:3.5rem;font-weight:800;letter-spacing:.06em;
  color:rgba(249,180,15,.04);line-height:1;pointer-events:none;
}
.th-label{
  font-family:'Barlow Condensed',sans-serif;
  font-size:.6rem;font-weight:700;letter-spacing:.15em;text-transform:uppercase;
  color:rgba(249,180,15,.5);margin-bottom:6px;
}
.th-number{
  font-family:'Playfair Display',serif;
  font-size:3.8rem;font-weight:900;line-height:1;
  background:linear-gradient(135deg,var(--g),var(--g-lt),#fff3c4);
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
  letter-spacing:-.04em;
}
.th-sub{font-size:.72rem;color:var(--muted);margin-top:8px;line-height:1.4;}
.th-bar{height:3px;background:rgba(249,180,15,.1);border-radius:99px;margin-top:14px;}
.th-fill{height:100%;border-radius:99px;background:linear-gradient(90deg,var(--g),var(--g-lt));transition:width 1s cubic-bezier(.4,0,.2,1);}
.live-chip{
  display:inline-flex;align-items:center;gap:6px;
  background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.25);
  border-radius:999px;padding:3px 12px;margin-bottom:10px;
  font-family:'Barlow Condensed',sans-serif;
  font-size:.62rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;
  color:var(--green);
}
.live-dot2{width:6px;height:6px;border-radius:50%;background:var(--green);animation:gpulse 1.3s infinite;box-shadow:0 0 6px var(--green);}

/* ═══════════════════════════════════════════
   CONTENT AREA
═══════════════════════════════════════════ */
.content{padding:28px 40px 0;}

/* ═══════════════════════════════════════════
   BENTO STAT GRID
═══════════════════════════════════════════ */
.bento{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  grid-template-rows:auto auto;
  gap:12px;
  margin-bottom:20px;
}

/* Individual stat tile */
.tile{
  padding:22px 22px 18px;
  cursor:default;
  transition:transform .22s cubic-bezier(.4,0,.2,1),box-shadow .22s;
}
.tile:hover{transform:translateY(-4px);box-shadow:0 24px 60px rgba(0,0,0,.5),0 0 0 1px rgba(249,180,15,.2) inset;}

/* Featured large tile */
.tile-lg{
  grid-column:span 2;
  display:grid;grid-template-columns:1fr 1fr;
  gap:0;padding:0;overflow:hidden;
}
.tile-lg-l{padding:26px 26px 22px;border-right:1px solid var(--b2);}
.tile-lg-r{padding:26px 26px 22px;display:flex;flex-direction:column;justify-content:space-between;}

.tile-top{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:16px;}
.tile-icon{
  width:40px;height:40px;border-radius:12px;
  display:flex;align-items:center;justify-content:center;
  font-size:.9rem;
  background:rgba(249,180,15,.09);color:var(--g);
  border:1px solid rgba(249,180,15,.18);
  transition:all .22s;
}
.tile:hover .tile-icon{
  background:linear-gradient(135deg,var(--g),var(--g-lt));
  color:var(--v);border-color:var(--g);
  box-shadow:0 4px 20px rgba(249,180,15,.4);
}
.tile-badge{
  font-family:'Barlow Condensed',sans-serif;
  font-size:.58rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;
  padding:3px 10px;border-radius:999px;
  color:rgba(249,180,15,.7);background:rgba(249,180,15,.09);border:1px solid rgba(249,180,15,.18);
}
.tile-num{
  font-family:'Playfair Display',serif;
  font-size:2.4rem;font-weight:900;line-height:1;letter-spacing:-.04em;
  background:linear-gradient(135deg,var(--g),var(--g-lt),#fff3c4);
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
  margin-bottom:5px;
}
.tile-label{
  font-family:'Barlow Condensed',sans-serif;
  font-size:.65rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;
  color:var(--muted);
}
.tile-sub{
  font-size:.62rem;color:var(--dim);
  margin-top:10px;padding-top:10px;border-top:1px solid var(--b2);
  display:flex;align-items:center;gap:6px;
}
.tile-sub-dot{width:4px;height:4px;border-radius:50%;background:var(--g);opacity:.5;flex-shrink:0;}

/* Mini sparkline placeholder bars */
.sparkline{display:flex;align-items:flex-end;gap:3px;height:28px;margin-top:10px;}
.spark-bar{
  flex:1;border-radius:3px 3px 0 0;
  background:rgba(249,180,15,.2);
  transition:height .4s,background .2s;
  min-height:3px;
}
.spark-bar.active{background:var(--g);}

/* ═══════════════════════════════════════════
   MAIN ANALYTICS PANEL
═══════════════════════════════════════════ */
.analytics-grid{
  display:grid;
  grid-template-columns:1fr 1fr 280px;
  gap:12px;
  margin-bottom:20px;
}

.panel-head{
  display:flex;align-items:center;justify-content:space-between;
  padding:18px 22px 14px;
  border-bottom:1px solid var(--b2);
}
.panel-title{
  font-family:'Playfair Display',serif;
  font-size:.92rem;font-weight:800;color:var(--cream);
}
.panel-eye{
  font-family:'Barlow Condensed',sans-serif;
  font-size:.58rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;
  color:rgba(249,180,15,.4);margin-bottom:2px;
}

/* Charts */
.chart-wrap{padding:16px 20px 18px;}
.chart-label{
  font-family:'Barlow Condensed',sans-serif;
  font-size:.6rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;
  color:rgba(249,180,15,.4);margin-bottom:10px;
}

/* KPI row inside analytics */
.kpi-strip{
  display:grid;grid-template-columns:repeat(3,1fr);
  border-bottom:1px solid var(--b2);
}
.kpi-cell{padding:14px 20px;border-right:1px solid var(--b2);position:relative;}
.kpi-cell:last-child{border-right:none;}
.kpi-num{
  font-family:'Playfair Display',serif;
  font-size:1.7rem;font-weight:900;line-height:1;letter-spacing:-.04em;
  background:linear-gradient(135deg,var(--g),var(--g-lt));
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.kpi-lbl{
  font-family:'Barlow Condensed',sans-serif;
  font-size:.62rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;
  color:var(--dim);margin-top:3px;
}
.kpi-chip{
  position:absolute;top:12px;right:12px;
  font-family:'Barlow Condensed',sans-serif;
  font-size:.55rem;font-weight:700;letter-spacing:.05em;
  padding:2px 7px;border-radius:999px;
  color:var(--green);background:rgba(34,197,94,.10);border:1px solid rgba(34,197,94,.22);
}

/* ═══════════════════════════════════════════
   DOUGHNUT PANEL (right of charts)
═══════════════════════════════════════════ */
.donut-panel{
  display:flex;flex-direction:column;
  align-items:center;justify-content:center;
  padding:18px 16px;gap:16px;
}
.donut-wrap{position:relative;width:130px;height:130px;flex-shrink:0;}
.donut-center{
  position:absolute;inset:0;
  display:flex;flex-direction:column;align-items:center;justify-content:center;
  pointer-events:none;
}
.donut-pct{
  font-family:'Playfair Display',serif;
  font-size:1.25rem;font-weight:900;line-height:1;
  background:linear-gradient(135deg,var(--g),var(--g-lt));
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.donut-sub{
  font-family:'Barlow Condensed',sans-serif;
  font-size:.58rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;
  color:var(--dim);margin-top:3px;
}
.donut-legend{width:100%;display:flex;flex-direction:column;gap:8px;}
.dl-row{display:flex;align-items:center;justify-content:space-between;}
.dl-label{
  font-family:'Barlow Condensed',sans-serif;
  font-size:.65rem;font-weight:600;letter-spacing:.05em;
  color:var(--muted);display:flex;align-items:center;gap:8px;
}
.dl-dot{width:8px;height:8px;border-radius:2px;flex-shrink:0;}
.dl-val{
  font-family:'Playfair Display',serif;
  font-size:.75rem;font-weight:700;color:var(--g);
}
.still-box{
  width:100%;background:rgba(249,180,15,.05);
  border:1px solid var(--b);border-radius:10px;
  padding:8px 12px;text-align:center;
}
.still-lbl{
  font-family:'Barlow Condensed',sans-serif;
  font-size:.57rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;
  color:var(--dim);
}
.still-val{
  font-family:'Playfair Display',serif;
  font-size:.95rem;font-weight:900;
  background:linear-gradient(135deg,var(--g),var(--g-lt));
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
  margin-top:2px;display:block;
}

/* ═══════════════════════════════════════════
   BOTTOM ROW
═══════════════════════════════════════════ */
.bottom-grid{
  display:grid;
  grid-template-columns:1fr 1fr 1fr;
  gap:12px;
}

/* Activity feed */
.feed-head{padding:18px 20px 14px;border-bottom:1px solid var(--b2);display:flex;align-items:center;justify-content:space-between;flex-shrink:0;}
.feed-scroll{overflow-y:auto;max-height:310px;padding:10px 14px;scrollbar-width:thin;scrollbar-color:rgba(249,180,15,.18) transparent;}
.feed-scroll::-webkit-scrollbar{width:3px;}
.feed-scroll::-webkit-scrollbar-thumb{background:rgba(249,180,15,.2);border-radius:99px;}

.feed-item{
  display:flex;align-items:flex-start;gap:12px;
  padding:10px 10px;border-radius:12px;
  background:rgba(249,180,15,.025);
  border:1px solid rgba(249,180,15,.06);
  margin-bottom:7px;
  transition:all .2s;position:relative;overflow:hidden;
}
.feed-item::before{
  content:'';position:absolute;left:0;top:0;bottom:0;width:2px;
  background:linear-gradient(180deg,var(--g),rgba(249,180,15,.2));
  border-radius:0 1px 1px 0;
}
.feed-item:hover{background:rgba(249,180,15,.06);border-color:rgba(249,180,15,.2);transform:translateX(2px);}
.feed-av{
  width:34px;height:34px;border-radius:10px;flex-shrink:0;
  background:linear-gradient(135deg,var(--v-md),var(--v-lt));
  border:1px solid rgba(249,180,15,.22);
  display:flex;align-items:center;justify-content:center;
  font-family:'Playfair Display',serif;font-size:.75rem;font-weight:900;color:var(--g);
}
.feed-name{font-size:.72rem;font-weight:600;color:var(--cream);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:160px;}
.feed-txn{font-family:monospace;font-size:.58rem;color:rgba(249,180,15,.45);margin-top:2px;}
.feed-time{font-size:.6rem;color:var(--dim);margin-top:2px;}
.feed-status{width:7px;height:7px;border-radius:50%;background:var(--green);box-shadow:0 0 8px rgba(34,197,94,.7);flex-shrink:0;margin-top:4px;}

.feed-footer{border-top:1px solid var(--b2);padding:10px 14px;flex-shrink:0;}
.btn-all{
  display:flex;align-items:center;justify-content:center;gap:6px;
  width:100%;padding:9px;border-radius:10px;text-decoration:none;
  background:rgba(249,180,15,.07);border:1px solid rgba(249,180,15,.2);
  color:var(--g);
  font-family:'Barlow Condensed',sans-serif;
  font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;
  transition:all .22s;
}
.btn-all:hover{background:rgba(249,180,15,.15);border-color:rgba(249,180,15,.4);transform:translateY(-1px);}

/* Team card */
.team-panel{padding:18px 20px 14px;}
.m-item{display:flex;align-items:center;gap:12px;padding:9px 8px;border-radius:12px;transition:background .2s;cursor:default;}
.m-item:hover{background:rgba(249,180,15,.05);}
.m-av{
  width:36px;height:36px;border-radius:11px;flex-shrink:0;
  display:flex;align-items:center;justify-content:center;
  font-family:'Playfair Display',serif;font-size:.78rem;font-weight:900;
  background:linear-gradient(135deg,var(--v-md),var(--v-lt));
  border:1px solid rgba(249,180,15,.22);color:var(--g);
  position:relative;
}
.m-av::after{
  content:'';position:absolute;bottom:-2px;right:-2px;
  width:9px;height:9px;border-radius:50%;
  background:var(--green);border:2px solid var(--ink);
  box-shadow:0 0 6px rgba(34,197,94,.6);
}
.m-name{font-size:.73rem;font-weight:600;color:var(--cream);}
.m-role{font-family:'Barlow Condensed',sans-serif;font-size:.6rem;font-weight:600;letter-spacing:.06em;text-transform:uppercase;color:rgba(249,180,15,.45);margin-top:1px;}

/* Leaderboard */
.lb-panel{padding:18px 20px 14px;}
.lb-item{
  display:flex;align-items:center;gap:12px;
  padding:12px 10px;border-radius:12px;
  transition:all .2s;position:relative;overflow:hidden;
}
.lb-item:hover{background:rgba(249,180,15,.04);}
.lb-item + .lb-item{border-top:1px solid var(--b2);}
.lb-rank{
  font-family:'Playfair Display',serif;
  font-size:.9rem;font-weight:900;width:22px;text-align:center;flex-shrink:0;
  color:var(--dim);
}
.lb-rank.r1{
  background:linear-gradient(135deg,var(--g),var(--g-lt));
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
  font-size:1.1rem;
}
.lb-rank.r2{color:rgba(255,251,240,.4);}
.lb-rank.r3{color:#c97d3a;}
.lb-av{
  width:40px;height:40px;border-radius:12px;flex-shrink:0;
  background:linear-gradient(135deg,var(--v-md),var(--v-lt));
  border:1px solid rgba(249,180,15,.18);
  display:flex;align-items:center;justify-content:center;
  font-family:'Playfair Display',serif;font-size:.85rem;font-weight:900;color:var(--g);
}
.lb-name{font-size:.73rem;font-weight:600;color:var(--cream);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.lb-pos{font-family:'Barlow Condensed',sans-serif;font-size:.6rem;font-weight:600;letter-spacing:.05em;text-transform:uppercase;color:var(--dim);margin-top:2px;}
.lb-prog{height:2px;border-radius:99px;background:rgba(249,180,15,.08);margin-top:6px;}
.lb-fill{height:100%;border-radius:99px;background:linear-gradient(90deg,var(--g),rgba(249,180,15,.3));transition:width 1s;}
.lb-votes{
  font-family:'Playfair Display',serif;
  font-size:1.05rem;font-weight:900;flex-shrink:0;text-align:right;
  background:linear-gradient(135deg,var(--g),var(--g-lt));
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.lb-pct{font-family:'Barlow Condensed',sans-serif;font-size:.58rem;color:var(--dim);text-align:right;margin-top:2px;}

/* System health */
.sys-panel{padding:18px 20px;}
.sys-ring-wrap{width:100px;height:100px;margin:14px auto 10px;position:relative;}
.sys-ring-wrap svg{transform:rotate(-90deg);}
.sys-center{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;}
.sys-pct{font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:900;background:linear-gradient(135deg,var(--g),var(--g-lt));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.sys-word{font-family:'Barlow Condensed',sans-serif;font-size:.58rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--green);margin-top:2px;}
.sys-row{display:flex;align-items:center;gap:8px;margin-top:9px;}
.sys-lbl{font-family:'Barlow Condensed',sans-serif;font-size:.62rem;font-weight:600;letter-spacing:.05em;text-transform:uppercase;color:var(--dim);flex:none;width:62px;}
.sys-track{flex:1;height:3px;background:rgba(249,180,15,.08);border-radius:99px;}
.sys-fill{height:100%;border-radius:99px;background:linear-gradient(90deg,var(--g),var(--g-lt));transition:width .8s;}
.sys-val{font-family:'Barlow Condensed',sans-serif;font-size:.65rem;font-weight:700;color:var(--g);flex:none;}

/* Divider util */
.hdiv{border-top:1px solid var(--b2);margin-top:10px;padding-top:10px;display:flex;justify-content:space-between;align-items:center;}
.link-gold{font-family:'Barlow Condensed',sans-serif;font-size:.65rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:var(--g);text-decoration:none;transition:color .2s;}
.link-gold:hover{color:var(--g-lt);}
</style>

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

    {{-- Big focal turnout number --}}
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
      {{-- Mini sparkline --}}
      <div class="sparkline">
        @for($s=0;$s<8;$s++)
        <div class="spark-bar {{ $s===7?'active':'' }}" style="height:{{ rand(20,100) }}%;"></div>
        @endfor
      </div>
    </div>
    @endforeach

    {{-- Large votes+voters featured tile --}}
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

    {{-- Line chart --}}
    <div class="gs" style="overflow:hidden;">
      <div class="panel-head">
        <div><div class="panel-eye">Today</div><div class="panel-title">Voters per Hour</div></div>
        <span style="font-size:.6rem;color:var(--dim);">UTC+8</span>
      </div>
      <div class="chart-wrap">
        <div style="height:140px;position:relative;"><canvas id="chartLine"></canvas></div>
      </div>
    </div>

    {{-- Bar chart --}}
    <div class="gs" style="overflow:hidden;">
      <div class="panel-head">
        <div><div class="panel-eye">Breakdown</div><div class="panel-title">Votes by Position</div></div>
      </div>
      <div class="chart-wrap">
        <div style="height:140px;position:relative;"><canvas id="chartBar"></canvas></div>
      </div>
    </div>

    {{-- Doughnut + legend --}}
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

    {{-- Activity Feed --}}
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

    {{-- Team + System --}}
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
      {{-- System mini metrics --}}
      <div style="padding:0 20px 18px;border-top:1px solid var(--b2);margin-top:0;padding-top:14px;">
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

    {{-- Leaderboard --}}
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

  // ── Line chart ──
  const cL = document.getElementById('chartLine').getContext('2d');
  const lg = cL.createLinearGradient(0,0,0,140);
  lg.addColorStop(0,'rgba(249,180,15,.28)');
  lg.addColorStop(1,'rgba(249,180,15,.01)');
  const lineChart = new Chart(cL,{
    type:'line',
    data:{labels:[],datasets:[{label:'Voters',data:[],borderColor:'#f9b40f',backgroundColor:lg,borderWidth:2.5,fill:true,tension:.44,pointBackgroundColor:'#f9b40f',pointBorderColor:'rgba(14,0,19,.9)',pointBorderWidth:2,pointRadius:3.5,pointHoverRadius:6}]},
    options:{responsive:true,maintainAspectRatio:false,animation:{duration:500},plugins:{legend:{display:false},tooltip:tip},scales:{x:{grid:grd,border:{display:false},ticks:{...tck,maxTicksLimit:8}},y:{grid:grd,border:{display:false},ticks:{...tck,maxTicksLimit:4},beginAtZero:true}}}
  });

  // ── Bar chart ──
  const cB = document.getElementById('chartBar').getContext('2d');
  const barChart = new Chart(cB,{
    type:'bar',
    data:{labels:[],datasets:[{label:'Votes',data:[],backgroundColor:'rgba(249,180,15,.55)',borderColor:'rgba(249,180,15,.9)',borderWidth:1,borderRadius:{topLeft:5,topRight:5},borderSkipped:false,barPercentage:.5}]},
    options:{responsive:true,maintainAspectRatio:false,animation:{duration:500},plugins:{legend:{display:false},tooltip:tip},scales:{x:{grid:grd,border:{display:false},ticks:{...tck,maxTicksLimit:6}},y:{grid:grd,border:{display:false},ticks:{...tck,maxTicksLimit:4},beginAtZero:true}}}
  });

  // ── Doughnut ──
  const cD = document.getElementById('chartDonut').getContext('2d');
  const donutChart = new Chart(cD,{
    type:'doughnut',
    data:{labels:['Voted','Not Yet'],datasets:[{data:[{{ $votedCount }},{{ $notVoted > 0 ? $notVoted : ($votedCount > 0 ? 0 : 1) }}],backgroundColor:['rgba(249,180,15,.88)','rgba(56,0,65,.75)'],borderColor:['rgba(249,180,15,.5)','rgba(249,180,15,.07)'],borderWidth:2,hoverOffset:8}]},
    options:{responsive:false,maintainAspectRatio:false,cutout:'66%',animation:{duration:900},plugins:{legend:{display:false},tooltip:tip}}
  });

  // ── Animate counter ──
  function animN(el,to){
    if(!el) return;
    const isF=el.textContent.includes('%');
    const from=parseFloat(el.textContent.replace(/[^0-9.]/g,''))||0;
    if(Math.abs(from-to)<.5) return;
    const steps=22,dur=450;let s=0;
    const t=setInterval(()=>{s++;const v=from+(to-from)*(s/steps);el.textContent=isF?v.toFixed(1)+'%':Math.round(v).toLocaleString();if(s>=steps){el.textContent=isF?to.toFixed(1)+'%':to.toLocaleString();clearInterval(t);}},dur/steps);
  }

  // ── Mini feed in large tile ──
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

  // ── Full feed ──
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

  // ── Leaderboard ──
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

  // ── Live poll ──
  async function poll(){
    try{
      const r=await fetch('{{ route('admin.dashboard.live') }}',{headers:{'Accept':'application/json','X-Requested-With':'XMLHttpRequest'}});
      if(!r.ok) return;
      const d=await r.json();

      // Stat tiles
      const map={'st-voters':d.stats.total_voters,'st-votes':d.stats.total_votes,'st-cands':d.stats.total_candidates,'st-pos':d.stats.total_positions,'st-party':d.stats.total_partylists,'st-colleges':d.stats.total_colleges,'st-orgs':d.stats.total_orgs};
      Object.entries(map).forEach(([id,v])=>animN(document.getElementById(id),v));

      const {voted,not_voted}=d.turnout;
      const total=voted+not_voted;
      const pct=total>0?parseFloat(((voted/total)*100).toFixed(1)):0;
      const nPct=parseFloat((100-pct).toFixed(1));

      // Header hero
      const thEl=document.getElementById('th-pct'); if(thEl) thEl.textContent=pct.toFixed(1)+'%';
      const thV=document.getElementById('th-voted'); if(thV) thV.textContent=voted.toLocaleString();
      const thT=document.getElementById('th-total'); if(thT) thT.textContent=d.stats.total_voters.toLocaleString();
      const thB=document.getElementById('th-bar-fill'); if(thB) thB.style.width=pct+'%';

      // Donut panel
      const dpEl=document.getElementById('donut-pct'); if(dpEl) dpEl.textContent=pct.toFixed(1)+'%';
      const dlV=document.getElementById('dl-voted'); if(dlV) dlV.textContent=pct.toFixed(1)+'%';
      const dlP=document.getElementById('dl-pend');  if(dlP) dlP.textContent=nPct.toFixed(1)+'%';
      const stV=document.getElementById('still-val'); if(stV) stV.textContent=not_voted.toLocaleString();

      // Large tile
      animN(document.getElementById('st-remaining'),not_voted);
      const ppEl=document.getElementById('part-pct'); if(ppEl) ppEl.textContent=pct.toFixed(1)+'%';
      const pbEl=document.getElementById('part-bar'); if(pbEl) pbEl.style.width=pct+'%';

      // Ticker
      const tkS=document.getElementById('tk-status'); if(tkS) tkS.textContent=d.stats.total_votes>0?'Ongoing':'Upcoming';
      const tkVo=document.getElementById('tk-voters'); if(tkVo) tkVo.textContent=d.stats.total_voters.toLocaleString();
      const tkVt=document.getElementById('tk-votes');  if(tkVt) tkVt.textContent=d.stats.total_votes.toLocaleString();
      const tkTu=document.getElementById('tk-turnout');if(tkTu) tkTu.textContent=pct.toFixed(1)+'%';

      // Charts
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