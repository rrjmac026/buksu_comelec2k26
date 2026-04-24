@extends('layouts.public-site', ['title' => 'How It Works | BukSU COMELEC', 'activePage' => 'how'])

@section('content')
    <section class="public-page-shell">
        <header class="page-header reveal">
            <h1 class="page-title">How the Voting System Works</h1>
            <p class="page-subtitle">Simple, secure, and transparent voting in just a few steps.</p>
        </header>

        <div class="steps-grid">
            <article class="glass-card step-card reveal lift-hover">
                <span class="step-num">1</span>
                <h3 class="step-title">Login Securely</h3>
                <p class="step-desc">Access using your student credentials.</p>
            </article>
            <article class="glass-card step-card reveal lift-hover">
                <span class="step-num">2</span>
                <h3 class="step-title">Verify Identity</h3>
                <p class="step-desc">Ensure only eligible voters participate.</p>
            </article>
            <article class="glass-card step-card reveal lift-hover">
                <span class="step-num">3</span>
                <h3 class="step-title">Cast Your Vote</h3>
                <p class="step-desc">Select candidates and review your ballot.</p>
            </article>
            <article class="glass-card step-card reveal lift-hover">
                <span class="step-num">4</span>
                <h3 class="step-title">Submit Ballot</h3>
                <p class="step-desc">Your vote is encrypted and stored securely.</p>
            </article>
            <article class="glass-card step-card reveal lift-hover">
                <span class="step-num">5</span>
                <h3 class="step-title">View Results</h3>
                <p class="step-desc">Results are generated transparently after voting ends.</p>
            </article>
        </div>

        <div class="features-grid">
            <article class="glass-card feature-card reveal lift-hover">
                <div class="feature-icon"><i class="fas fa-lock"></i></div>
                <h4 style="margin:0;">Secure Voting</h4>
            </article>
            <article class="glass-card feature-card reveal lift-hover">
                <div class="feature-icon"><i class="fas fa-bolt"></i></div>
                <h4 style="margin:0;">Real-Time Results</h4>
            </article>
            <article class="glass-card feature-card reveal lift-hover">
                <div class="feature-icon"><i class="fas fa-file-lines"></i></div>
                <h4 style="margin:0;">Transparent Process</h4>
            </article>
            <article class="glass-card feature-card reveal lift-hover">
                <div class="feature-icon"><i class="fas fa-user-secret"></i></div>
                <h4 style="margin:0;">Anonymous Ballots</h4>
            </article>
        </div>
    </section>
@endsection
