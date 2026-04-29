<div id="voter-walkthrough"
     class="vw-root"
     aria-hidden="true"
     data-server-completed="{{ auth()->user()?->walkthrough_completed_at ? '1' : '0' }}"
     data-complete-url="{{ route('voter.walkthrough.complete') }}">
    <div class="vw-overlay-layer" aria-hidden="true">
        <div class="vw-overlay-piece vw-overlay-top" id="vw-overlay-top"></div>
        <div class="vw-overlay-piece vw-overlay-left" id="vw-overlay-left"></div>
        <div class="vw-overlay-piece vw-overlay-right" id="vw-overlay-right"></div>
        <div class="vw-overlay-piece vw-overlay-bottom" id="vw-overlay-bottom"></div>
        <div class="vw-cutout-ring" id="vw-cutout-ring"></div>
    </div>
    <div class="vw-tooltip" role="dialog" aria-modal="true" aria-label="Voter walkthrough">
        <div class="vw-sheet-grab" aria-hidden="true"></div>
        <button type="button" class="vw-close-btn" id="vw-close" aria-label="Close walkthrough">
            <i class="fas fa-xmark"></i>
        </button>
        <div class="vw-step-content" id="vw-step-content">
            <div class="vw-step-label" id="vw-step-label">Step 1</div>
            <div class="vw-dots" id="vw-dots" aria-hidden="true"></div>
            <h3 class="vw-title" id="vw-title"></h3>
            <p class="vw-text" id="vw-text"></p>
        </div>
        <label class="vw-dont-show">
            <input type="checkbox" id="vw-dont-show-checkbox">
            <span>Don't show again</span>
        </label>
        <div class="vw-actions">
            <div class="vw-nav-actions">
                <button type="button" class="vw-btn vw-btn-secondary" id="vw-back">Back</button>
                <button type="button" class="vw-btn vw-btn-primary" id="vw-next">Next</button>
            </div>
            <button type="button" class="vw-btn vw-btn-ghost" id="vw-skip">Skip walkthrough</button>
        </div>
        <div class="vw-pointer" id="vw-pointer" aria-hidden="true"></div>
    </div>
</div>

