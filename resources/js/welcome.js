// ═══════════════════════════════════════════
//  WELCOME PAGE — resources/js/welcome.js
// ═══════════════════════════════════════════

// ── Theme policy: dark-only ──────────────────────────────────
localStorage.setItem('theme', 'dark');
document.documentElement.classList.add('dark');

// ── Smooth scroll utility (global) ─────────────────────────
window.smoothScrollTo = function (sectionId) {
    const el = document.getElementById(sectionId);
    if (!el) return;
    const navH = document.getElementById('site-nav')?.offsetHeight ?? 68;
    const top  = el.getBoundingClientRect().top + window.scrollY - navH;
    window.scrollTo({ top, behavior: 'smooth' });
};

document.addEventListener('DOMContentLoaded', () => {

    // ── Team cards reveal animation ─────────────────────────
    const animateCards = (selector, cls = 'is-visible') => {
        const cards = document.querySelectorAll(selector);
        if (!cards.length) return;
        if (!('IntersectionObserver' in window)) {
            cards.forEach((c) => c.classList.add(cls));
            return;
        }
        const obs = new IntersectionObserver(
            (entries, o) => {
                entries.forEach((e) => {
                    if (!e.isIntersecting) return;
                    e.target.classList.add(cls);
                    o.unobserve(e.target);
                });
            },
            { threshold: 0.12, rootMargin: '0px 0px -30px 0px' }
        );
        cards.forEach((c) => obs.observe(c));
    };

    animateCards('.team-card-animate');

    // ── Section reveal (.ls-reveal) ────────────────────────
    animateCards('.ls-reveal');

    // ── Active nav link via IntersectionObserver ────────────
    const sections   = ['home', 'about', 'election', 'how-it-works', 'meet-the-team', 'contact'];
    const navLinks   = document.querySelectorAll('.nav-link[data-section]');
    const mobileLinks = document.querySelectorAll('.mobile-nav-link[data-section]');

    function setActiveSection(id) {
        navLinks.forEach((a) => {
            a.classList.toggle('is-active', a.dataset.section === id);
        });
        mobileLinks.forEach((a) => {
            a.classList.toggle('is-active', a.dataset.section === id);
        });
    }

    if ('IntersectionObserver' in window) {
        const navH = document.getElementById('site-nav')?.offsetHeight ?? 68;

        const sectionObs = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        setActiveSection(entry.target.id);
                    }
                });
            },
            {
                rootMargin: `-${navH + 20}px 0px -55% 0px`,
                threshold: 0,
            }
        );

        sections.forEach((id) => {
            const el = document.getElementById(id);
            if (el) sectionObs.observe(el);
        });
    }

    // ── Intercept anchor nav links for smooth scroll ────────
    document.querySelectorAll('a[href^="#"]').forEach((a) => {
        a.addEventListener('click', (e) => {
            const target = a.getAttribute('href').replace('#', '');
            if (!target || !document.getElementById(target)) return;
            e.preventDefault();
            window.smoothScrollTo(target);
            // Close mobile drawer if open
            closeMobileDrawer();
        });
    });

    // ── Mobile hamburger menu ───────────────────────────────
    const hamburger  = document.getElementById('nav-hamburger');
    const drawer     = document.getElementById('mobile-drawer');

    function closeMobileDrawer() {
        if (!drawer || !hamburger) return;
        drawer.classList.remove('is-open');
        hamburger.classList.remove('is-open');
        hamburger.setAttribute('aria-expanded', 'false');
        drawer.setAttribute('aria-hidden', 'true');
    }

    if (hamburger && drawer) {
        hamburger.addEventListener('click', () => {
            const isOpen = drawer.classList.toggle('is-open');
            hamburger.classList.toggle('is-open', isOpen);
            hamburger.setAttribute('aria-expanded', String(isOpen));
            drawer.setAttribute('aria-hidden', String(!isOpen));
        });

        // Close on outside click
        document.addEventListener('click', (e) => {
            if (
                drawer.classList.contains('is-open') &&
                !drawer.contains(e.target) &&
                !hamburger.contains(e.target)
            ) {
                closeMobileDrawer();
            }
        });

        // Close on Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeMobileDrawer();
        });
    }

});
