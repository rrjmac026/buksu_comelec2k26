const toastStack = document.getElementById('toast-stack');

window.showPublicToast = function showPublicToast(message, type = 'success') {
    if (!toastStack) return;
    const toast = document.createElement('div');
    toast.className = `toast ${type === 'error' ? 'error' : ''}`.trim();
    toast.textContent = message;
    toastStack.appendChild(toast);
    setTimeout(() => toast.remove(), 3200);
};

function initReveal() {
    const revealEls = document.querySelectorAll('.reveal');
    if (!revealEls.length) return;

    if (!('IntersectionObserver' in window)) {
        revealEls.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('is-visible');
            obs.unobserve(entry.target);
        });
    }, { threshold: 0.16, rootMargin: '0px 0px -24px 0px' });

    revealEls.forEach((el) => observer.observe(el));
}

function initLiveBadge() {
    const badge = document.getElementById('global-live-badge');
    if (!badge) return;

    fetch('/public/stats', { headers: { Accept: 'application/json' }, cache: 'no-store' })
        .then((res) => res.json())
        .then((data) => {
            if (data.status === 'ongoing') badge.classList.add('is-live');
        })
        .catch(() => {});
}

function initElectionPage() {
    const wrapper = document.querySelector('[data-election-page]');
    if (!wrapper) return;

    const voteBtn = document.getElementById('vote-now-btn');
    const voteHint = document.getElementById('vote-btn-hint');
    const votesEl = document.getElementById('election-votes');
    const totalEl = document.getElementById('election-total');
    const statusLabel = document.getElementById('election-status-label');
    const statusHint = document.getElementById('election-status-hint');
    const progressFill = document.getElementById('election-progress-fill');
    const progressPct = document.getElementById('election-progress-pct');
    const statusIcon = document.getElementById('election-status-icon');

    function applyStatus(data) {
        const status = data.status || 'upcoming';
        const votes = Number(data.votes_cast ?? 0);
        const total = Number(data.total_voters ?? 7967) || 7967;

        if (votesEl) votesEl.textContent = votes.toLocaleString();
        if (totalEl) totalEl.textContent = total.toLocaleString();

        let label = 'Election Soon';
        let hint = 'Voting has not started yet';
        let pct = 0;
        let canVote = false;
        let iconClass = 'fa-hourglass-start';

        if (status === 'ongoing') {
            label = 'Election is LIVE';
            hint = 'Voting is currently in progress';
            pct = Math.min(100, Math.round((votes / total) * 100));
            canVote = true;
            iconClass = 'fa-circle-dot';
        } else if (status === 'ended') {
            label = 'Election Ended';
            hint = 'Voting has officially closed';
            pct = 100;
            iconClass = 'fa-flag-checkered';
        }

        if (statusLabel) statusLabel.textContent = label;
        if (statusHint) statusHint.textContent = hint;
        if (progressFill) progressFill.style.width = `${pct}%`;
        if (progressPct) progressPct.textContent = `${pct}%`;
        if (statusIcon) statusIcon.className = `fas ${iconClass}`;

        if (!voteBtn) return;
        if (!canVote) {
            voteBtn.disabled = true;
            voteBtn.setAttribute('title', 'Voting will be available once the election starts');
            if (voteHint) voteHint.textContent = 'Voting will be available once the election starts';
        } else {
            voteBtn.disabled = false;
            voteBtn.removeAttribute('title');
            if (voteHint) voteHint.textContent = 'Voting is now available.';
        }
    }

    fetch('/public/stats', { headers: { Accept: 'application/json' }, cache: 'no-store' })
        .then((res) => res.json())
        .then((data) => applyStatus(data))
        .catch(() => applyStatus({}));

    if (!voteBtn) return;
    voteBtn.addEventListener('click', (event) => {
        if (!voteBtn.disabled) return;
        event.preventDefault();
        window.showPublicToast('Voting Not Yet Started', 'error');
    });
}

function initContactPage() {
    const form = document.querySelector('[data-contact-form]');
    if (!form) return;

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const requiredFields = form.querySelectorAll('[data-required]');
        let hasError = false;

        requiredFields.forEach((field) => {
            const wrapper = field.closest('.form-field');
            if (!field.value.trim()) {
                hasError = true;
                wrapper?.classList.add('is-error');
            } else {
                wrapper?.classList.remove('is-error');
            }
        });

        if (hasError) {
            window.showPublicToast('Please complete all required fields', 'error');
            return;
        }

        form.reset();
        window.showPublicToast('Message sent successfully');
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initReveal();
    initLiveBadge();
    initElectionPage();
    initContactPage();
});