<style>
    body.vw-active {
        padding-bottom: 0;
    }

    .vw-root {
        position: fixed;
        inset: 0;
        z-index: 120000;
        display: none;
    }
    .vw-root.is-open {
        display: block;
        animation: vw-fade-in .3s ease;
    }
    .vw-overlay-layer {
        position: fixed;
        inset: 0;
        pointer-events: none;
        z-index: 120000;
    }
    .vw-overlay-piece {
        position: absolute;
        background: rgba(10, 5, 30, 0.55);
        pointer-events: none;
    }
    .vw-cutout-ring {
        position: absolute;
        border-radius: 14px;
        border: 1px solid rgba(249, 180, 15, 0.32);
        box-shadow: 0 0 0 1px rgba(255, 233, 171, 0.12) inset;
        pointer-events: none;
        opacity: 0;
        transition: all .25s ease;
    }
    .vw-tooltip {
        position: fixed;
        top: 96px;
        right: 24px;
        width: min(400px, calc(100vw - 24px));
        border-radius: 18px;
        border: 1px solid rgba(249, 180, 15, 0.24);
        background: linear-gradient(145deg, #1A0B2E, #2A0F4A);
        box-shadow: 0 0 28px rgba(249, 180, 15, 0.14), 0 14px 36px rgba(8, 0, 20, 0.4);
        padding: 22px;
        color: #fffbf0;
        pointer-events: auto;
        animation: vw-slide-up .3s ease;
        transform-origin: top left;
        z-index: 120004;
    }
    .vw-sheet-grab { display: none; }
    .vw-close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 26px;
        height: 26px;
        border-radius: 999px;
        border: 1px solid rgba(249, 180, 15, 0.22);
        background: rgba(255, 251, 240, 0.06);
        color: rgba(255, 251, 240, 0.85);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all .2s ease;
    }
    .vw-close-btn:hover {
        border-color: rgba(249, 180, 15, 0.45);
        color: #fcd558;
    }
    .vw-tooltip[data-side="left"] { transform-origin: top right; }
    .vw-tooltip[data-side="top"] { transform-origin: bottom left; }
    .vw-tooltip[data-side="bottom"] { transform-origin: top left; }
    .vw-pointer {
        position: absolute;
        width: 12px;
        height: 12px;
        background: #2A0F4A;
        transform: rotate(45deg);
        border: 1px solid rgba(249, 180, 15, 0.24);
        box-shadow: 0 0 12px rgba(249, 180, 15, 0.14);
    }
    .vw-tooltip[data-side="right"] .vw-pointer {
        left: -7px;
        top: 24px;
        border-top: 0;
        border-right: 0;
    }
    .vw-tooltip[data-side="left"] .vw-pointer {
        right: -7px;
        top: 24px;
        border-bottom: 0;
        border-left: 0;
    }
    .vw-tooltip[data-side="top"] .vw-pointer {
        left: 24px;
        bottom: -7px;
        border-top: 0;
        border-left: 0;
    }
    .vw-tooltip[data-side="bottom"] .vw-pointer {
        left: 24px;
        top: -7px;
        border-bottom: 0;
        border-right: 0;
    }
    .vw-step-label {
        font-size: .67rem;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: rgba(255, 251, 240, 0.62);
        font-weight: 700;
        margin-bottom: 10px;
    }
    .vw-dots {
        display: flex;
        gap: 7px;
        margin-bottom: 14px;
    }
    .vw-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(255, 251, 240, 0.25);
        transition: all .25s ease;
    }
    .vw-dot.active {
        background: #f9b40f;
        box-shadow: 0 0 8px rgba(249, 180, 15, 0.65);
    }
    .vw-title {
        margin: 0 0 10px;
        font-family: 'Playfair Display', serif;
        font-size: 1.13rem;
        color: #fcd558;
    }
    .vw-text {
        margin: 0;
        font-size: .84rem;
        line-height: 1.6;
        color: rgba(255,251,240,0.8);
    }
    .vw-step-content {
        transition: opacity .2s ease, transform .2s ease;
        will-change: opacity, transform;
    }
    .vw-step-content.is-switching {
        opacity: 0;
        transform: translateY(8px);
    }
    .vw-dont-show {
        margin-top: 16px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: .74rem;
        color: rgba(255,251,240,0.76);
        user-select: none;
    }
    .vw-dont-show input { accent-color: #f9b40f; }
    .vw-actions {
        margin-top: 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
    .vw-nav-actions {
        display: inline-flex;
        gap: 10px;
    }
    .vw-btn {
        border-radius: 12px;
        font-size: .78rem;
        font-weight: 700;
        padding: 10px 14px;
        min-height: 44px;
        cursor: pointer;
        transition: all .2s ease;
    }
    .vw-btn:disabled { opacity: .45; cursor: not-allowed; }
    .vw-btn-ghost {
        background: transparent;
        color: rgba(255,251,240,0.68);
        border: 1px solid transparent;
        min-height: 44px;
    }
    .vw-btn-secondary {
        background: rgba(249,180,15,0.06);
        color: #fcd558;
        border: 1px solid rgba(249,180,15,0.35);
    }
    .vw-btn-primary {
        background: linear-gradient(135deg, #f9b40f, #fcd558);
        color: #380041;
        border: 1px solid rgba(255, 230, 163, 0.6);
        box-shadow: 0 6px 20px rgba(249,180,15,0.35);
    }
    .vw-btn-primary.is-bounce { animation: vw-bounce .25s ease; }
    .vw-highlight {
        position: relative;
        z-index: 120003 !important;
        border-radius: 12px;
        transform: scale(1.01);
        box-shadow: 0 0 0 1px rgba(249,180,15,0.35);
        animation: vw-target-pulse 1.9s ease-in-out infinite;
    }
    @media (min-width: 768px) and (max-width: 1023px) {
        .vw-tooltip {
            top: 88px;
            right: auto;
            left: 50%;
            transform: translateX(-50%);
            width: min(520px, calc(100vw - 40px));
            border-radius: 18px;
            padding: 20px;
        }
        .vw-pointer { display: none; }
    }

    @media (max-width: 767px) {
        .vw-tooltip {
            top: auto;
            left: 12px;
            right: 12px;
            bottom: 12px;
            width: calc(100% - 24px);
            max-height: 45vh;
            overflow: auto;
            border-radius: 18px;
            padding: 14px 14px calc(14px + env(safe-area-inset-bottom));
            box-shadow: 0 -6px 18px rgba(8, 0, 20, 0.35);
            animation: vw-sheet-up .28s ease;
        }
        .vw-sheet-grab {
            display: block;
            width: 42px;
            height: 4px;
            border-radius: 999px;
            background: rgba(255, 251, 240, 0.35);
            margin: 2px auto 10px;
        }
        .vw-close-btn {
            top: 8px;
            right: 8px;
            width: 24px;
            height: 24px;
        }
        .vw-step-content { padding-right: 28px; }
        .vw-step-label { font-size: .6rem; margin-bottom: 6px; }
        .vw-dots { margin-bottom: 10px; }
        .vw-title { font-size: .95rem; margin-bottom: 6px; padding-right: 0; }
        .vw-text { font-size: .74rem; line-height: 1.45; }
        .vw-dont-show { margin-top: 10px; font-size: .68rem; }
        .vw-actions {
            margin-top: 12px;
            flex-direction: column;
            align-items: stretch;
            gap: 8px;
        }
        .vw-nav-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }
        #vw-back, #vw-next {
            width: 100%;
            justify-content: center;
            min-height: 46px;
        }
        #vw-skip {
            width: 100%;
            justify-content: center;
            min-height: 44px;
            font-size: .7rem;
            color: rgba(255,251,240,0.75);
        }
        .vw-btn { font-size: .74rem; }
        .vw-pointer { display: none; }
    }
    @keyframes vw-fade-in {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes vw-slide-up {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes vw-sheet-up {
        from { opacity: 0; transform: translateY(18px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes vw-target-pulse {
        0%, 100% { box-shadow: 0 0 0 1px rgba(249,180,15,0.28); }
        50% { box-shadow: 0 0 0 1px rgba(249,180,15,0.52); }
    }
    @keyframes vw-bounce {
        0% { transform: translateY(0); }
        50% { transform: translateY(-1px); }
        100% { transform: translateY(0); }
    }
</style>

<script>
    (function () {
        class VoterWalkthrough {
            constructor() {
                this.root = document.getElementById('voter-walkthrough');
                if (!this.root) return;

                this.stepLabel = document.getElementById('vw-step-label');
                this.dots = document.getElementById('vw-dots');
                this.title = document.getElementById('vw-title');
                this.text = document.getElementById('vw-text');
                this.stepContent = document.getElementById('vw-step-content');
                this.backBtn = document.getElementById('vw-back');
                this.nextBtn = document.getElementById('vw-next');
                this.skipBtn = document.getElementById('vw-skip');
                this.closeBtn = document.getElementById('vw-close');
                this.dontShowCheckbox = document.getElementById('vw-dont-show-checkbox');
                this.trigger = document.querySelector('[data-tour-trigger]');
                this.tooltip = this.root.querySelector('.vw-tooltip');
                this.overlayTop = document.getElementById('vw-overlay-top');
                this.overlayLeft = document.getElementById('vw-overlay-left');
                this.overlayRight = document.getElementById('vw-overlay-right');
                this.overlayBottom = document.getElementById('vw-overlay-bottom');
                this.cutoutRing = document.getElementById('vw-cutout-ring');

                this.storageKey = 'buksu.voterWalkthrough.completed';
                this.completeUrl = this.root.dataset.completeUrl;
                this.serverCompleted = this.root.dataset.serverCompleted === '1';
                this.index = 0;
                this.activeEls = [];
                this.isOpen = false;
                this.sidebarWasOpen = null;
                this.sidebarTouchedByWalkthrough = false;

                this.steps = [
                    {
                        title: 'Welcome to Your Voter Dashboard',
                        text: 'This is your voter dashboard. Here you can see the election status, your voting progress, and important election information.',
                        mobileText: 'This dashboard shows election status and your voting progress.',
                        selectors: ['[data-tour="welcome-card"]']
                    },
                    {
                        title: 'Cast Your Vote',
                        text: 'Click here to start voting. You will be guided through the ballot step by step before submitting your final vote.',
                        mobileText: 'Tap here to start guided voting, step by step.',
                        selectors: ['[data-tour="cast-vote-sidebar"]', '[data-tour="cast-vote-button"]']
                    },
                    {
                        title: 'Election Status',
                        text: 'This shows if voting is currently open or closed. You can only cast your vote while the election is live.',
                        mobileText: 'This shows if voting is open or closed.',
                        selectors: ['[data-tour="election-status"]']
                    },
                    {
                        title: 'Your Voter Details',
                        text: 'Review your student number, college, course, and year level here to make sure your voter details are correct.',
                        mobileText: 'Check your student details here for accuracy.',
                        selectors: ['[data-tour="voter-details"]']
                    },
                    {
                        title: 'Feedback',
                        text: 'After voting, you can submit feedback about your voting experience here.',
                        mobileText: 'After voting, submit feedback about your experience.',
                        selectors: ['[data-tour="feedback-sidebar"]']
                    }
                ];

                this.bindEvents();
                this.renderDots();
                this.autoStartIfNeeded();
            }

            bindEvents() {
                this.backBtn?.addEventListener('click', () => this.back());
                this.nextBtn?.addEventListener('click', () => this.next());
                this.skipBtn?.addEventListener('click', () => this.skip());
                this.closeBtn?.addEventListener('click', () => this.skip());
                this.trigger?.addEventListener('click', () => this.start(true));
                window.addEventListener('resize', () => {
                    if (this.isOpen) this.renderStep();
                });
                window.addEventListener('scroll', () => {
                    if (this.isOpen && this.activeEls[0]) {
                        this.applySpotlight(this.activeEls[0]);
                        this.positionTooltip(this.activeEls[0]);
                    }
                }, { passive: true });
            }

            renderDots() {
                if (!this.dots) return;
                this.dots.innerHTML = this.steps.map((_, idx) => (
                    '<span class="vw-dot' + (idx === this.index ? ' active' : '') + '"></span>'
                )).join('');
            }

            animateStepContent(updateFn) {
                if (!this.stepContent) {
                    updateFn();
                    return;
                }
                this.stepContent.classList.add('is-switching');
                setTimeout(() => {
                    updateFn();
                    this.stepContent.classList.remove('is-switching');
                }, 120);
            }

            autoStartIfNeeded() {
                if (this.serverCompleted) {
                    localStorage.setItem(this.storageKey, '1');
                }

                const done = this.serverCompleted || localStorage.getItem(this.storageKey) === '1';
                if (!done) {
                    setTimeout(() => this.start(false), 350);
                }
            }

            async persistCompletion() {
                if (!this.completeUrl) return;
                try {
                    await fetch(this.completeUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        },
                        body: JSON.stringify({})
                    });
                } catch (e) {
                    // Keep UX smooth even if network write fails.
                }
            }

            getSidebarStore() {
                if (!window.Alpine || typeof window.Alpine.store !== 'function') return null;
                return window.Alpine.store('sidebar');
            }

            sidebarElement() {
                return document.querySelector('.sidebar-shell');
            }

            isSidebarVisiblyOpen() {
                const el = this.sidebarElement();
                if (!el) return false;
                const style = window.getComputedStyle(el);
                const rect = el.getBoundingClientRect();
                return style.display !== 'none' && style.visibility !== 'hidden' && rect.width > 0 && rect.height > 0 && rect.left < window.innerWidth;
            }

            openSidebarHard() {
                const isMobile = window.innerWidth < 1024;
                if (!isMobile) return;

                const store = this.getSidebarStore();
                if (store) store.isOpen = true;

                if (!this.isSidebarVisiblyOpen()) {
                    const toggleBtn = document.querySelector('.nav-toggle');
                    if (toggleBtn) {
                        toggleBtn.click();
                    }
                }
            }

            closeSidebarHard() {
                const isMobile = window.innerWidth < 1024;
                if (!isMobile) return;

                const store = this.getSidebarStore();
                if (store) store.isOpen = false;

                if (this.isSidebarVisiblyOpen()) {
                    const toggleBtn = document.querySelector('.nav-toggle');
                    if (toggleBtn) {
                        toggleBtn.click();
                    }
                }
            }

            syncSidebarForStep(needsSidebar) {
                const store = this.getSidebarStore();
                if (!store || window.innerWidth >= 1024) return false;

                if (this.sidebarWasOpen === null) {
                    this.sidebarWasOpen = !!store.isOpen;
                }

                if (needsSidebar) {
                    this.openSidebarHard();
                    this.sidebarTouchedByWalkthrough = true;
                    return true;
                }

                // Only auto-close if walkthrough opened/managed it.
                if (this.sidebarTouchedByWalkthrough) {
                    this.closeSidebarHard();
                    return true;
                }

                return false;
            }

            ensureSidebarVisible(needsSidebar) {
                return this.syncSidebarForStep(needsSidebar);
            }

            restoreSidebar() {
                const store = this.getSidebarStore();
                if (!store || this.sidebarWasOpen === null) return;
                const isMobile = window.innerWidth < 1024;
                if (isMobile) store.isOpen = this.sidebarWasOpen;
                this.sidebarWasOpen = null;
                this.sidebarTouchedByWalkthrough = false;
            }

            start(forceReplay) {
                if (!forceReplay && this.isOpen) return;
                this.isOpen = true;
                this.index = 0;
                this.root.classList.add('is-open');
                this.root.setAttribute('aria-hidden', 'false');
                document.body.classList.add('vw-active');
                this.syncMobilePagePadding();
                if (forceReplay) this.dontShowCheckbox.checked = false;
                this.renderStep();
            }

            end(markDone) {
                this.clearHighlights();
                this.restoreSidebar();
                this.root.classList.remove('is-open');
                this.root.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('vw-active');
                document.body.style.paddingBottom = '';
                this.isOpen = false;
                if (markDone || this.dontShowCheckbox.checked) {
                    localStorage.setItem(this.storageKey, '1');
                    this.serverCompleted = true;
                    this.persistCompletion();
                }
            }

            skip() {
                this.end(false);
            }

            next() {
                this.nextBtn.classList.remove('is-bounce');
                void this.nextBtn.offsetWidth;
                this.nextBtn.classList.add('is-bounce');
                if (this.index >= this.steps.length - 1) {
                    this.end(true);
                    return;
                }
                this.index += 1;
                this.renderStep();
            }

            back() {
                if (this.index <= 0) return;
                this.index -= 1;
                this.renderStep();
            }

            clearHighlights() {
                this.activeEls.forEach((el) => el.classList.remove('vw-highlight'));
                this.activeEls = [];
                if (this.cutoutRing) this.cutoutRing.style.opacity = '0';
            }

            applySpotlight(targetEl) {
                if (!targetEl) {
                    if (this.overlayTop) {
                        this.overlayTop.style.left = '0px';
                        this.overlayTop.style.top = '0px';
                        this.overlayTop.style.width = '100vw';
                        this.overlayTop.style.height = '100vh';
                    }
                    if (this.overlayLeft) this.overlayLeft.style.height = '0px';
                    if (this.overlayRight) this.overlayRight.style.height = '0px';
                    if (this.overlayBottom) this.overlayBottom.style.height = '0px';
                    if (this.cutoutRing) this.cutoutRing.style.opacity = '0';
                    return;
                }

                const rect = targetEl.getBoundingClientRect();
                const gap = 8;
                const left = Math.max(0, rect.left - gap);
                const top = Math.max(0, rect.top - gap);
                const right = Math.min(window.innerWidth, rect.right + gap);
                const bottom = Math.min(window.innerHeight, rect.bottom + gap);
                const width = Math.max(0, right - left);
                const height = Math.max(0, bottom - top);

                if (this.overlayTop) {
                    this.overlayTop.style.left = '0px';
                    this.overlayTop.style.top = '0px';
                    this.overlayTop.style.width = '100vw';
                    this.overlayTop.style.height = top + 'px';
                }
                if (this.overlayLeft) {
                    this.overlayLeft.style.left = '0px';
                    this.overlayLeft.style.top = top + 'px';
                    this.overlayLeft.style.width = left + 'px';
                    this.overlayLeft.style.height = height + 'px';
                }
                if (this.overlayRight) {
                    this.overlayRight.style.left = right + 'px';
                    this.overlayRight.style.top = top + 'px';
                    this.overlayRight.style.width = Math.max(0, window.innerWidth - right) + 'px';
                    this.overlayRight.style.height = height + 'px';
                }
                if (this.overlayBottom) {
                    this.overlayBottom.style.left = '0px';
                    this.overlayBottom.style.top = bottom + 'px';
                    this.overlayBottom.style.width = '100vw';
                    this.overlayBottom.style.height = Math.max(0, window.innerHeight - bottom) + 'px';
                }
                if (this.cutoutRing) {
                    this.cutoutRing.style.left = left + 'px';
                    this.cutoutRing.style.top = top + 'px';
                    this.cutoutRing.style.width = width + 'px';
                    this.cutoutRing.style.height = height + 'px';
                    this.cutoutRing.style.opacity = '1';
                }
            }

            positionTooltip(targetEl) {
                if (!this.tooltip || !targetEl || window.innerWidth < 768) {
                    if (this.tooltip) {
                        if (window.innerWidth >= 768 && window.innerWidth < 1024) {
                            this.tooltip.style.top = '88px';
                            this.tooltip.style.left = '50%';
                            this.tooltip.style.right = 'auto';
                            this.tooltip.style.transform = 'translateX(-50%)';
                            this.tooltip.dataset.side = 'bottom';
                        } else {
                            this.tooltip.style.top = '';
                            this.tooltip.style.left = '';
                            this.tooltip.style.right = '24px';
                            this.tooltip.style.transform = '';
                            this.tooltip.dataset.side = 'right';
                        }
                    }
                    return;
                }

                const margin = 16;
                const rect = targetEl.getBoundingClientRect();
                const ttRect = this.tooltip.getBoundingClientRect();
                const vw = window.innerWidth;
                const vh = window.innerHeight;

                let side = 'right';
                let top = rect.top;
                let left = rect.right + margin;

                const roomRight = vw - rect.right - margin - ttRect.width;
                const roomLeft = rect.left - margin - ttRect.width;

                if (roomRight >= 0) {
                    side = 'right';
                    left = rect.right + margin;
                } else if (roomLeft >= 0) {
                    side = 'left';
                    left = rect.left - ttRect.width - margin;
                } else {
                    const roomBottom = vh - rect.bottom - margin - ttRect.height;
                    if (roomBottom >= 0) {
                        side = 'bottom';
                        top = rect.bottom + margin;
                        left = Math.max(12, Math.min(rect.left, vw - ttRect.width - 12));
                    } else {
                        side = 'top';
                        top = rect.top - ttRect.height - margin;
                        left = Math.max(12, Math.min(rect.left, vw - ttRect.width - 12));
                    }
                }

                if (side === 'right' || side === 'left') {
                    top = Math.max(82, Math.min(rect.top, vh - ttRect.height - 12));
                } else {
                    top = Math.max(82, Math.min(top, vh - ttRect.height - 12));
                }

                this.tooltip.dataset.side = side;
                this.tooltip.style.left = Math.round(left) + 'px';
                this.tooltip.style.right = 'auto';
                this.tooltip.style.top = Math.round(top) + 'px';
                this.tooltip.style.transform = '';
            }

            ensureMobileVisibility(targetEl) {
                if (!targetEl || window.innerWidth >= 768 || !this.tooltip) return;
                const rect = targetEl.getBoundingClientRect();
                const sheetHeight = this.tooltip.getBoundingClientRect().height;
                const visibleBottom = window.innerHeight - sheetHeight - 40;
                if (rect.bottom > visibleBottom) {
                    const delta = rect.bottom - visibleBottom + 36;
                    window.scrollBy({ top: delta, behavior: 'smooth' });
                }
                if (rect.top < 76) {
                    const delta = rect.top - 76;
                    window.scrollBy({ top: delta, behavior: 'smooth' });
                }
            }

            syncMobilePagePadding() {
                if (!this.isOpen || !this.tooltip) return;
                if (window.innerWidth >= 768) {
                    document.body.style.paddingBottom = '';
                    return;
                }
                const sheetH = Math.ceil(this.tooltip.getBoundingClientRect().height);
                document.body.style.paddingBottom = (sheetH + 32) + 'px';
            }

            isVisible(el) {
                if (!el) return false;
                const rect = el.getBoundingClientRect();
                const style = window.getComputedStyle(el);
                return rect.width > 0 && rect.height > 0 && style.display !== 'none' && style.visibility !== 'hidden';
            }

            renderStep() {
                const step = this.steps[this.index];
                if (!step) return;

                const needsSidebar = step.selectors.some((s) => s.includes('sidebar'));
                const sidebarOpenedForStep = this.ensureSidebarVisible(needsSidebar);

                this.animateStepContent(() => {
                    this.stepLabel.textContent = 'Step ' + (this.index + 1) + ' of ' + this.steps.length;
                    this.title.textContent = step.title;
                    this.text.textContent = window.innerWidth < 768 && step.mobileText ? step.mobileText : step.text;
                    this.renderDots();
                });
                this.backBtn.disabled = this.index === 0;
                this.nextBtn.textContent = this.index === this.steps.length - 1 ? 'Finish' : 'Next';

                this.clearHighlights();

                const queryDelay = sidebarOpenedForStep ? 320 : 140;
                setTimeout(() => {
                    const tryResolveTargets = (attempt = 0) => {
                        const targets = step.selectors
                            .map((selector) => document.querySelector(selector))
                            .filter((el) => this.isVisible(el));

                        if (!targets.length && sidebarOpenedForStep && attempt < 7) {
                            this.openSidebarHard();
                            setTimeout(() => tryResolveTargets(attempt + 1), 140);
                            return;
                        }

                        targets.forEach((el) => {
                            el.classList.add('vw-highlight');
                            this.activeEls.push(el);
                        });

                        const primaryTarget = targets[0];
                        if (primaryTarget) {
                            primaryTarget.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center',
                                inline: 'nearest'
                            });
                            setTimeout(() => {
                                this.ensureMobileVisibility(primaryTarget);
                                this.applySpotlight(primaryTarget);
                                this.positionTooltip(primaryTarget);
                                this.syncMobilePagePadding();
                            }, 240);
                        } else {
                            this.applySpotlight(null);
                            this.positionTooltip(null);
                            this.syncMobilePagePadding();
                        }
                    };

                    tryResolveTargets();
                }, 140);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            window.voterWalkthrough = new VoterWalkthrough();
        });
    })();
</script>
