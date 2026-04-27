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
    const modalElectionStart = @json($electionStart);
    const modalElectionEnd   = @json($electionEnd);

    function formatScheduleDate(value) {
        if (!value) return 'Not set';
        try {
            return new Date(value).toLocaleString(undefined, {
                month: 'short', day: 'numeric', year: 'numeric',
                hour: 'numeric', minute: '2-digit'
            });
        } catch (e) {
            return value;
        }
    }

    function formatDateTimeLocal(value) {
        if (!value) return '';
        const date = new Date(value);
        if (Number.isNaN(date.getTime())) return '';
        const pad = n => String(n).padStart(2, '0');
        return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}T${pad(date.getHours())}:${pad(date.getMinutes())}`;
    }

    function renderStatusModalSchedule(status) {
        const startText = formatScheduleDate(modalElectionStart);
        const endText   = formatScheduleDate(modalElectionEnd);

        if (status === 'upcoming') {
            return `
                <div style="display:grid;gap:10px;">
                    <div style="font-size:0.75rem;color:rgba(255,251,240,0.55);">Countdown target: voting start date</div>
                    <div class="schedule-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <div style="padding:12px;border-radius:10px;background:rgba(249,180,15,0.08);border:1px solid rgba(249,180,15,0.15);">
                            <div style="font-size:0.65rem;color:rgba(249,180,15,0.65);margin-bottom:6px;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;">Start</div>
                            <div style="font-size:0.78rem;font-weight:700;color:#fffbf0;word-break:break-word;">${startText}</div>
                        </div>
                        <div style="padding:12px;border-radius:10px;background:rgba(255,255,255,0.03);border:1px dashed rgba(255,255,255,0.08);">
                            <div style="font-size:0.65rem;color:rgba(255,251,240,0.45);margin-bottom:6px;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;">End</div>
                            <div style="font-size:0.78rem;font-weight:700;color:rgba(255,251,240,0.5);word-break:break-word;">${endText}</div>
                        </div>
                    </div>
                </div>`;
        }

        if (status === 'ongoing') {
            return `
                <div style="display:grid;gap:10px;">
                    <div style="font-size:0.75rem;color:rgba(255,251,240,0.55);">Countdown target: voting end date</div>
                    <div class="schedule-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <div style="padding:12px;border-radius:10px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);">
                            <div style="font-size:0.65rem;color:rgba(255,251,240,0.45);margin-bottom:6px;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;">Start</div>
                            <div style="font-size:0.78rem;font-weight:700;color:rgba(255,251,240,0.5);word-break:break-word;">${startText}</div>
                        </div>
                        <div style="padding:12px;border-radius:10px;background:rgba(52,211,153,0.08);border:1px solid rgba(52,211,153,0.15);">
                            <div style="font-size:0.65rem;color:rgba(52,211,153,0.65);margin-bottom:6px;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;">End</div>
                            <div style="font-size:0.78rem;font-weight:700;color:#f8fffb;word-break:break-word;">${endText}</div>
                        </div>
                    </div>
                </div>`;
        }

        return `
            <div style="display:grid;gap:10px;">
                <div style="font-size:0.75rem;color:rgba(255,251,240,0.55);">Election schedule summary</div>
                <div style="padding:12px;border-radius:10px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);">
                    <div style="margin-bottom:6px;font-size:0.65rem;color:rgba(255,251,240,0.45);font-weight:600;text-transform:uppercase;letter-spacing:0.05em;">Start</div>
                    <div style="font-size:0.78rem;font-weight:700;color:rgba(255,251,240,0.75);word-break:break-word;">${startText}</div>
                </div>
                <div style="padding:12px;border-radius:10px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);">
                    <div style="margin-bottom:6px;font-size:0.65rem;color:rgba(255,251,240,0.45);font-weight:600;text-transform:uppercase;letter-spacing:0.05em;">End</div>
                    <div style="font-size:0.78rem;font-weight:700;color:rgba(255,251,240,0.75);word-break:break-word;">${endText}</div>
                </div>
            </div>`;
    }

    function renderStatusModalFields(status) {
        const startValue = formatDateTimeLocal(modalElectionStart);
        const endValue = formatDateTimeLocal(modalElectionEnd);

        if (status === 'upcoming') {
            return `
                <div style="border-radius:12px;padding:16px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);">
                    <div style="font-size:0.85rem;font-weight:700;color:#fffbf0;margin-bottom:12px;">Set Upcoming Schedule</div>
                    <label class="abk-field-label">Voting Start Date &amp; Time</label>
                    <input type="datetime-local" name="election_start" class="abk-input" value="${startValue}" style="width:100%;margin-bottom:0;">
                    <div style="font-size:0.7rem;color:rgba(255,251,240,0.45);margin-top:8px;">
                        This date becomes the countdown target for the upcoming election.
                    </div>
                </div>`;
        }

        if (status === 'ongoing') {
            return `
                <div style="border-radius:12px;padding:16px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);">
                    <div style="font-size:0.85rem;font-weight:700;color:#fffbf0;margin-bottom:12px;">Set Ongoing Schedule</div>
                    <div class="schedule-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                        <div>
                            <label class="abk-field-label">Start Date &amp; Time</label>
                            <input type="datetime-local" name="election_start" class="abk-input" value="${startValue}" style="width:100%;margin-bottom:0;">
                        </div>
                        <div>
                            <label class="abk-field-label">End Date &amp; Time</label>
                            <input type="datetime-local" name="election_end" class="abk-input" value="${endValue}" style="width:100%;margin-bottom:0;">
                        </div>
                    </div>
                    <div style="font-size:0.7rem;color:rgba(255,251,240,0.45);">
                        Voters will see a countdown to the end date once the election is set to ongoing.
                    </div>
                </div>`;
        }

        return `<div style="font-size:0.75rem;color:rgba(255,251,240,0.55);padding:12px 16px;border-radius:10px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);">No schedule fields are required for this status.</div>`;
    }

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

        const scheduleCard = document.getElementById('statusModalScheduleCard');
        const scheduleBadge = document.getElementById('statusModalScheduleBadge');
        const scheduleContent = document.getElementById('statusModalScheduleContent');
        const scheduleFields = document.getElementById('statusModalScheduleFields');

        if (scheduleCard && scheduleContent && scheduleBadge) {
            scheduleBadge.textContent = statusLabel;
            scheduleContent.innerHTML = renderStatusModalSchedule(status);
            scheduleCard.style.display = 'block';
            if (status === 'ongoing') {
                scheduleBadge.style.background = 'rgba(52,211,153,0.12)';
                scheduleBadge.style.borderColor = 'rgba(52,211,153,0.25)';
                scheduleBadge.style.color = '#34d399';
            } else if (status === 'ended') {
                scheduleBadge.style.background = 'rgba(255,255,255,0.08)';
                scheduleBadge.style.borderColor = 'rgba(255,255,255,0.16)';
                scheduleBadge.style.color = 'rgba(255,255,255,0.75)';
            } else {
                scheduleBadge.style.background = 'rgba(249,180,15,0.1)';
                scheduleBadge.style.borderColor = 'rgba(249,180,15,0.2)';
                scheduleBadge.style.color = '#f9b40f';
            }
        }

        if (scheduleFields) {
            scheduleFields.innerHTML = renderStatusModalFields(status);
            scheduleFields.style.display = status === 'ended' ? 'none' : 'block';
        }

        // Store current status for form submission
        window._modalStatus = status;
        
        document.getElementById('statusModal').style.display = 'flex';
    }
    
    function closeStatusConfirmModal() { 
        document.getElementById('statusModal').style.display = 'none'; 
    }

    function submitStatusForm() {
        const form = document.getElementById('statusForm');
        const status = window._modalStatus || 'upcoming';
        
        // Capture date inputs from the modal
        const scheduleFields = document.getElementById('statusModalScheduleFields');
        const startInput = scheduleFields?.querySelector('input[name="election_start"]');
        const endInput = scheduleFields?.querySelector('input[name="election_end"]');
        
        // Remove any existing hidden date inputs
        document.getElementById('statusForm').querySelectorAll('input[type="hidden"][name^="election_"]').forEach(el => el.remove());
        
        // Add hidden inputs for dates
        if (startInput && startInput.value) {
            const hiddenStart = document.createElement('input');
            hiddenStart.type = 'hidden';
            hiddenStart.name = 'election_start';
            hiddenStart.value = startInput.value;
            form.appendChild(hiddenStart);
        }
        
        if (endInput && endInput.value) {
            const hiddenEnd = document.createElement('input');
            hiddenEnd.type = 'hidden';
            hiddenEnd.name = 'election_end';
            hiddenEnd.value = endInput.value;
            form.appendChild(hiddenEnd);
        }
        
        // Change form action to schedule endpoint to handle both status and dates
        form.action = '{{ route('admin.settings.election.schedule') }}';
        form.submit();
    }

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