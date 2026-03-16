<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\CastedVote;
use App\Models\College;
use App\Models\ElectionSetting;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    // ═══════════════════════════════════════════════════════════════
    // DESIGN TOKENS
    // Gold   #f9b40f  → 249,180,15
    // Violet #380041  → 56,0,65
    // Dark   #1e0025  → 30,0,37
    // Mid    #520060  → 82,0,96
    // Cream  #fffbf0  → 255,251,240
    // ═══════════════════════════════════════════════════════════════

    private \FPDF $pdf;
    private string $electionName = '';

    // ── Colour helpers ───────────────────────────────────────────

    private function gold()        { $this->pdf->SetTextColor(249, 180, 15); }
    private function cream()       { $this->pdf->SetTextColor(255, 251, 240); }
    private function violet()      { $this->pdf->SetTextColor(56, 0, 65); }
    private function darkText()    { $this->pdf->SetTextColor(30, 0, 37); }
    private function mutedText()   { $this->pdf->SetTextColor(110, 90, 130); }
    private function dimText()     { $this->pdf->SetTextColor(160, 140, 180); }
    private function greenText()   { $this->pdf->SetTextColor(20, 120, 60); }
    private function redText()     { $this->pdf->SetTextColor(160, 30, 30); }
    private function amberText()   { $this->pdf->SetTextColor(140, 90, 0); }

    private function bgDark()      { $this->pdf->SetFillColor(30, 0, 37); }
    private function bgViolet()    { $this->pdf->SetFillColor(56, 0, 65); }
    private function bgMid()       { $this->pdf->SetFillColor(82, 0, 96); }
    private function bgGold()      { $this->pdf->SetFillColor(249, 180, 15); }
    private function bgGoldLight() { $this->pdf->SetFillColor(254, 243, 199); }
    private function bgCream()     { $this->pdf->SetFillColor(255, 251, 240); }
    private function bgWhite()     { $this->pdf->SetFillColor(255, 255, 255); }
    private function bgStripe()    { $this->pdf->SetFillColor(248, 243, 255); }
    private function bgGreen()     { $this->pdf->SetFillColor(220, 252, 231); }
    private function bgRed()       { $this->pdf->SetFillColor(254, 226, 226); }

    private function borderGold()   { $this->pdf->SetDrawColor(249, 180, 15); }
    private function borderViolet() { $this->pdf->SetDrawColor(56, 0, 65); }
    private function borderLight()  { $this->pdf->SetDrawColor(220, 200, 235); }
    private function borderNone()   { $this->pdf->SetDrawColor(255, 255, 255); }
    private function borderGreen()  { $this->pdf->SetDrawColor(20, 120, 60); }

    // ── PDF init ─────────────────────────────────────────────────

    private function initPdf(string $orientation = 'P'): void
    {
        $this->pdf = new \FPDF($orientation, 'mm', 'A4');
        $this->pdf->SetMargins(14, 14, 14);
        $this->pdf->SetAutoPageBreak(true, 22);
        $this->pdf->SetCreator('Election Management System');
        $this->pdf->SetAuthor('EMS Admin');
        $this->electionName = ElectionSetting::get('election_name', 'Student Council Election');
    }

    // ── HEADER — printed on every page ───────────────────────────

    private function pageHeader(string $reportTitle, string $sub = ''): void
    {
        $pdf = $this->pdf;
        $w   = $pdf->GetPageWidth();

        // ── Dark banner ──
        $this->bgDark();
        $this->borderNone();
        $pdf->Rect(0, 0, $w, 22, 'F');

        // ── Thin gold accent line below banner ──
        $this->bgGold();
        $pdf->Rect(0, 22, $w, 1.5, 'F');

        // ── Gold left sidebar accent ──
        $pdf->Rect(0, 0, 4, 22, 'F');

        // App / election name (left)
        $pdf->SetFont('Helvetica', 'B', 8);
        $this->gold();
        $pdf->SetXY(8, 4);
        $pdf->Cell(90, 5, mb_strtoupper($this->electionName), 0, 0, 'L');

        // Generated timestamp (left, below)
        $pdf->SetFont('Helvetica', '', 6.5);
        $this->dimText();
        $pdf->SetXY(8, 10);
        $pdf->Cell(90, 4, 'Generated: ' . now()->format('F j, Y  H:i:s'), 0, 0, 'L');

        // Report title (right, big)
        $pdf->SetFont('Helvetica', 'B', 9.5);
        $this->cream();
        $pdf->SetXY($w - 120, 4);
        $pdf->Cell(106, 6, mb_strtoupper($reportTitle), 0, 0, 'R');

        // Subtitle (right, smaller)
        if ($sub) {
            $pdf->SetFont('Helvetica', '', 7);
            $this->gold();
            $pdf->SetXY($w - 120, 11.5);
            $pdf->Cell(106, 4.5, $sub, 0, 0, 'R');
        }

        $pdf->SetY(28);
    }

    // ── FOOTER — call right before Output / AddPage ───────────────
    // NOTE: never call AddPage() inside tableRow. Instead check Y
    // before printing each row so we never get an orphan page.

    private function pageFooter(): void
    {
        $pdf = $this->pdf;
        $w   = $pdf->GetPageWidth();
        $h   = $pdf->GetPageHeight();

        $this->bgGold();
        $this->borderNone();
        $pdf->Rect(0, $h - 12, $w, 0.7, 'F');

        $pdf->SetFont('Helvetica', '', 6.5);
        $this->mutedText();
        $pdf->SetXY(14, $h - 10);
        $pdf->Cell(($w - 28) / 2, 5, 'CONFIDENTIAL — Election Management System', 0, 0, 'L');
        $pdf->Cell(($w - 28) / 2, 5, 'Page ' . $pdf->PageNo(), 0, 0, 'R');
    }

    // ── SECTION HEADING ──────────────────────────────────────────

    private function sectionHeading(string $text, float $marginTop = 6): void
    {
        $pdf = $this->pdf;
        $w   = $pdf->GetPageWidth() - 28;

        $pdf->Ln($marginTop);
        $y = $pdf->GetY();

        // Background
        $this->bgViolet();
        $this->borderNone();
        $pdf->Rect(14, $y, $w, 8, 'F');

        // Gold left bar
        $this->bgGold();
        $pdf->Rect(14, $y, 3.5, 8, 'F');

        // Text
        $pdf->SetFont('Helvetica', 'B', 8);
        $this->cream();
        $pdf->SetXY(20, $y);
        $pdf->Cell($w - 6, 8, mb_strtoupper($text), 0, 1, 'L');

        // Gold bottom rule
        $this->bgGold();
        $this->borderNone();
        $pdf->Rect(14, $pdf->GetY(), $w, 0.5, 'F');

        $pdf->Ln(3);
    }

    // ── KPI TILE ─────────────────────────────────────────────────

    private function kpiTile(
        float $x, float $y, float $bw, float $bh,
        string $label, string $value,
        bool $dark = false,
        array $icon_color = []
    ): void {
        $pdf = $this->pdf;

        if ($dark) {
            $this->bgViolet();
        } else {
            $this->bgWhite();
        }
        $this->borderGold();
        $pdf->SetLineWidth(0.5);
        $pdf->Rect($x, $y, $bw, $bh, 'FD');
        $pdf->SetLineWidth(0.2);

        // Gold top bar
        $this->bgGold();
        $this->borderNone();
        $pdf->Rect($x, $y, $bw, 2, 'F');

        // Value
        $pdf->SetFont('Helvetica', 'B', 17);
        if ($dark) {
            if ($icon_color) {
                $pdf->SetTextColor(...$icon_color);
            } else {
                $this->gold();
            }
        } else {
            $this->bgViolet();
            $pdf->SetTextColor(56, 0, 65);
        }
        $pdf->SetXY($x, $y + 5);
        $pdf->Cell($bw, 9, $value, 0, 0, 'C');

        // Label
        $pdf->SetFont('Helvetica', '', 6.5);
        if ($dark) { $this->cream(); } else { $this->mutedText(); }
        $pdf->SetXY($x, $y + 14.5);
        $pdf->Cell($bw, 4, mb_strtoupper($label), 0, 0, 'C');
    }

    // ── PROGRESS BAR ─────────────────────────────────────────────

    private function progressBar(float $pct, string $label = '', float $h = 6): void
    {
        $pdf  = $this->pdf;
        $w    = $pdf->GetPageWidth() - 28;
        $x    = 14;
        $y    = $pdf->GetY();

        // Track
        $pdf->SetFillColor(230, 218, 242);
        $this->borderNone();
        $pdf->Rect($x, $y, $w, $h, 'F');

        // Fill (gold gradient effect — two rects)
        $fillW = max(0, $w * min($pct, 100) / 100);
        $this->bgGold();
        $pdf->Rect($x, $y, $fillW, $h, 'F');

        // Overlay label
        if ($label) {
            $pdf->SetFont('Helvetica', 'B', 7);
            $pdf->SetTextColor(30, 0, 37);
            $pdf->SetXY($x + 3, $y + 0.5);
            $pdf->Cell($w - 6, $h - 1, $label, 0, 0, 'L');
        }

        $pdf->SetY($y + $h + 2);
    }

    // ── TABLE HEADER ─────────────────────────────────────────────

    private function tableHeader(array $cols): void
    {
        $pdf = $this->pdf;

        $this->bgMid();
        $this->borderNone();

        foreach ($cols as $col) {
            $pdf->SetFont('Helvetica', 'B', 7);
            $this->cream();
            $pdf->Cell($col['w'], 7, mb_strtoupper($col['label']), 0, 0, $col['align'] ?? 'L', true);
        }
        $pdf->Ln();

        // Gold rule under header
        $totalW = array_sum(array_column($cols, 'w'));
        $this->bgGold();
        $this->borderNone();
        $pdf->SetX(14);
        $pdf->Rect(14, $pdf->GetY(), $totalW, 0.8, 'F');
        $pdf->Ln(1);
    }

    // ── TABLE ROW ────────────────────────────────────────────────
    // No AddPage() calls here — callers check Y before invoking.

    private function tableRow(array $cells, array $cols, bool $odd = true): void
    {
        $pdf = $this->pdf;

        if ($odd) {
            $this->bgWhite();
        } else {
            $this->bgStripe();
        }
        $this->borderLight();
        $pdf->SetLineWidth(0.15);
        $pdf->SetX(14);

        foreach ($cells as $i => $cell) {
            $style = $cell['bold'] ?? false ? 'B' : '';
            $pdf->SetFont('Helvetica', $style, 7.5);

            if (!empty($cell['color'])) {
                $pdf->SetTextColor(...$cell['color']);
            } else {
                $this->darkText();
            }

            $align = $cols[$i]['align'] ?? 'L';
            $pdf->Cell($cols[$i]['w'], 6.5, $cell['text'], 'B', 0, $align, true);
        }
        $pdf->Ln();
        $pdf->SetLineWidth(0.2);
    }

    // ── PAGE BREAK CHECK ─────────────────────────────────────────
    // Returns true if a new page was added (caller should re-print header).

    private function checkPageBreak(array $cols, string $reportTitle = '', string $sub = ''): bool
    {
        if ($this->pdf->GetY() > ($this->pdf->GetPageHeight() - 30)) {
            $this->pageFooter();
            $this->pdf->AddPage();
            $this->pageHeader($reportTitle, $sub);
            $this->tableHeader($cols);
            return true;
        }
        return false;
    }

    // ── WINNER CALLOUT BANNER ────────────────────────────────────

    private function winnerBanner(string $name, int $votes, float $pct): void
    {
        $pdf = $this->pdf;
        $w   = $pdf->GetPageWidth() - 28;
        $y   = $pdf->GetY() + 1;

        // Gold fill
        $this->bgGoldLight();
        $this->borderGold();
        $pdf->SetLineWidth(0.5);
        $pdf->Rect(14, $y, $w, 8, 'FD');
        $pdf->SetLineWidth(0.2);

        // Left violet bar
        $this->bgViolet();
        $this->borderNone();
        $pdf->Rect(14, $y, 3.5, 8, 'F');

        // Trophy icon area
        $this->bgGold();
        $pdf->Rect(17.5, $y, 10, 8, 'F');
        $pdf->SetFont('Helvetica', 'B', 7);
        $pdf->SetTextColor(56, 0, 65);
        $pdf->SetXY(17.5, $y + 1.5);
        $pdf->Cell(10, 5, 'WINNER', 0, 0, 'C');

        // Name & stats
        $pdf->SetFont('Helvetica', 'B', 8.5);
        $this->violet();
        $pdf->SetXY(29, $y + 1.5);
        $pdf->Cell($w - 60, 5,
            mb_strtoupper($name) . '   |   ' . number_format($votes) . ' votes  (' . $pct . '%)',
            0, 1, 'L');

        $pdf->Ln(3);
    }

    // ═════════════════════════════════════════════════════════════
    // 1. OVERALL RESULTS REPORT
    // ═════════════════════════════════════════════════════════════

    public function results(): \Illuminate\Http\Response
    {
        $this->initPdf('P');
        $pdf = $this->pdf;
        $w   = $pdf->GetPageWidth();

        $totalVoters    = User::where('role', 'voter')->count();
        $totalVoted     = CastedVote::distinct('voter_id')->count('voter_id');
        $notVoted       = max(0, $totalVoters - $totalVoted);
        $turnoutPct     = $totalVoters > 0 ? round(($totalVoted / $totalVoters) * 100, 1) : 0;
        $electionStatus = ElectionSetting::status();

        $positions = Position::with([
            'candidates' => fn($q) => $q->withCount('votes')->orderByDesc('votes_count'),
        ])->get();

        // ══════════════════════════════════════
        // COVER PAGE
        // ══════════════════════════════════════
        $pdf->AddPage();

        // Full-page dark background
        $this->bgDark();
        $this->borderNone();
        $pdf->Rect(0, 0, $w, $pdf->GetPageHeight(), 'F');

        // Gold horizontal accents
        $this->bgGold();
        $pdf->Rect(0, 55, $w, 2, 'F');
        $pdf->Rect(0, 130, $w, 2, 'F');

        // Left gold sidebar
        $pdf->Rect(0, 0, 6, $pdf->GetPageHeight(), 'F');

        // Watermark-style large circle (violet)
        $this->bgMid();
        $pdf->Rect($w - 90, -20, 110, 110, 'F'); // faux circle with large border-radius via solid

        // ── Election name (big) ──
        $pdf->SetFont('Helvetica', 'B', 24);
        $this->gold();
        $pdf->SetXY(10, 20);
        $pdf->Cell($w - 10, 14, mb_strtoupper($this->electionName), 0, 1, 'C');

        // ── Report type ──
        $pdf->SetFont('Helvetica', '', 11);
        $this->cream();
        $pdf->SetXY(10, 36);
        $pdf->Cell($w - 10, 8, 'OFFICIAL ELECTION RESULTS REPORT', 0, 1, 'C');

        // ── Date ──
        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetTextColor(180, 150, 210);
        $pdf->SetXY(10, 44);
        $pdf->Cell($w - 10, 6, now()->format('l, F j, Y   —   H:i:s'), 0, 1, 'C');

        // ── Status pill ──
        $statusLabel = match($electionStatus) {
            'ongoing' => '● ELECTION IS LIVE',
            'ended'   => '✓ ELECTION CONCLUDED',
            default   => '◷ UPCOMING ELECTION',
        };
        $statusColor = match($electionStatus) {
            'ongoing' => [20, 140, 80],
            'ended'   => [56, 0, 65],
            default   => [180, 130, 0],
        };
        $pdf->SetFont('Helvetica', 'B', 9);
        $pdf->SetTextColor(...$statusColor);
        $pdf->SetXY(10, 60);
        $pdf->Cell($w - 10, 7, $statusLabel, 0, 1, 'C');

        // ── KPI tiles on cover ──
        $kpiY  = 80;
        $kpiW  = ($w - 28 - 9) / 4;
        $kpiH  = 30;

        $this->kpiTile(14,                    $kpiY, $kpiW, $kpiH, 'Registered Voters',  number_format($totalVoters), false);
        $this->kpiTile(14 + ($kpiW + 3),      $kpiY, $kpiW, $kpiH, 'Votes Cast',         number_format($totalVoted),  true,  [249,180,15]);
        $this->kpiTile(14 + ($kpiW + 3) * 2,  $kpiY, $kpiW, $kpiH, 'Did Not Vote',       number_format($notVoted),    false);
        $this->kpiTile(14 + ($kpiW + 3) * 3,  $kpiY, $kpiW, $kpiH, 'Voter Turnout',      $turnoutPct . '%',           true,  $turnoutPct >= 75 ? [20,160,80] : [249,180,15]);

        $pdf->SetY($kpiY + $kpiH + 8);

        // ── Turnout bar ──
        $pdf->SetFont('Helvetica', 'B', 7.5);
        $this->gold();
        $pdf->SetX(14);
        $pdf->Cell($w - 28, 5, 'VOTER PARTICIPATION', 0, 1, 'L');
        $this->progressBar(
            $turnoutPct,
            $turnoutPct . '% — ' . number_format($totalVoted) . ' of ' . number_format($totalVoters) . ' voters',
            9
        );

        // ── Position summary table on cover ──
        $pdf->Ln(4);
        $pdf->SetFont('Helvetica', 'B', 8);
        $this->gold();
        $pdf->SetX(14);
        $pdf->Cell($w - 28, 5, 'POSITION SUMMARY', 0, 1, 'L');
        $pdf->Ln(1);

        // Mini table — one row per position showing leading candidate
        $cols = [
            ['label' => 'Position',         'w' => 55, 'align' => 'L'],
            ['label' => 'Leading Candidate', 'w' => 60, 'align' => 'L'],
            ['label' => 'Votes',            'w' => 22, 'align' => 'C'],
            ['label' => 'Share',            'w' => 20, 'align' => 'C'],
            ['label' => 'Candidates',       'w' => 18, 'align' => 'C'],
        ];
        $this->tableHeader($cols);

        foreach ($positions as $idx => $pos) {
            $leader   = $pos->candidates->first();
            $posTotal = $pos->candidates->sum('votes_count');
            $share    = $posTotal > 0 && $leader ? round(($leader->votes_count / $posTotal) * 100, 1) : 0;

            $cells = [
                ['text' => $pos->name,                                     'bold' => false],
                ['text' => $leader ? $leader->full_name : '(No votes yet)', 'bold' => (bool)$leader, 'color' => $leader ? [56,0,65] : [160,140,180]],
                ['text' => number_format($leader?->votes_count ?? 0),      'bold' => true],
                ['text' => $share . '%',                                   'bold' => false],
                ['text' => $pos->candidates->count(),                      'bold' => false],
            ];

            $this->checkPageBreak($cols, 'Election Results', $this->electionName);
            $this->tableRow($cells, $cols, $idx % 2 === 0);
        }

        $this->pageFooter();

        // ══════════════════════════════════════
        // DETAILED RESULTS — one section per position
        // ══════════════════════════════════════
        $pdf->AddPage();
        $this->pageHeader('Election Results — Detailed', $this->electionName);

        foreach ($positions as $posIdx => $position) {
            $candidates = $position->candidates;
            $maxVotes   = $candidates->max('votes_count') ?: 1;
            $posTotal   = $candidates->sum('votes_count');

            // Section heading
            $this->sectionHeading('Position: ' . $position->name, $posIdx === 0 ? 0 : 6);

            $cols = [
                ['label' => 'Rank',       'w' => 10, 'align' => 'C'],
                ['label' => 'Candidate',  'w' => 60, 'align' => 'L'],
                ['label' => 'Party List', 'w' => 40, 'align' => 'L'],
                ['label' => 'College',    'w' => 35, 'align' => 'L'],
                ['label' => 'Votes',      'w' => 20, 'align' => 'C'],
                ['label' => '% of Pos.',  'w' => 17, 'align' => 'C'],
            ];
            $this->tableHeader($cols);

            foreach ($candidates as $idx => $c) {
                $pct     = $posTotal > 0 ? round(($c->votes_count / $posTotal) * 100, 1) : 0;
                $isFirst = $idx === 0;

                $this->checkPageBreak($cols, 'Election Results — Detailed', $this->electionName);

                $cells = [
                    ['text' => '#' . ($idx + 1),                                    'bold' => $isFirst, 'color' => $isFirst ? [249,180,15] : null],
                    ['text' => $c->full_name,                                        'bold' => $isFirst, 'color' => $isFirst ? [56,0,65]   : null],
                    ['text' => $c->partylist?->name ?? '—',                          'bold' => false],
                    ['text' => $c->college?->acronym ?? $c->college?->name ?? '—',  'bold' => false],
                    ['text' => number_format($c->votes_count),                       'bold' => $isFirst, 'color' => $isFirst ? [20,100,50] : null],
                    ['text' => $pct . '%',                                           'bold' => false],
                ];
                $this->tableRow($cells, $cols, $idx % 2 === 0);

                // Inline vote-share bar in the Votes column
                if ($c->votes_count > 0 && $maxVotes > 0) {
                    $rowY   = $pdf->GetY() - 1;
                    $barX   = 14 + 10 + 60 + 40 + 35;
                    $barW   = 20;
                    $barH   = 1.4;
                    $fillW  = $barW * ($c->votes_count / $maxVotes);
                    $this->bgGold();
                    $this->borderNone();
                    $pdf->Rect($barX, $rowY - $barH, $fillW, $barH, 'F');
                }
            }

            // Winner callout
            if ($candidates->isNotEmpty() && ($winner = $candidates->first()) && $winner->votes_count > 0) {
                $winPct = $posTotal > 0 ? round(($winner->votes_count / $posTotal) * 100, 1) : 0;
                $this->winnerBanner($winner->full_name, $winner->votes_count, $winPct);
            } else {
                $pdf->Ln(3);
            }
        }

        $this->pageFooter();

        return response($pdf->Output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="election-results-' . now()->format('Y-m-d-His') . '.pdf"');
    }

    // ═════════════════════════════════════════════════════════════
    // 2. PER-COLLEGE BREAKDOWN REPORT
    // ═════════════════════════════════════════════════════════════

    public function byCollege(): \Illuminate\Http\Response
    {
        $this->initPdf('P');
        $pdf = $this->pdf;
        $w   = $pdf->GetPageWidth();

        $colleges    = College::with([
            'voters',
            'candidates' => fn($q) => $q->with(['position', 'partylist'])->withCount('votes'),
        ])->orderBy('name')->get();

        $totalVoters = User::where('role', 'voter')->count();
        $totalVoted  = CastedVote::distinct('voter_id')->count('voter_id');

        $pdf->AddPage();
        $this->pageHeader('College Breakdown Report', $this->electionName);

        // Summary KPIs
        $kpiY = $pdf->GetY();
        $kpiW = ($w - 28 - 6) / 3;
        $this->kpiTile(14,               $kpiY, $kpiW, 22, 'Total Colleges',    $colleges->count(), false);
        $this->kpiTile(14 + $kpiW + 3,   $kpiY, $kpiW, 22, 'Registered Voters', number_format($totalVoters), true);
        $this->kpiTile(14 + ($kpiW+3)*2, $kpiY, $kpiW, 22, 'Ballots Cast',      number_format($totalVoted), false);
        $pdf->SetY($kpiY + 28);

        foreach ($colleges as $college) {
            $voters      = $college->voters;
            $votersCount = $voters->count();
            $votedCount  = $voters->filter(fn($v) => $v->hasVoted())->count();
            $turnout     = $votersCount > 0 ? round(($votedCount / $votersCount) * 100, 1) : 0;

            // Page break before each college section
            if ($pdf->GetY() > ($pdf->GetPageHeight() - 70)) {
                $this->pageFooter();
                $pdf->AddPage();
                $this->pageHeader('College Breakdown Report', $this->electionName);
            }

            // ── College banner ──
            $pdf->Ln(4);
            $bannerY = $pdf->GetY();
            $this->bgViolet();
            $this->borderNone();
            $pdf->Rect(14, $bannerY, $w - 28, 12, 'F');
            $this->bgGold();
            $pdf->Rect(14, $bannerY, 4, 12, 'F');

            // College name
            $pdf->SetFont('Helvetica', 'B', 10);
            $this->gold();
            $pdf->SetXY(21, $bannerY + 2);
            $pdf->Cell(90, 6, mb_strtoupper($college->name), 0, 0, 'L');

            // Mini stats (right side of banner)
            $pdf->SetFont('Helvetica', '', 7.5);
            $this->cream();
            $pdf->SetXY($w - 100, $bannerY + 2);
            $pdf->Cell(86, 6,
                'Voters: ' . $votersCount . '  |  Voted: ' . $votedCount . '  |  Turnout: ' . $turnout . '%',
                0, 1, 'R');

            $pdf->SetY($bannerY + 14);

            // Turnout progress bar
            $this->progressBar($turnout, $turnout . '% voter turnout', 5);
            $pdf->Ln(2);

            // Candidates table
            $candidates = $college->candidates->sortBy(fn($c) => $c->position?->sort_order ?? 999);

            if ($candidates->isEmpty()) {
                $pdf->SetFont('Helvetica', 'I', 7.5);
                $this->mutedText();
                $pdf->SetX(14);
                $pdf->Cell($w - 28, 7, 'No candidates registered for this college.', 0, 1, 'C');
                continue;
            }

            $cols = [
                ['label' => 'Candidate',   'w' => 62, 'align' => 'L'],
                ['label' => 'Position',    'w' => 42, 'align' => 'L'],
                ['label' => 'Party List',  'w' => 38, 'align' => 'L'],
                ['label' => 'Course',      'w' => 22, 'align' => 'L'],
                ['label' => 'Votes',       'w' => 18, 'align' => 'C'],
            ];
            $this->tableHeader($cols);

            foreach ($candidates as $idx => $c) {
                $this->checkPageBreak($cols, 'College Breakdown Report', $this->electionName);
                $cells = [
                    ['text' => $c->full_name,               'bold' => false],
                    ['text' => $c->position?->name ?? '—',  'bold' => false],
                    ['text' => $c->partylist?->name ?? '—', 'bold' => false],
                    ['text' => $c->course ?? '—',           'bold' => false],
                    ['text' => number_format($c->votes_count), 'bold' => true,
                     'color' => $c->votes_count > 0 ? [56,0,65] : [170,150,190]],
                ];
                $this->tableRow($cells, $cols, $idx % 2 === 0);
            }
        }

        $this->pageFooter();

        return response($pdf->Output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="college-breakdown-' . now()->format('Y-m-d-His') . '.pdf"');
    }

    // ═════════════════════════════════════════════════════════════
    // 3. VOTER TURNOUT REPORT
    // ═════════════════════════════════════════════════════════════

    public function turnout(): \Illuminate\Http\Response
    {
        $this->initPdf('P');
        $pdf = $this->pdf;
        $w   = $pdf->GetPageWidth();

        $colleges    = College::with('voters')->orderBy('name')->get();
        $totalVoters = User::where('role', 'voter')->count();
        $totalVoted  = CastedVote::distinct('voter_id')->count('voter_id');
        $notVoted    = max(0, $totalVoters - $totalVoted);
        $overallPct  = $totalVoters > 0 ? round(($totalVoted / $totalVoters) * 100, 1) : 0;

        $pdf->AddPage();
        $this->pageHeader('Voter Turnout Report', $this->electionName);

        // KPIs
        $kpiY = $pdf->GetY();
        $kpiW = ($w - 28 - 9) / 4;
        $this->kpiTile(14,                 $kpiY, $kpiW, 24, 'Registered',  number_format($totalVoters), false);
        $this->kpiTile(14 + ($kpiW+3),     $kpiY, $kpiW, 24, 'Voted',       number_format($totalVoted),  true,  [249,180,15]);
        $this->kpiTile(14 + ($kpiW+3)*2,   $kpiY, $kpiW, 24, 'Not Yet',     number_format($notVoted),    false);
        $this->kpiTile(14 + ($kpiW+3)*3,   $kpiY, $kpiW, 24, 'Turnout',     $overallPct . '%',           true,
            $overallPct >= 75 ? [20,160,80] : ($overallPct >= 50 ? [180,120,0] : [180,40,40])
        );
        $pdf->SetY($kpiY + 30);

        // Overall bar
        $this->sectionHeading('Overall Voter Participation', 2);
        $this->progressBar(
            $overallPct,
            $overallPct . '%  —  ' . number_format($totalVoted) . ' of ' . number_format($totalVoters) . ' voters participated',
            10
        );

        // Per-college table
        $this->sectionHeading('Turnout by College');

        $cols = [
            ['label' => 'College',           'w' => 62, 'align' => 'L'],
            ['label' => 'Acronym',           'w' => 22, 'align' => 'C'],
            ['label' => 'Registered',        'w' => 26, 'align' => 'C'],
            ['label' => 'Voted',             'w' => 20, 'align' => 'C'],
            ['label' => 'Not Voted',         'w' => 22, 'align' => 'C'],
            ['label' => 'Turnout %',         'w' => 30, 'align' => 'C'],
        ];
        $this->tableHeader($cols);

        foreach ($colleges as $idx => $college) {
            $cv    = $college->voters->count();
            $voted = $college->voters->filter(fn($v) => $v->hasVoted())->count();
            $notV  = max(0, $cv - $voted);
            $pct   = $cv > 0 ? round(($voted / $cv) * 100, 1) : 0.0;

            $pctColor = $pct >= 75 ? [20,120,60] : ($pct >= 50 ? [140,90,0] : [160,30,30]);

            $this->checkPageBreak($cols, 'Voter Turnout Report', $this->electionName);

            $cells = [
                ['text' => $college->name,          'bold' => false],
                ['text' => $college->acronym ?? '—','bold' => false],
                ['text' => number_format($cv),      'bold' => false],
                ['text' => number_format($voted),   'bold' => true,  'color' => [56,0,65]],
                ['text' => number_format($notV),    'bold' => false, 'color' => $notV > 0 ? [160,30,30] : null],
                ['text' => $pct . '%',              'bold' => true,  'color' => $pctColor],
            ];
            $this->tableRow($cells, $cols, $idx % 2 === 0);

            // Inline mini bar in last column
            $rowY  = $pdf->GetY() - 1;
            $bX    = 14 + 62 + 22 + 26 + 20 + 22;
            $bW    = 30;
            $bFill = $bW * ($pct / 100);
            $this->bgGold();
            $this->borderNone();
            $pdf->Rect($bX, $rowY - 1.4, $bFill, 1.4, 'F');
        }

        // Did-not-vote list
        $notVotedVoters = User::where('role', 'voter')
            ->whereDoesntHave('votes')
            ->with('college')
            ->orderBy('last_name')
            ->get();

        $this->sectionHeading('Voters Who Have Not Yet Cast Their Ballot');

        if ($notVotedVoters->isEmpty()) {
            $pdf->Ln(3);
            // Green success callout
            $this->bgGreen();
            $this->borderGreen();
            $pdf->SetLineWidth(0.5);
            $pdf->SetX(14);
            $pdf->Rect(14, $pdf->GetY(), $w - 28, 10, 'FD');
            $pdf->SetFont('Helvetica', 'B', 8.5);
            $this->greenText();
            $pdf->SetXY(14, $pdf->GetY() + 2);
            $pdf->Cell($w - 28, 6, '✓  All registered voters have cast their ballots — 100% participation!', 0, 1, 'C');
            $pdf->SetLineWidth(0.2);
        } else {
            $cols2 = [
                ['label' => '#',            'w' => 8,  'align' => 'C'],
                ['label' => 'Full Name',    'w' => 64, 'align' => 'L'],
                ['label' => 'Student No.', 'w' => 30,  'align' => 'L'],
                ['label' => 'College',     'w' => 34,  'align' => 'L'],
                ['label' => 'Course',      'w' => 30,  'align' => 'L'],
                ['label' => 'Year',        'w' => 12,  'align' => 'C'],
            ];
            $this->tableHeader($cols2);

            foreach ($notVotedVoters as $idx => $v) {
                $this->checkPageBreak($cols2, 'Voter Turnout Report', $this->electionName);
                $cells2 = [
                    ['text' => $idx + 1,                                            'bold' => false],
                    ['text' => $v->full_name,                                       'bold' => false],
                    ['text' => $v->student_number ?? '—',                           'bold' => false],
                    ['text' => $v->college?->acronym ?? $v->college?->name ?? '—', 'bold' => false],
                    ['text' => $v->course ?? '—',                                  'bold' => false],
                    ['text' => $v->year_level ?? '—',                              'bold' => false],
                ];
                $this->tableRow($cells2, $cols2, $idx % 2 === 0);
            }
        }

        $this->pageFooter();

        return response($pdf->Output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="voter-turnout-' . now()->format('Y-m-d-His') . '.pdf"');
    }

    // ═════════════════════════════════════════════════════════════
    // 4. FULL BALLOT LOG REPORT
    // ═════════════════════════════════════════════════════════════

    public function ballots(Request $request): \Illuminate\Http\Response
    {
        $this->initPdf('L');
        $pdf = $this->pdf;
        $w   = $pdf->GetPageWidth();

        $transactions = CastedVote::query()
            ->selectRaw('
                MIN(casted_vote_id)    AS casted_vote_id,
                transaction_number,
                voter_id,
                MIN(voted_at)          AS voted_at,
                COUNT(*)               AS positions_count,
                SUM(CASE WHEN candidate_id IS NOT NULL THEN 1 ELSE 0 END) AS positions_voted
            ')
            ->groupBy('transaction_number', 'voter_id')
            ->orderBy('voted_at')
            ->get();

        $voterIds = $transactions->pluck('voter_id')->unique()->filter();
        $voters   = User::whereIn('id', $voterIds)->with('college')->get()->keyBy('id');

        $pdf->AddPage();
        $this->pageHeader('Ballot Transaction Log', $this->electionName);

        $kpiY = $pdf->GetY();
        $kpiW = ($w - 28 - 9) / 4;
        $this->kpiTile(14,                $kpiY, $kpiW, 22, 'Total Ballots',
            number_format($transactions->count()), true);
        $this->kpiTile(14 + ($kpiW+3),    $kpiY, $kpiW, 22, 'First Ballot',
            $transactions->first()?->voted_at
                ? \Carbon\Carbon::parse($transactions->first()->voted_at)->format('M d, Y H:i')
                : '—',
            false);
        $this->kpiTile(14 + ($kpiW+3)*2,  $kpiY, $kpiW, 22, 'Latest Ballot',
            $transactions->last()?->voted_at
                ? \Carbon\Carbon::parse($transactions->last()->voted_at)->format('M d, Y H:i')
                : '—',
            false);
        $this->kpiTile(14 + ($kpiW+3)*3,  $kpiY, $kpiW, 22, 'Election Status',
            mb_strtoupper(ElectionSetting::status()), true);
        $pdf->SetY($kpiY + 28);

        $this->sectionHeading('All Submitted Ballots', 2);

        $cols = [
            ['label' => '#',               'w' => 8,  'align' => 'C'],
            ['label' => 'Transaction No.', 'w' => 50, 'align' => 'L'],
            ['label' => 'Voter Name',      'w' => 58, 'align' => 'L'],
            ['label' => 'Student No.',     'w' => 32, 'align' => 'L'],
            ['label' => 'College',         'w' => 30, 'align' => 'L'],
            ['label' => 'Positions Voted', 'w' => 28, 'align' => 'C'],
            ['label' => 'Out Of',          'w' => 18, 'align' => 'C'],
            ['label' => 'Date & Time',     'w' => 44, 'align' => 'L'],
        ];
        $this->tableHeader($cols);

        foreach ($transactions as $idx => $tx) {
            $this->checkPageBreak($cols, 'Ballot Transaction Log', $this->electionName);
            $voter = $voters->get($tx->voter_id);
            $cells = [
                ['text' => $idx + 1,                                             'bold' => false],
                ['text' => $tx->transaction_number ?? '—',                       'bold' => false, 'color' => [56,0,65]],
                ['text' => $voter?->full_name ?? 'Unknown',                      'bold' => false],
                ['text' => $voter?->student_number ?? '—',                       'bold' => false],
                ['text' => $voter?->college?->acronym ?? $voter?->college?->name ?? '—', 'bold' => false],
                ['text' => number_format((int)$tx->positions_voted),             'bold' => true],
                ['text' => number_format((int)$tx->positions_count),             'bold' => false],
                ['text' => $tx->voted_at
                    ? \Carbon\Carbon::parse($tx->voted_at)->format('M d, Y H:i')
                    : '—',                                                        'bold' => false],
            ];
            $this->tableRow($cells, $cols, $idx % 2 === 0);
        }

        $this->pageFooter();

        return response($pdf->Output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="ballot-log-' . now()->format('Y-m-d-His') . '.pdf"');
    }

    // ═════════════════════════════════════════════════════════════
    // 5. CANDIDATE SUMMARY REPORT
    // ═════════════════════════════════════════════════════════════

    public function candidates(): \Illuminate\Http\Response
    {
        $this->initPdf('L');
        $pdf = $this->pdf;
        $w   = $pdf->GetPageWidth();

        $candidates = Candidate::with(['position', 'partylist', 'college', 'organization'])
            ->withCount('votes')
            ->orderBy('position_id')
            ->orderByDesc('votes_count')
            ->get();

        $pdf->AddPage();
        $this->pageHeader('Candidate Summary Report', $this->electionName);

        $kpiY = $pdf->GetY();
        $kpiW = ($w - 28 - 9) / 4;
        $this->kpiTile(14,                $kpiY, $kpiW, 22, 'Total Candidates', $candidates->count(), false);
        $this->kpiTile(14 + ($kpiW+3),    $kpiY, $kpiW, 22, 'Positions',        Position::count(), true);
        $this->kpiTile(14 + ($kpiW+3)*2,  $kpiY, $kpiW, 22, 'Party Lists',      \App\Models\Partylist::count(), false);
        $this->kpiTile(14 + ($kpiW+3)*3,  $kpiY, $kpiW, 22, 'Total Votes Cast', number_format($candidates->sum('votes_count')), true, [249,180,15]);
        $pdf->SetY($kpiY + 28);

        $this->sectionHeading('All Candidates & Vote Counts', 2);

        $cols = [
            ['label' => '#',            'w' => 8,  'align' => 'C'],
            ['label' => 'Full Name',    'w' => 55, 'align' => 'L'],
            ['label' => 'Position',     'w' => 40, 'align' => 'L'],
            ['label' => 'Party List',   'w' => 38, 'align' => 'L'],
            ['label' => 'College',      'w' => 30, 'align' => 'L'],
            ['label' => 'Organization', 'w' => 40, 'align' => 'L'],
            ['label' => 'Course',       'w' => 28, 'align' => 'L'],
            ['label' => 'Votes',        'w' => 22, 'align' => 'C'],
        ];
        $this->tableHeader($cols);

        foreach ($candidates as $idx => $c) {
            $this->checkPageBreak($cols, 'Candidate Summary Report', $this->electionName);
            $cells = [
                ['text' => $idx + 1,                                             'bold' => false],
                ['text' => $c->full_name,                                        'bold' => false],
                ['text' => $c->position?->name ?? '—',                          'bold' => false],
                ['text' => $c->partylist?->name ?? '—',                         'bold' => false],
                ['text' => $c->college?->acronym ?? $c->college?->name ?? '—', 'bold' => false],
                ['text' => $c->organization?->name ?? '—',                      'bold' => false],
                ['text' => $c->course ?? '—',                                   'bold' => false],
                ['text' => number_format($c->votes_count),                      'bold' => true,
                 'color' => $c->votes_count > 0 ? [56,0,65] : [170,150,190]],
            ];
            $this->tableRow($cells, $cols, $idx % 2 === 0);
        }

        $this->pageFooter();

        return response($pdf->Output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="candidates-summary-' . now()->format('Y-m-d-His') . '.pdf"');
    }
}