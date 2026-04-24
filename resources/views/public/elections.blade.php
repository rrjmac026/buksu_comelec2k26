@extends('layouts.public-site', ['title' => 'Elections | BukSU COMELEC', 'activePage' => 'elections'])

@section('content')
    <section class="public-page-shell" data-election-page>
        <header class="page-header reveal">
            <h1 class="page-title">Student Government Elections</h1>
            <p class="page-subtitle">Participate in secure, transparent, and reliable digital elections.</p>
        </header>

        <div class="elections-layout">
            <article class="glass-card elections-left reveal lift-hover">
                <h2 style="margin-top:0;">Election Overview</h2>
                <div class="meta-grid" style="margin-top:14px;">
                    <div class="meta-item">
                        <div class="meta-label">Election Name</div>
                        <div class="meta-value">BukSU Student Government Election 2026</div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">Status</div>
                        <div class="meta-value">Upcoming</div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">Voting Date</div>
                        <div class="meta-value">April 25, 2026</div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">Eligibility</div>
                        <div class="meta-value">All enrolled students</div>
                    </div>
                </div>

                <div class="cta-inline">
                    <div>
                        <strong>Make your voice count</strong>
                        <div class="cta-note">in shaping your organization&rsquo;s future.</div>
                    </div>
                    <a href="{{ route('login') }}" class="btn-primary" id="vote-now-btn" title="Voting will be available once the election starts">Vote Now</a>
                </div>
                <div class="cta-note" id="vote-btn-hint" style="margin-top: 10px;">Voting will be available once the election starts</div>
            </article>

            <aside class="glass-card elections-right reveal lift-hover">
                <div class="status-chip">LIVE ELECTION STATUS</div>
                <h3 style="margin:14px 0 8px;font-family:'Playfair Display',Georgia,serif;font-size:1.7rem;">Student Government Election</h3>
                <div style="display:flex;align-items:center;gap:10px;">
                    <i class="fas fa-hourglass-start" id="election-status-icon" style="color:#facc15;"></i>
                    <strong id="election-status-label">Election Soon</strong>
                </div>
                <p class="page-subtitle" id="election-status-hint" style="text-align:left;margin-top:8px;">Voting has not started yet</p>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin:16px 0;">
                    <div class="meta-item">
                        <div class="meta-label">Votes Cast</div>
                        <div class="meta-value" id="election-votes">0</div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">Total Voters</div>
                        <div class="meta-value" id="election-total">7,967</div>
                    </div>
                </div>

                <div class="meta-label" style="margin-bottom:6px;">Progress <span id="election-progress-pct">0%</span></div>
                <div class="progress-track">
                    <div class="progress-fill" id="election-progress-fill"></div>
                </div>

                <a href="{{ route('login') }}" class="btn-primary" style="display:inline-block;margin-top:18px;text-decoration:none;">View Election Details</a>
            </aside>
        </div>
    </section>
@endsection
