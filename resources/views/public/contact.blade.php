@extends('layouts.public-site', ['title' => 'Contact | BukSU COMELEC', 'activePage' => 'contact'])

@section('content')
    <section class="public-page-shell">
        <header class="page-header reveal">
            <h1 class="page-title">Get in Touch</h1>
            <p class="page-subtitle">We&rsquo;re here to assist you with any concerns.</p>
        </header>

        <div class="contact-layout">
            <article class="glass-card contact-panel reveal lift-hover">
                <h2 style="margin-top:0;">Contact Information</h2>
                <div class="contact-list" style="margin-top:12px;">
                    <div>
                        <div class="contact-label">Organization</div>
                        <div class="contact-value">BukSU COMELEC</div>
                    </div>
                    <div>
                        <div class="contact-label">Email</div>
                        <div class="contact-value">comelec@buksu.edu.ph</div>
                    </div>
                    <div>
                        <div class="contact-label">Location</div>
                        <div class="contact-value">Bukidnon State University</div>
                    </div>
                    <div>
                        <div class="contact-label">Office Hours</div>
                        <div class="contact-value">Mon-Fri | 8:00 AM - 5:00 PM</div>
                    </div>
                </div>
            </article>

            <article class="glass-card contact-panel reveal lift-hover">
                <h2 style="margin-top:0;">Send a Message</h2>
                <form class="form-grid" data-contact-form style="margin-top:12px;">
                    <div class="form-field">
                        <label for="full_name">Full Name</label>
                        <input id="full_name" name="full_name" type="text" data-required>
                    </div>
                    <div class="form-field">
                        <label for="email_address">Email Address</label>
                        <input id="email_address" name="email_address" type="email" data-required>
                    </div>
                    <div class="form-field">
                        <label for="subject">Subject</label>
                        <input id="subject" name="subject" type="text" data-required>
                    </div>
                    <div class="form-field">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" data-required></textarea>
                    </div>
                    <div>
                        <button type="submit" class="btn-primary">Send Message</button>
                    </div>
                </form>
            </article>
        </div>
    </section>
@endsection
