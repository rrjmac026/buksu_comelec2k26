// ═══════════════════════════════════════════
//  WELCOME PAGE — resources/js/welcome.js
// ═══════════════════════════════════════════

// ── Dark mode (Alpine) ──
if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
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
        }
    });
});

// ── Team slider ──
document.addEventListener('DOMContentLoaded', () => {
    const total   = 3;
    let current   = 0;
    let autoTimer;

    function getSlideH() {
        if (window.innerWidth <= 480) return 360;
        if (window.innerWidth <= 768) return 380;
        return 400;
    }

    let SLIDE_H = getSlideH();

    const strip   = document.getElementById('strip');
    const dotsEl  = document.getElementById('dots');
    const counter = document.getElementById('counter');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const pbar    = document.getElementById('pbar');

    if (!strip) return; // not on welcome page

    window.addEventListener('resize', () => {
        SLIDE_H = getSlideH();
        strip.style.transition = 'none';
        strip.style.transform  = `translateY(-${current * SLIDE_H}px)`;
    });

    // Build dots
    for (let i = 0; i < total; i++) {
        const d = document.createElement('div');
        d.className = 'dot' + (i === 0 ? ' active' : '');
        d.onclick = () => { goTo(i); resetAuto(); };
        dotsEl.appendChild(d);
    }

    function goTo(idx) {
        current = (idx + total) % total;
        strip.style.transform = `translateY(-${current * SLIDE_H}px)`;
        document.querySelectorAll('.dot').forEach((d, i) => d.classList.toggle('active', i === current));
        counter.textContent   = `${current + 1} / ${total}`;
        prevBtn.disabled      = current === 0;
        nextBtn.disabled      = current === total - 1;
        startProgress();
    }

    // Expose go() globally so inline onclick="go(-1)" still works
    window.go = (dir) => { goTo(current + dir); resetAuto(); };

    function startProgress() {
        pbar.style.transition = 'none';
        pbar.style.width      = '0%';
        requestAnimationFrame(() => requestAnimationFrame(() => {
            pbar.style.transition = 'width 4s linear';
            pbar.style.width      = '100%';
        }));
    }

    function resetAuto() {
        clearInterval(autoTimer);
        autoTimer = setInterval(() => {
            goTo(current < total - 1 ? current + 1 : 0);
        }, 4000);
    }

    setTimeout(() => { resetAuto(); startProgress(); }, 1500);
});

// ── Live votes stat ──
(function () {
    const el = document.getElementById('stat-votes-cast');
    if (!el) return;

    let prev = null;

    function fetchStats() {
        fetch('/public/stats')
            .then(r => r.json())
            .then(d => {
                const v = d.votes_cast ?? 0;
                if (v !== prev) { el.textContent = v.toLocaleString(); prev = v; }
            })
            .catch(() => {});
    }

    fetchStats();
    setInterval(fetchStats, 15000);
})();