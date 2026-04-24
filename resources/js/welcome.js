// ═══════════════════════════════════════════
//  WELCOME PAGE — resources/js/welcome.js
// ═══════════════════════════════════════════

// ── Dark mode (Alpine) ──
if (
    localStorage.theme === 'dark' ||
    (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
) {
    document.documentElement.classList.add('dark');
}

document.addEventListener('alpine:init', () => {
    Alpine.store('darkMode', {
        init() {
            this.on = localStorage.getItem('theme') === 'dark';
            document.documentElement.classList.toggle('dark', this.on);
        },
        on: false,
        toggle() {
            this.on = !this.on;
            localStorage.setItem('theme', this.on ? 'dark' : 'light');
            document.documentElement.classList.toggle('dark', this.on);
        },
    });
});

// ── Team cards reveal animation ──
document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.team-card-animate');
    if (!cards.length) return;

    if (!('IntersectionObserver' in window)) {
        cards.forEach((card) => card.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries, obs) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                obs.unobserve(entry.target);
            });
        },
        { root: null, threshold: 0.15, rootMargin: '0px 0px -30px 0px' }
    );

    cards.forEach((card) => observer.observe(card));
});
