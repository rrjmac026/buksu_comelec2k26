<style>
    *, *::before, *::after { box-sizing: border-box; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes shimmerBar {
        0%,100% { background-position: 0% 0%; }
        50%      { background-position: 100% 0%; }
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    @keyframes pulse-dot {
        0%,100% { box-shadow: 0 0 6px rgba(52,211,153,0.5); }
        50%      { box-shadow: 0 0 18px rgba(52,211,153,1); }
    }

    /* ── Page Shell ── */
    .st-wrap { padding: 0 0 80px; }

    /* ── Page Header ── */
    .st-page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 16px; margin-bottom: 28px; flex-wrap: wrap;
        animation: fadeUp .3s ease both;
    }
    .st-page-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem; font-weight: 900; color: #fffbf0; margin: 0 0 4px;
        letter-spacing: -0.01em;
    }
    .st-page-sub { font-size: 0.72rem; color: rgba(255,251,240,0.4); }

    /* ── Tab Bar ── */
    .st-tab-bar {
        display: flex; gap: 4px; margin-bottom: 28px;
        background: rgba(26,0,32,0.6);
        border: 1px solid rgba(249,180,15,0.12);
        border-radius: 14px; padding: 5px;
        width: fit-content;
        animation: fadeUp .35s ease both;
    }
    .st-tab {
        display: flex; align-items: center; gap: 8px;
        padding: 10px 20px; border-radius: 10px;
        font-family: 'DM Sans', sans-serif; font-size: 0.78rem; font-weight: 700;
        cursor: pointer; border: none; background: transparent;
        color: rgba(255,251,240,0.35); transition: all .2s;
        white-space: nowrap;
    }
    .st-tab i { font-size: 0.7rem; }
    .st-tab:hover { color: rgba(249,180,15,0.65); background: rgba(249,180,15,0.04); }
    .st-tab.active {
        background: linear-gradient(135deg, rgba(249,180,15,0.15), rgba(252,213,88,0.08));
        border: 1px solid rgba(249,180,15,0.25);
        color: #f9b40f;
        box-shadow: 0 2px 12px rgba(249,180,15,0.1);
    }
    .st-tab-dot {
        width: 6px; height: 6px; border-radius: 50%; background: #34d399;
        box-shadow: 0 0 6px rgba(52,211,153,0.7);
        animation: pulse-dot 1.5s ease-in-out infinite;
        flex-shrink: 0;
    }

    /* ── Tab Panels ── */
    .st-panel { display: none; animation: fadeUp .35s ease both; }
    .st-panel.active { display: block; }

    /* ── Toast ── */
    .st-toast {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 18px; border-radius: 12px; margin-bottom: 20px;
        font-family: 'DM Sans', sans-serif; font-size: 0.75rem; font-weight: 600;
        animation: fadeUp .3s ease both;
    }
    .st-toast-success { background: rgba(52,211,153,0.08); border: 1px solid rgba(52,211,153,0.2); color: #34d399; }
    .st-toast-error   { background: rgba(239,68,68,0.08);  border: 1px solid rgba(239,68,68,0.2);  color: #f87171; }

    /* ══════════════════════════════════════════
    ELECTION TAB STYLES
    ══════════════════════════════════════════ */
    .ec-card {
        background: rgba(26,0,32,0.88);
        backdrop-filter: blur(24px);
        border: 1px solid rgba(249,180,15,0.2);
        border-radius: 20px; overflow: hidden;
        box-shadow: 0 8px 48px rgba(0,0,0,0.45);
        margin-bottom: 20px;
        animation: fadeUp 0.4s ease both;
    }
    .ec-card::before {
        content: ''; display: block; height: 2px;
        background: linear-gradient(90deg, transparent, #f9b40f, #fcd558, transparent);
    }
    .ec-header { padding: 24px 28px 20px; border-bottom: 1px solid rgba(249,180,15,0.08); }
    .ec-title  { font-family: 'Playfair Display', serif; font-size: 1.05rem; font-weight: 900; color: #fffbf0; }
    .ec-sub    { font-size: 0.72rem; color: rgba(255,251,240,0.4); margin-top: 4px; }
    .ec-body   { padding: 24px 28px; }

    .status-display {
        display: flex; align-items: center; gap: 14px;
        padding: 16px 20px; border-radius: 14px; margin-bottom: 24px;
    }
    .status-display.upcoming { background: rgba(249,180,15,0.07); border: 1px solid rgba(249,180,15,0.2); }
    .status-display.ongoing  { background: rgba(52,211,153,0.07); border: 1px solid rgba(52,211,153,0.25); }
    .status-display.ended    { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); }

    .status-dot { width: 12px; height: 12px; border-radius: 50%; flex-shrink: 0; }
    .status-dot.upcoming { background: #f9b40f; box-shadow: 0 0 8px rgba(249,180,15,0.6); }
    .status-dot.ongoing  { background: #34d399; box-shadow: 0 0 8px rgba(52,211,153,0.6); animation: pulse-dot 1.5s ease-in-out infinite; }
    .status-dot.ended    { background: rgba(255,255,255,0.2); }

    .status-label { font-size: 0.88rem; font-weight: 700; }
    .status-label.upcoming { color: #f9b40f; }
    .status-label.ongoing  { color: #34d399; }
    .status-label.ended    { color: rgba(255,255,255,0.4); }
    .status-hint { font-size: 0.65rem; color: rgba(255,251,240,0.35); margin-top: 2px; }

    .status-section-title {
        font-size: 0.62rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.1em; color: rgba(249,180,15,0.5); margin-bottom: 12px;
    }
    .status-btns { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 24px; }

    .status-btn {
        flex: 1; min-width: 130px; padding: 14px 18px; border-radius: 12px; border: none; cursor: pointer;
        font-size: 0.78rem; font-weight: 700; font-family: 'DM Sans', sans-serif;
        display: flex; flex-direction: column; align-items: center; gap: 6px; transition: all 0.2s;
    }
    .status-btn i { font-size: 1.1rem; }

    .btn-upcoming { background: rgba(249,180,15,0.1); border: 2px solid rgba(249,180,15,0.25); color: rgba(249,180,15,0.8); }
    .btn-upcoming:hover, .btn-upcoming.active {
        background: rgba(249,180,15,0.18); border-color: #f9b40f; color: #f9b40f;
        transform: translateY(-2px); box-shadow: 0 6px 20px rgba(249,180,15,0.2);
    }
    .btn-upcoming.active { box-shadow: 0 0 0 2px rgba(249,180,15,0.4); }

    .btn-ongoing { background: rgba(52,211,153,0.1); border: 2px solid rgba(52,211,153,0.25); color: rgba(52,211,153,0.8); }
    .btn-ongoing:hover, .btn-ongoing.active {
        background: rgba(52,211,153,0.18); border-color: #34d399; color: #34d399;
        transform: translateY(-2px); box-shadow: 0 6px 20px rgba(52,211,153,0.2);
    }
    .btn-ongoing.active { box-shadow: 0 0 0 2px rgba(52,211,153,0.4); }

    .btn-ended { background: rgba(255,255,255,0.04); border: 2px solid rgba(255,255,255,0.1); color: rgba(255,255,255,0.4); }
    .btn-ended:hover, .btn-ended.active {
        background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.25);
        color: rgba(255,255,255,0.7); transform: translateY(-2px);
    }
    .btn-ended.active { box-shadow: 0 0 0 2px rgba(255,255,255,0.15); }

    .name-row { display: flex; gap: 10px; align-items: flex-end; }
    .name-input-wrap { flex: 1; }
    .field-label {
        display: block; font-size: 0.62rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.08em; color: rgba(249,180,15,0.5); margin-bottom: 6px;
    }
    .field-input {
        width: 100%; padding: 10px 14px; border-radius: 10px;
        background: rgba(56,0,65,0.5); border: 1px solid rgba(249,180,15,0.15);
        color: #fffbf0; font-size: 0.82rem; font-family: 'DM Sans', sans-serif;
        transition: border-color 0.18s; outline: none;
    }
    .field-input:focus { border-color: rgba(249,180,15,0.45); }
    .save-btn {
        padding: 10px 20px; border-radius: 10px; border: none; cursor: pointer;
        background: linear-gradient(135deg, #f9b40f, #fcd558); color: #380041;
        font-size: 0.78rem; font-weight: 700; font-family: 'DM Sans', sans-serif;
        transition: all 0.18s; white-space: nowrap;
    }
    .save-btn:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(249,180,15,0.35); }

    .warning-box {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 12px 16px; border-radius: 10px;
        background: rgba(239,68,68,0.06); border: 1px solid rgba(239,68,68,0.15);
        font-size: 0.68rem; color: rgba(248,113,113,0.8); line-height: 1.65;
    }

    /* ══════════════════════════════════════════
    BACKUP TAB STYLES
    ══════════════════════════════════════════ */
    .abk-stat-strip { display: grid; grid-template-columns: repeat(4,1fr); gap: 14px; margin-bottom: 20px; }
    @media(max-width:640px){ .abk-stat-strip { grid-template-columns: 1fr 1fr; } }

    .abk-stat-card {
        background: rgba(26,0,32,0.88); border: 1px solid rgba(249,180,15,0.15);
        border-radius: 16px; padding: 18px 20px;
        display: flex; align-items: center; gap: 14px;
        box-shadow: inset 0 1px 0 rgba(249,180,15,0.05);
        animation: fadeUp .4s ease both;
    }
    .abk-stat-icon {
        width: 42px; height: 42px; border-radius: 12px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; font-size: 0.9rem;
    }
    .abk-stat-num {
        font-family: 'Playfair Display', serif; font-size: 1.55rem; font-weight: 900; line-height: 1;
        background: linear-gradient(135deg, #f9b40f, #fcd558, #fff3c4);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
    }
    .abk-stat-lbl { font-size: 0.6rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(249,180,15,0.45); margin-top: 3px; }

    .abk-processing-banner {
        display: flex; align-items: center; gap: 14px;
        padding: 14px 20px; border-radius: 12px; margin-bottom: 18px;
        background: rgba(96,165,250,0.06); border: 1px solid rgba(96,165,250,0.2);
    }
    .abk-spin {
        width: 18px; height: 18px; border: 2px solid rgba(96,165,250,0.2);
        border-top-color: #60a5fa; border-radius: 50%; flex-shrink: 0;
        animation: spin .8s linear infinite;
    }
    .abk-prog-track { flex: 1; height: 6px; border-radius: 99px; background: rgba(96,165,250,0.1); overflow: hidden; margin-top: 6px; }
    .abk-prog-fill  { height: 100%; border-radius: 99px; background: linear-gradient(90deg, #60a5fa, #93c5fd); transition: width .5s ease; }

    .abk-btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 9px 18px; border-radius: 9px;
        font-family: 'DM Sans', sans-serif; font-size: 0.75rem; font-weight: 700;
        cursor: pointer; transition: all .18s; border: none; white-space: nowrap; text-decoration: none;
    }
    .abk-btn-primary { background: linear-gradient(135deg, #f9b40f, #fcd558); color: #380041; box-shadow: 0 3px 12px rgba(249,180,15,0.3); }
    .abk-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(249,180,15,0.45); color: #380041; }
    .abk-btn-sky { background: transparent; border: 1px solid rgba(96,165,250,0.25); color: rgba(96,165,250,0.7); }
    .abk-btn-sky:hover { background: rgba(96,165,250,0.08); border-color: rgba(96,165,250,0.5); color: #93c5fd; }
    .abk-btn-ghost { background: transparent; border: 1px solid rgba(249,180,15,0.2); color: rgba(249,180,15,0.55); }
    .abk-btn-ghost:hover { background: rgba(249,180,15,0.06); color: #f9b40f; }

    .abk-table-card {
        background: rgba(26,0,32,0.88); backdrop-filter: blur(24px);
        border: 1px solid rgba(249,180,15,0.18); border-radius: 18px;
        box-shadow: 0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(249,180,15,0.06);
        overflow: hidden; animation: fadeUp .46s ease both;
    }
    .abk-table-card::before {
        content: ''; display: block; height: 2px;
        background: linear-gradient(90deg, transparent, #f9b40f, #fcd558, transparent);
        background-size: 200% 100%; animation: shimmerBar 3s ease-in-out infinite;
    }
    .abk-table         { width: 100%; border-collapse: collapse; font-size: 0.82rem; }
    .abk-thead tr      { background: linear-gradient(to right, rgba(56,0,65,0.5), transparent); border-bottom: 1px solid rgba(249,180,15,0.12); }
    .abk-thead th      { padding: 14px 20px; text-align: left; font-size: 0.58rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(249,180,15,0.6); }
    .abk-tbody tr      { border-bottom: 1px solid rgba(249,180,15,0.07); transition: background .18s; }
    .abk-tbody tr:last-child { border-bottom: none; }
    .abk-tbody tr:hover { background: rgba(249,180,15,0.04); }
    .abk-tbody td      { padding: 14px 20px; color: rgba(255,251,240,0.85); vertical-align: middle; }

    .abk-type-badge { display: inline-flex; padding: 3px 10px; border-radius: 7px; font-size: 0.62rem; font-weight: 700; background: rgba(249,180,15,0.1); border: 1px solid rgba(249,180,15,0.18); color: rgba(249,180,15,0.8); }
    .abk-type-badge.full { background: rgba(96,165,250,0.1); border-color: rgba(96,165,250,0.2); color: rgba(96,165,250,0.8); }

    .abk-status-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 99px; font-size: 0.65rem; font-weight: 700; }
    .abk-status-badge.completed { background: rgba(52,211,153,0.1); border: 1px solid rgba(52,211,153,0.2); color: #34d399; }
    .abk-status-badge.processing { background: rgba(96,165,250,0.1); border: 1px solid rgba(96,165,250,0.2); color: #60a5fa; }
    .abk-status-badge.failed { background: rgba(248,113,113,0.1); border: 1px solid rgba(248,113,113,0.2); color: #f87171; }
    .abk-status-badge.pending { background: rgba(249,180,15,0.08); border: 1px solid rgba(249,180,15,0.15); color: rgba(249,180,15,0.65); }

    .abk-spin-sm { width: 10px; height: 10px; border: 1.5px solid rgba(96,165,250,0.2); border-top-color: #60a5fa; border-radius: 50%; animation: spin .8s linear infinite; display: inline-block; flex-shrink: 0; }

    .abk-mini-track { width: 90px; height: 5px; border-radius: 99px; background: rgba(249,180,15,0.07); overflow: hidden; display: inline-block; vertical-align: middle; }
    .abk-mini-fill  { height: 100%; border-radius: 99px; background: linear-gradient(90deg, #60a5fa, #93c5fd); transition: width .5s; }

    .abk-action-btn {
        width: 30px; height: 30px; border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        border: 1px solid rgba(249,180,15,0.15); background: transparent;
        color: rgba(249,180,15,0.5); font-size: 0.65rem;
        cursor: pointer; transition: all .18s; text-decoration: none;
    }
    .abk-action-btn:hover { border-color: rgba(249,180,15,0.4); color: #f9b40f; background: rgba(249,180,15,0.06); }
    .abk-action-btn.sky { border-color: rgba(96,165,250,0.2); color: rgba(96,165,250,0.6); }
    .abk-action-btn.sky:hover { border-color: rgba(96,165,250,0.5); color: #93c5fd; background: rgba(96,165,250,0.08); }
    .abk-action-btn.danger { border-color: rgba(248,113,113,0.2); color: rgba(248,113,113,0.5); }
    .abk-action-btn.danger:hover { border-color: rgba(248,113,113,0.45); color: #f87171; background: rgba(248,113,113,0.06); }
    .abk-action-btn.amber { border-color: rgba(251,146,60,0.2); color: rgba(251,146,60,0.6); }
    .abk-action-btn.amber:hover { border-color: rgba(251,146,60,0.45); color: #fb923c; background: rgba(251,146,60,0.08); }

    .abk-empty { padding: 60px 24px; text-align: center; }
    .abk-empty-icon  { font-size: 2.5rem; color: rgba(249,180,15,0.1); margin-bottom: 14px; display: block; }
    .abk-empty-title { font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 800; color: rgba(255,251,240,0.35); margin-bottom: 6px; }
    .abk-empty-sub   { font-size: 0.72rem; color: rgba(255,251,240,0.2); }

    .abk-pagination { padding: 16px 20px; border-top: 1px solid rgba(249,180,15,0.1); }

    /* ── Shared Modal ── */
    .st-modal-backdrop {
        position: fixed; inset: 0; z-index: 50;
        background: rgba(0,0,0,0.7); backdrop-filter: blur(4px);
        display: flex; align-items: center; justify-content: center; padding: 16px;
        overflow-y: auto;
    }
    .st-modal {
        background: rgba(22,0,28,0.98); border: 1px solid rgba(249,180,15,0.25);
        border-radius: 20px; width: 100%; max-width: 520px;
        box-shadow: 0 24px 80px rgba(0,0,0,0.7); overflow: visible;
        animation: fadeUp .3s ease both;
        margin: 16px auto;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
    }
    .st-modal::before { content: ''; display: block; height: 2px; background: linear-gradient(90deg, transparent, #f9b40f, #fcd558, transparent); }
    .st-modal-header { padding: 22px 24px 16px; border-bottom: 1px solid rgba(249,180,15,0.08); background: linear-gradient(to right, rgba(56,0,65,0.4), transparent); flex-shrink: 0; }
    .st-modal-title  { font-family: 'Playfair Display', serif; font-size: 1.05rem; font-weight: 900; color: #fffbf0; }
    .st-modal-sub    { font-size: 0.7rem; color: rgba(255,251,240,0.4); margin-top: 3px; }
    .st-modal-body   { padding: 20px 24px; overflow-y: auto; flex: 1; }
    .st-modal-footer { padding: 16px 24px; border-top: 1px solid rgba(249,180,15,0.08); display: flex; gap: 10px; justify-content: flex-end; flex-wrap: wrap; flex-shrink: 0; }
    
    /* Responsive modals */
    @media(max-width: 640px) {
        .st-modal { max-width: 100%; border-radius: 16px; }
        .st-modal-header { padding: 18px 18px 14px; }
        .st-modal-title { font-size: 1rem; }
        .st-modal-body { padding: 16px 18px; }
        .st-modal-footer { padding: 14px 18px; flex-direction: column; }
        .st-modal-footer button,
        .st-modal-footer form { width: 100%; }
    }

    .abk-field-label { display: block; font-size: 0.6rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: rgba(249,180,15,0.5); margin-bottom: 7px; }
    .abk-select, .abk-input {
        width: 100%; background: rgba(56,0,65,0.6); border: 1px solid rgba(249,180,15,0.15);
        border-radius: 10px; padding: 10px 14px;
        font-family: 'DM Sans', sans-serif; font-size: 0.82rem; color: #fffbf0;
        outline: none; transition: border-color .2s; margin-bottom: 14px; box-sizing: border-box;
    }
    @media(max-width: 640px) {
        .abk-select, .abk-input { font-size: 16px; padding: 12px 14px; }
    }
    .abk-select:focus, .abk-input:focus { border-color: rgba(249,180,15,0.4); }
    .abk-select {
        -webkit-appearance: none; appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='rgba(249,180,15,0.5)' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 12px center; padding-right: 32px;
    }
    .abk-select option { background: #1a0020; }
    .abk-checkbox-row { display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 10px; background: rgba(56,0,65,0.3); border: 1px solid rgba(249,180,15,0.1); }
    .abk-checkbox-row input[type="checkbox"] { accent-color: #f9b40f; width: 14px; height: 14px; }
    .abk-checkbox-label { font-size: 0.75rem; color: rgba(255,251,240,0.65); }
    .abk-hint { font-size: 0.62rem; color: rgba(255,251,240,0.25); margin-top: -10px; margin-bottom: 14px; padding-left: 2px; }

    .abk-del-icon { width: 48px; height: 48px; border-radius: 14px; flex-shrink: 0; background: rgba(248,113,113,0.1); border: 1px solid rgba(248,113,113,0.2); display: flex; align-items: center; justify-content: center; font-size: 1rem; color: #f87171; }
    .abk-del-body { font-size: 0.75rem; color: rgba(255,251,240,0.5); line-height: 1.7; margin: 14px 0 20px; }

    .st-m-cancel {
        padding: 9px 18px; border-radius: 9px; cursor: pointer;
        background: transparent; border: 1px solid rgba(249,180,15,0.18);
        color: rgba(249,180,15,0.55); font-family: 'DM Sans', sans-serif;
        font-size: 0.75rem; font-weight: 700; transition: all .18s; white-space: nowrap;
    }
    .st-m-cancel:hover { background: rgba(249,180,15,0.06); color: #f9b40f; }
    .st-m-delete {
        padding: 9px 20px; border-radius: 9px; cursor: pointer;
        background: linear-gradient(135deg, #ef4444, #f87171); border: none;
        color: #fff; font-family: 'DM Sans', sans-serif; font-size: 0.75rem; font-weight: 700;
        box-shadow: 0 3px 10px rgba(239,68,68,0.3); transition: all .18s; white-space: nowrap;
    }
    .st-m-delete:hover { transform: translateY(-1px); box-shadow: 0 5px 16px rgba(239,68,68,0.45); }
    
    @media(max-width: 640px) {
        .st-m-cancel, .st-m-delete { padding: 11px 16px; font-size: 0.78rem; width: 100%; }
    }

    .abk-test-panel { background: rgba(26,0,32,0.88); border: 1px solid rgba(249,180,15,0.18); border-radius: 14px; overflow: hidden; margin-bottom: 0; }
    .abk-test-row { display: flex; align-items: center; justify-content: space-between; padding: 12px 20px; border-bottom: 1px solid rgba(249,180,15,0.07); font-size: 0.78rem; }
    .abk-test-row:last-child { border-bottom: none; }
    .abk-test-key { color: rgba(255,251,240,0.5); font-size: 0.72rem; }
    .abk-test-val { font-weight: 600; }
    .abk-test-val.ok   { color: #34d399; }
    .abk-test-val.warn { color: #fb923c; }
    .abk-test-val.err  { color: #f87171; }
</style>