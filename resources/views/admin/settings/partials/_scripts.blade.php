<script>
    /* ── Tab switching ─────────────────────────────────────────────── */
    function switchTab(tab) {
        document.querySelectorAll('.st-panel').forEach(p => p.classList.remove('active'));
        document.querySelectorAll('.st-tab').forEach(t => t.classList.remove('active'));
        document.getElementById('tab-' + tab).classList.add('active');
        document.querySelectorAll('.st-tab').forEach(t => {
            if (t.getAttribute('onclick') === `switchTab('${tab}')`) t.classList.add('active');
        });
        // Update URL without reload
        const url = new URL(window.location);
        url.searchParams.set('tab', tab);
        history.replaceState({}, '', url);
    }

    /* ── Backup Modal helpers ──────────────────────────────────────── */
    function openCreateModal()  { document.getElementById('createModal').style.display = 'flex'; }
    function closeCreateModal() { document.getElementById('createModal').style.display = 'none'; }

    function openDeleteModal(id, name) {
        document.getElementById('deleteBackupName').textContent = name;
        document.getElementById('deleteForm').action = `/admin/settings/backups/${id}`;
        document.getElementById('deleteModal').style.display = 'flex';
    }
    function closeDeleteModal() { document.getElementById('deleteModal').style.display = 'none'; }

    function showError(msg) {
        document.getElementById('errorMessage').textContent = msg;
        document.getElementById('errorModal').style.display = 'flex';
    }
    function closeErrorModal() { document.getElementById('errorModal').style.display = 'none'; }

    /* ── Test system ───────────────────────────────────────────────── */
    async function openTestModal() {
        document.getElementById('testModal').style.display = 'flex';
        document.getElementById('testModalBody').innerHTML = `
            <div style="display:flex;align-items:center;gap:12px;padding:20px 0;justify-content:center;">
                <div class="abk-spin" style="width:24px;height:24px;border-width:3px;"></div>
                <span style="font-size:0.78rem;color:rgba(255,251,240,0.5);">Running diagnostics…</span>
            </div>`;
        try {
            const res  = await fetch('{{ route('admin.settings.backups.test') }}', {
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            const data = await res.json();
            renderTestResults(data);
        } catch (e) {
            document.getElementById('testModalBody').innerHTML =
                `<div style="color:#f87171;font-size:0.78rem;padding:12px 0;">Failed to run diagnostics: ${e.message}</div>`;
        }
    }
    function closeTestModal() { document.getElementById('testModal').style.display = 'none'; }

    /* ── Status Confirmation Modal ─────────────────────────────────────── */
    function openStatusConfirmModal(status, statusLabel, statusDescription) {
        document.getElementById('statusInput').value = status;
        document.getElementById('statusModalNewStatus').textContent = statusLabel;
        
        const warningBox = document.getElementById('statusWarningBox');
        warningBox.style.display = 'none';
        
        if (status === 'ongoing') {
            warningBox.innerHTML = `<i class="fas fa-triangle-exclamation" style="margin-right:8px;flex-shrink:0;"></i>
                <span><strong>Warning:</strong> Once you set the status to Ongoing, voters will be able to cast their ballots immediately.</span>`;
            warningBox.style.display = 'block';
        } else if (status === 'ended') {
            warningBox.innerHTML = `<i class="fas fa-triangle-exclamation" style="margin-right:8px;flex-shrink:0;"></i>
                <span><strong>Important:</strong> Setting the status to Ended will prevent voters from casting any more ballots.</span>`;
            warningBox.style.display = 'block';
        }
        
        document.getElementById('statusModal').style.display = 'flex';
    }
    function closeStatusConfirmModal() { document.getElementById('statusModal').style.display = 'none'; }

    function renderTestResults(data) {
        const status = data.overall_status === 'ready';
        const statusColor = status ? '#34d399' : '#f87171';
        const rows = [
            { key: 'Overall',          val: data.overall_status,                                                  cls: status ? 'ok' : 'err' },
            { key: 'DB Connection',    val: data.tests?.database_connection?.status ?? '—',                       cls: data.tests?.database_connection?.status === 'success' ? 'ok' : 'err' },
            { key: 'Backup Directory', val: data.tests?.backup_directory?.writable ? 'Writable' : 'Not writable', cls: data.tests?.backup_directory?.writable ? 'ok' : 'err' },
            { key: 'Free Space',       val: data.tests?.backup_directory?.free_space ?? '—',                      cls: 'ok' },
            { key: 'mysqldump',        val: data.tests?.mysqldump?.status ?? '—',                                 cls: data.tests?.mysqldump?.status === 'available' ? 'ok' : 'warn' },
            { key: 'ZIP Extension',    val: data.tests?.php_extensions?.zip ?? '—',                              cls: data.tests?.php_extensions?.zip === 'installed' ? 'ok' : 'err' },
            { key: 'PDO Extension',    val: data.tests?.php_extensions?.pdo ?? '—',                              cls: data.tests?.php_extensions?.pdo === 'installed' ? 'ok' : 'err' },
            { key: 'Queue Driver',     val: data.tests?.queue_configuration?.driver ?? '—',                      cls: 'ok' },
        ];
        document.getElementById('testModalBody').innerHTML = `
            <div class="abk-test-panel">
                ${rows.map(r => `
                <div class="abk-test-row">
                    <span class="abk-test-key">${r.key}</span>
                    <span class="abk-test-val ${r.cls}">${r.val}</span>
                </div>`).join('')}
            </div>
            <div style="margin-top:12px;padding:10px 14px;border-radius:9px;font-size:0.72rem;
                background:${status ? 'rgba(52,211,153,0.06)' : 'rgba(248,113,113,0.06)'};
                border:1px solid ${status ? 'rgba(52,211,153,0.2)' : 'rgba(248,113,113,0.2)'};
                color:${statusColor};">
                ${data.message ?? ''}
            </div>`;
    }

    /* ── Progress polling ──────────────────────────────────────────── */
    let pollingInterval = null;

    @if(($stats['processing'] ?? 0) > 0)
    startPolling();
    @endif

    function startPolling() {
        if (pollingInterval) return;
        pollingInterval = setInterval(pollProgress, 2500);
    }
    function stopPolling() {
        clearInterval(pollingInterval);
        pollingInterval = null;
    }
    async function pollProgress() {
        try {
            const res  = await fetch('{{ route('admin.settings.backups.statistics') }}', {
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            const json = await res.json();
            if (!json.success) return;
            if ((json.data.processing ?? 0) === 0) {
                stopPolling();
                window.location.reload();
            }
        } catch (e) { /* silent */ }
    }

    /* ── Keyboard escape ───────────────────────────────────────────── */
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            closeCreateModal(); closeDeleteModal(); closeTestModal(); closeStatusConfirmModal(); closeErrorModal();
        }
    });
</script>