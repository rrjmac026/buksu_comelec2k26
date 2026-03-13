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
    // ── Design Tokens (mirrors the gold/violet UI theme) ──────────────────
    // Gold:   249, 180, 15   (#f9b40f)
    // Violet: 56,  0,   65   (#380041)
    // Violet dark: 30, 0, 37 (#1e0025)
    // Cream:  255, 251, 240  (#fffbf0)
    // Dim:    82,  0,   96   (#520060)

    private \FPDF $pdf;

    // ── Colour helpers ─────────────────────────────────────────────────────

    private function setGold()   { $this->pdf->SetTextColor(249, 180, 15); }
    private function setCream()  { $this->pdf->SetTextColor(255, 251, 240); }
    private function setViolet() { $this->pdf->SetTextColor(56,  0,   65); }
    private function setDark()   { $this->pdf->SetTextColor(20,  0,   28); }
    private function setGray()   { $this->pdf->SetTextColor(120, 100, 130); }

    private function fillViolet() { $this->pdf->SetFillColor(56, 0, 65); }
    private function fillVioletDark() { $this->pdf->SetFillColor(30, 0, 37); }
    private function fillVioletMid()  { $this->pdf->SetFillColor(82, 0, 96); }
    private function fillGold()   { $this->pdf->SetFillColor(249, 180, 15); }
    private function fillCream()  { $this->pdf->SetFillColor(255, 251, 240); }
    private function fillLight()  { $this->pdf->SetFillColor(240, 230, 250); }
    private function fillWhite()  { $this->pdf->SetFillColor(255, 255, 255); }

    private function borderGold()   { $this->pdf->SetDrawColor(249, 180, 15); }
    private function borderViolet() { $this->pdf->SetDrawColor(56, 0, 65); }
    private function borderLight()  { $this->pdf->SetDrawColor(200, 180, 210); }
    private function borderNone()   { $this->pdf->SetDrawColor(255, 255, 255); }

    // ── Page setup ────────────────────────────────────────────────────────

    private function initPdf(string $orientation = 'P'): void
    {
        $this->pdf = new \FPDF($orientation, 'mm', 'A4');
        $this->pdf->SetMargins(15, 15, 15);
        $this->pdf->SetAutoPageBreak(true, 20);
        $this->pdf->SetCreator('Election Management System');
        $this->pdf->SetAuthor('EMS Admin');
    }

    // ── Shared header printed on each new page ────────────────────────────

    private function pageHeader(string $title, string $subtitle = ''): void
    {
        $pdf = $this->pdf;
        $w   = $pdf->GetPageWidth();

        // Dark violet banner
        $this->fillVioletDark();
        $this->borderNone();
        $pdf->Rect(0, 0, $w, 28, 'F');

        // Gold accent line
        $this->fillGold();
        $pdf->Rect(0, 28, $w, 1.2, 'F');

        // App name (left)
        $pdf->SetFont('Helvetica', 'B', 9);
        $this->setGold();
        $pdf->SetXY(15, 8);
        $electionName = ElectionSetting::get('election_name', 'Student Council Election');
        $pdf->Cell(100, 5, strtoupper($electionName), 0, 0, 'L');

        // Title (right)
        $pdf->SetFont('Helvetica', 'B', 10);
        $this->setCream();
        $pdf->SetXY($w - 110, 6);
        $pdf->Cell(95, 6, strtoupper($title), 0, 0, 'R');

        if ($subtitle) {
            $pdf->SetFont('Helvetica', '', 7.5);
            $this->setGold();
            $pdf->SetXY($w - 110, 13);
            $pdf->Cell(95, 5, $subtitle, 0, 0, 'R');
        }

        // Date/time stamp
        $pdf->SetFont('Helvetica', '', 7);
        $pdf->SetTextColor(180, 160, 200);
        $pdf->SetXY(15, 13);
        $pdf->Cell(80, 5, 'Generated: ' . now()->format('F j, Y  H:i:s'), 0, 0, 'L');

        $pdf->SetY(34);
    }

    // ── Shared footer ─────────────────────────────────────────────────────

    private function pageFooter(): void
    {
        $pdf = $this->pdf;
        $w   = $pdf->GetPageWidth();
        $h   = $pdf->GetPageHeight();

        // Gold line
        $this->fillGold();
        $this->borderNone();
        $pdf->Rect(0, $h - 14, $w, 0.8, 'F');

        // Footer text
        $pdf->SetFont('Helvetica', '', 7);
        $pdf->SetTextColor(120, 100, 140);
        $pdf->SetXY(15, $h - 12);
        $pdf->Cell(($w - 30) / 2, 5, 'CONFIDENTIAL — Election Management System', 0, 0, 'L');
        $pdf->Cell(($w - 30) / 2, 5, 'Page ' . $pdf->PageNo(), 0, 0, 'R');
    }

    // ── Section heading ───────────────────────────────────────────────────

    private function sectionHeading(string $text, bool $fullWidth = true): void
    {
        $pdf = $this->pdf;
        $w   = $fullWidth ? ($pdf->GetPageWidth() - 30) : 85;

        $this->fillViolet();
        $this->borderNone();
        $pdf->SetX(15);
        $pdf->Rect(15, $pdf->GetY(), $w, 7, 'F');

        // Gold left bar
        $this->fillGold();
        $pdf->Rect(15, $pdf->GetY(), 3, 7, 'F');

        $pdf->SetFont('Helvetica', 'B', 8.5);
        $this->setCream();
        $pdf->SetX(20);
        $pdf->Cell($w - 5, 7, strtoupper($text), 0, 1, 'L');
        $pdf->Ln(2);
    }

    // ── Stat box (small KPI card) ─────────────────────────────────────────

    private function statBox(float $x, float $y, float $bw, float $bh, string $label, string $value, bool $highlight = false): void
    {
        $pdf = $this->pdf;

        if ($highlight) {
            $this->fillViolet();
        } else {
            $this->fillLight();
        }
        $this->borderGold();
        $pdf->SetLineWidth(0.4);
        $pdf->Rect($x, $y, $bw, $bh, 'FD');

        // Gold top accent bar
        $this->fillGold();
        $this->borderNone();
        $pdf->Rect($x, $y, $bw, 1.2, 'F');

        // Value
        $pdf->SetFont('Helvetica', 'B', 16);
        if ($highlight) {
            $this->setGold();
        } else {
            $this->setViolet();
        }
        $pdf->SetXY($x, $y + 5);
        $pdf->Cell($bw, 8, $value, 0, 0, 'C');

        // Label
        $pdf->SetFont('Helvetica', '', 7);
        if ($highlight) {
            $this->setCream();
        } else {
            $this->setGray();
        }
        $pdf->SetXY($x, $y + 13);
        $pdf->Cell($bw, 5, strtoupper($label), 0, 0, 'C');

        $pdf->SetLineWidth(0.2);
    }

    // ── Table header row ──────────────────────────────────────────────────

    private function tableHeader(array $cols): void
    {
        $pdf = $this->pdf;

        $this->fillVioletMid();
        $this->borderNone();

        foreach ($cols as $col) {
            $pdf->SetFont('Helvetica', 'B', 7.5);
            $this->setCream();
            $pdf->Cell($col['w'], 6.5, strtoupper($col['label']), 0, 0, $col['align'] ?? 'L', true);
        }
        $pdf->Ln();

        // Gold underline
        $totalW = array_sum(array_column($cols, 'w'));
        $this->fillGold();
        $pdf->SetX(15);
        $pdf->Rect(15, $pdf->GetY(), $totalW, 0.6, 'F');
        $pdf->Ln(1);
    }

    // ── Table body row ────────────────────────────────────────────────────

    private function tableRow(array $cells, array $cols, bool $odd = true): void
    {
        $pdf = $this->pdf;

        if ($odd) {
            $this->fillWhite();
        } else {
            $pdf->SetFillColor(245, 238, 252);
        }

        // Check page break
        if ($pdf->GetY() > ($pdf->GetPageHeight() - 30)) {
            $this->pageFooter();
            $pdf->AddPage();
            $this->pageHeader('', '');
            $this->tableHeader($cols);
        }

        $this->borderLight();
        $pdf->SetX(15);
        foreach ($cells as $i => $cell) {
            $pdf->SetFont('Helvetica', $cell['bold'] ?? false ? 'B' : '', 7.5);
            if (!empty($cell['color'])) {
                $pdf->SetTextColor(...$cell['color']);
            } else {
                $this->setDark();
            }
            $pdf->Cell($cols[$i]['w'], 6, $cell['text'], 'B', 0, $cols[$i]['align'] ?? 'L', true);
        }
        $pdf->Ln();
    }

    // ═════════════════════════════════════════════════════════════════════
    // 1. OVERALL RESULTS REPORT
    // GET /admin/reports/results
    // ═════════════════════════════════════════════════════════════════════

    public function results(): \Illuminate\Http\Response
    {
        $this->initPdf('P');
        $pdf = $this->pdf;

        // ── Data ──
        $totalVoters    = User::where('role', 'voter')->count();
        $totalVoted     = CastedVote::distinct('voter_id')->count('voter_id');
        $notVoted       = max(0, $totalVoters - $totalVoted);
        $turnoutPct     = $totalVoters > 0 ? round(($totalVoted / $totalVoters) * 100, 1) : 0;
        $electionName   = ElectionSetting::get('election_name', 'Student Council Election');
        $electionStatus = ElectionSetting::status();

        $positions = Position::with([
            'candidates' => fn($q) => $q->withCount('votes')->orderByDesc('votes_count'),
        ])->get();

        // ── Page 1: Cover / Summary ──
        $pdf->AddPage();

        // Big violet cover banner
        $w = $pdf->GetPageWidth();
        $this->fillVioletDark();
        $this->borderNone();
        $pdf->Rect(0, 0, $w, 60, 'F');
        $this->fillGold();
        $pdf->Rect(0, 60, $w, 1.5, 'F');

        // Title
        $pdf->SetFont('Helvetica', 'B', 22);
        $this->setGold();
        $pdf->SetXY(0, 14);
        $pdf->Cell($w, 12, strtoupper($electionName), 0, 1, 'C');

        $pdf->SetFont('Helvetica', '', 11);
        $this->setCream();
        $pdf->SetXY(0, 27);
        $pdf->Cell($w, 8, 'OFFICIAL ELECTION RESULTS REPORT', 0, 1, 'C');

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetTextColor(180, 160, 200);
        $pdf->SetXY(0, 37);
        $pdf->Cell($w, 6, 'Generated on ' . now()->format('l, F j, Y  —  H:i:s'), 0, 1, 'C');

        $statusLabel = match($electionStatus) {
            'ongoing' => 'ELECTION IS LIVE',
            'ended'   => 'ELECTION CONCLUDED',
            default   => 'UPCOMING ELECTION',
        };
        $pdf->SetFont('Helvetica', 'B', 8);
        $this->setGold();
        $pdf->SetXY(0, 47);
        $pdf->Cell($w, 6, '● ' . $statusLabel, 0, 1, 'C');

        $pdf->SetY(68);

        // ── KPI tiles ──
        $pdf->Ln(4);
        $kpiY  = $pdf->GetY();
        $kpiW  = 42;
        $kpiH  = 24;
        $kpiGap = 4;
        $kpiX  = 15;

        $this->statBox($kpiX,                    $kpiY, $kpiW, $kpiH, 'Total Voters',   number_format($totalVoters), false);
        $this->statBox($kpiX + ($kpiW+$kpiGap),  $kpiY, $kpiW, $kpiH, 'Votes Cast',     number_format($totalVoted),  true);
        $this->statBox($kpiX + ($kpiW+$kpiGap)*2,$kpiY, $kpiW, $kpiH, 'Abstentions',    number_format($notVoted),    false);
        $this->statBox($kpiX + ($kpiW+$kpiGap)*3,$kpiY, $kpiW, $kpiH, 'Voter Turnout',  $turnoutPct . '%',           true);

        $pdf->SetY($kpiY + $kpiH + 6);

        // ── Turnout progress bar ──
        $barX = 15; $barY = $pdf->GetY(); $barW = $w - 30; $barH = 6;
        $pdf->SetFont('Helvetica', 'B', 7.5);
        $this->setViolet();
        $pdf->SetXY($barX, $barY);
        $pdf->Cell($barW, 5, 'VOTER TURNOUT PROGRESS', 0, 1, 'L');
        $barY = $pdf->GetY();

        // Track
        $pdf->SetFillColor(220, 210, 230);
        $this->borderNone();
        $pdf->Rect($barX, $barY, $barW, $barH, 'F');

        // Fill
        $this->fillGold();
        $fillW = ($barW * $turnoutPct) / 100;
        $pdf->Rect($barX, $barY, $fillW, $barH, 'F');

        // Label
        $pdf->SetFont('Helvetica', 'B', 7);
        $this->setViolet();
        $pdf->SetXY($barX, $barY + $barH + 2);
        $pdf->Cell($barW, 5, $turnoutPct . '% of ' . number_format($totalVoters) . ' registered voters have cast their ballot', 0, 1, 'L');

        $pdf->Ln(3);

        // ── Results by Position ──
        foreach ($positions as $position) {
            if ($pdf->GetY() > ($pdf->GetPageHeight() - 60)) {
                $this->pageFooter();
                $pdf->AddPage();
                $this->pageHeader('Election Results', $electionName);
            }

            $this->sectionHeading('Position: ' . $position->name);

            $candidates = $position->candidates;
            $maxVotes   = $candidates->max('votes_count') ?: 1;
            $totalPos   = $candidates->sum('votes_count');

            $cols = [
                ['label' => '#',          'w' => 8,  'align' => 'C'],
                ['label' => 'Candidate',  'w' => 60, 'align' => 'L'],
                ['label' => 'Party List', 'w' => 40, 'align' => 'L'],
                ['label' => 'College',    'w' => 38, 'align' => 'L'],
                ['label' => 'Votes',      'w' => 18, 'align' => 'C'],
                ['label' => '% of Pos.',  'w' => 16, 'align' => 'C'],
            ];

            $pdf->SetX(15);
            $this->tableHeader($cols);

            foreach ($candidates as $idx => $c) {
                $pct     = $totalPos > 0 ? round(($c->votes_count / $totalPos) * 100, 1) : 0;
                $isFirst = $idx === 0;

                $cells = [
                    ['text' => $idx + 1,                                   'bold' => false],
                    ['text' => $c->full_name,                              'bold' => $isFirst, 'color' => $isFirst ? [56,0,65] : null],
                    ['text' => $c->partylist?->name ?? '—',                'bold' => false],
                    ['text' => $c->college?->acronym ?? $c->college?->name ?? '—', 'bold' => false],
                    ['text' => number_format($c->votes_count),             'bold' => $isFirst, 'color' => $isFirst ? [180,20,0] : null],
                    ['text' => $pct . '%',                                 'bold' => false],
                ];

                $this->tableRow($cells, $cols, $idx % 2 === 0);

                // Mini horizontal bar under vote count cell
                if ($c->votes_count > 0) {
                    $rowY   = $pdf->GetY() - 0.8;
                    $barX2  = 15 + 8 + 60 + 40 + 38; // after 4 cols
                    $barW2  = 18;
                    $barH2  = 1.2;
                    $fillW2 = ($barW2 * $c->votes_count) / $maxVotes;
                    $this->fillGold();
                    $this->borderNone();
                    $pdf->Rect($barX2, $rowY - $barH2, $fillW2, $barH2, 'F');
                }
            }

            // Winner callout
            if ($candidates->isNotEmpty()) {
                $winner = $candidates->first();
                $pdf->Ln(1);
                $this->fillGold();
                $this->borderNone();
                $callY = $pdf->GetY();
                $pdf->Rect(15, $callY, $w - 30, 7, 'F');
                $this->fillVioletDark();
                $pdf->Rect(15, $callY, 3, 7, 'F');
                $pdf->SetFont('Helvetica', 'B', 8);
                $this->setViolet();
                $pdf->SetXY(20, $callY);
                $pdf->Cell($w - 35, 7,
                    'LEADING: ' . strtoupper($winner->full_name) .
                    '  |  ' . number_format($winner->votes_count) . ' votes' .
                    ($candidates->sum('votes_count') > 0
                        ? '  (' . round(($winner->votes_count / $candidates->sum('votes_count')) * 100, 1) . '%)'
                        : ''),
                    0, 1, 'L');
            }
            $pdf->Ln(4);
        }

        $this->pageFooter();

        return response($pdf->Output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="election-results-' . now()->format('Y-m-d-His') . '.pdf"');
    }

    // ═════════════════════════════════════════════════════════════════════
    // 2. PER-COLLEGE BREAKDOWN REPORT
    // GET /admin/reports/by-college
    // ═════════════════════════════════════════════════════════════════════

    public function byCollege(): \Illuminate\Http\Response
    {
        $this->initPdf('P');
        $pdf = $this->pdf;

        $electionName = ElectionSetting::get('election_name', 'Student Council Election');
        $colleges     = College::with([
            'voters',
            'candidates' => fn($q) => $q->with(['position', 'partylist'])->withCount('votes'),
        ])->orderBy('name')->get();

        $totalVoters = User::where('role', 'voter')->count();
        $totalVoted  = CastedVote::distinct('voter_id')->count('voter_id');

        $pdf->AddPage();
        $this->pageHeader('College Breakdown Report', $electionName);

        // Summary KPIs
        $w    = $pdf->GetPageWidth();
        $kpiY = $pdf->GetY() + 2;
        $kpiW = ($w - 30 - 6) / 3;

        $this->statBox(15,              $kpiY, $kpiW, 20, 'Total Colleges',     $colleges->count(), false);
        $this->statBox(15 + $kpiW + 3,  $kpiY, $kpiW, 20, 'Registered Voters', number_format($totalVoters), true);
        $this->statBox(15 + ($kpiW+3)*2,$kpiY, $kpiW, 20, 'Ballots Cast',       number_format($totalVoted), false);

        $pdf->SetY($kpiY + 26);

        // ── Per-College sections ──
        foreach ($colleges as $college) {
            $voters       = $college->voters;
            $votersCount  = $voters->count();
            $votedCount   = $voters->filter(fn($v) => $v->hasVoted())->count();
            $turnout      = $votersCount > 0 ? round(($votedCount / $votersCount) * 100, 1) : 0;

            if ($pdf->GetY() > ($pdf->GetPageHeight() - 80)) {
                $this->pageFooter();
                $pdf->AddPage();
                $this->pageHeader('College Breakdown Report', $electionName);
            }

            // College name banner
            $this->fillViolet();
            $this->borderNone();
            $colBannerY = $pdf->GetY();
            $pdf->Rect(15, $colBannerY, $w - 30, 10, 'F');
            $this->fillGold();
            $pdf->Rect(15, $colBannerY, 4, 10, 'F');

            $pdf->SetFont('Helvetica', 'B', 10);
            $this->setGold();
            $pdf->SetXY(22, $colBannerY + 2);
            $pdf->Cell(100, 6, strtoupper($college->name), 0, 0, 'L');

            // Mini stats in banner
            $pdf->SetFont('Helvetica', '', 7.5);
            $this->setCream();
            $pdf->SetXY($w - 110, $colBannerY + 2);
            $pdf->Cell(95, 6,
                'Voters: ' . $votersCount .
                '  |  Voted: ' . $votedCount .
                '  |  Turnout: ' . $turnout . '%',
                0, 1, 'R');

            $pdf->Ln(3);

            // Turnout bar
            $barX = 15; $barY = $pdf->GetY(); $barW = $w - 30; $barH = 4;
            $pdf->SetFillColor(220, 210, 230);
            $this->borderNone();
            $pdf->Rect($barX, $barY, $barW, $barH, 'F');
            $this->fillGold();
            $fillW = $barW * ($turnout / 100);
            $pdf->Rect($barX, $barY, $fillW, $barH, 'F');
            $pdf->SetFont('Helvetica', '', 6.5);
            $this->setGray();
            $pdf->SetXY($barX, $barY + $barH + 1);
            $pdf->Cell($barW, 4, $turnout . '% turnout for this college', 0, 1, 'L');

            $pdf->Ln(2);

            // Candidates table
            $candidates = $college->candidates->sortBy(fn($c) => $c->position?->sort_order ?? 999);

            if ($candidates->isEmpty()) {
                $pdf->SetFont('Helvetica', 'I', 7.5);
                $this->setGray();
                $pdf->SetX(15);
                $pdf->Cell($w - 30, 6, 'No candidates registered for this college.', 0, 1, 'L');
                $pdf->Ln(3);
                continue;
            }

            $cols = [
                ['label' => 'Candidate',  'w' => 62, 'align' => 'L'],
                ['label' => 'Position',   'w' => 42, 'align' => 'L'],
                ['label' => 'Party List', 'w' => 38, 'align' => 'L'],
                ['label' => 'Course',     'w' => 22, 'align' => 'L'],
                ['label' => 'Votes',      'w' => 16, 'align' => 'C'],
            ];

            $pdf->SetX(15);
            $this->tableHeader($cols);

            $maxV = $candidates->max('votes_count') ?: 1;

            foreach ($candidates as $idx => $c) {
                $cells = [
                    ['text' => $c->full_name,                  'bold' => false],
                    ['text' => $c->position?->name ?? '—',     'bold' => false],
                    ['text' => $c->partylist?->name ?? '—',    'bold' => false],
                    ['text' => $c->course ?? '—',              'bold' => false],
                    ['text' => number_format($c->votes_count), 'bold' => true,
                     'color' => $c->votes_count > 0 ? [56,0,65] : [160,140,170]],
                ];
                $this->tableRow($cells, $cols, $idx % 2 === 0);
            }

            $pdf->Ln(5);
        }

        $this->pageFooter();

        return response($pdf->Output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="college-breakdown-' . now()->format('Y-m-d-His') . '.pdf"');
    }

    // ═════════════════════════════════════════════════════════════════════
    // 3. VOTER TURNOUT / PARTICIPATION REPORT
    // GET /admin/reports/turnout
    // ═════════════════════════════════════════════════════════════════════

    public function turnout(): \Illuminate\Http\Response
    {
        $this->initPdf('P');
        $pdf = $this->pdf;

        $electionName = ElectionSetting::get('election_name', 'Student Council Election');
        $w            = $pdf->GetPageWidth();

        // ── Data ──
        $colleges = College::with('voters')->orderBy('name')->get();

        $totalVoters = User::where('role', 'voter')->count();
        $totalVoted  = CastedVote::distinct('voter_id')->count('voter_id');
        $notVoted    = max(0, $totalVoters - $totalVoted);
        $overallPct  = $totalVoters > 0 ? round(($totalVoted / $totalVoters) * 100, 1) : 0;

        $pdf->AddPage();
        $this->pageHeader('Voter Turnout Report', $electionName);

        // KPIs
        $kpiY = $pdf->GetY() + 2;
        $kpiW = ($w - 30 - 9) / 4;
        $this->statBox(15,                $kpiY, $kpiW, 22, 'Registered',   number_format($totalVoters), false);
        $this->statBox(15 + ($kpiW+3),    $kpiY, $kpiW, 22, 'Voted',        number_format($totalVoted),  true);
        $this->statBox(15 + ($kpiW+3)*2,  $kpiY, $kpiW, 22, 'Not Yet',      number_format($notVoted),    false);
        $this->statBox(15 + ($kpiW+3)*3,  $kpiY, $kpiW, 22, 'Turnout',      $overallPct . '%',           true);
        $pdf->SetY($kpiY + 28);

        // ── Overall progress bar ──
        $this->sectionHeading('Overall Voter Participation');
        $barX = 15; $barY = $pdf->GetY(); $barW = $w - 30; $barH = 8;
        $pdf->SetFillColor(220, 210, 230);
        $this->borderNone();
        $pdf->Rect($barX, $barY, $barW, $barH, 'F');
        $this->fillGold();
        $pdf->Rect($barX, $barY, $barW * ($overallPct / 100), $barH, 'F');
        $pdf->SetFont('Helvetica', 'B', 8);
        $this->setViolet();
        $pdf->SetXY($barX + 3, $barY + 1);
        $pdf->Cell(80, $barH - 2, $overallPct . '% — ' . number_format($totalVoted) . ' of ' . number_format($totalVoters) . ' voters', 0, 0, 'L');
        $pdf->SetY($barY + $barH + 6);

        // ── Per-College Turnout Table ──
        $this->sectionHeading('Turnout by College');

        $cols = [
            ['label' => 'College',              'w' => 65, 'align' => 'L'],
            ['label' => 'Acronym',              'w' => 22, 'align' => 'C'],
            ['label' => 'Registered Voters',    'w' => 32, 'align' => 'C'],
            ['label' => 'Voted',                'w' => 20, 'align' => 'C'],
            ['label' => 'Not Voted',            'w' => 20, 'align' => 'C'],
            ['label' => 'Turnout %',            'w' => 21, 'align' => 'C'],
        ];
        $pdf->SetX(15);
        $this->tableHeader($cols);

        foreach ($colleges as $idx => $college) {
            $cv      = $college->voters->count();
            $voted   = $college->voters->filter(fn($v) => $v->hasVoted())->count();
            $notV    = max(0, $cv - $voted);
            $pct     = $cv > 0 ? round(($voted / $cv) * 100, 1) : 0.0;

            $cells = [
                ['text' => $college->name,         'bold' => false],
                ['text' => $college->acronym ?? '—','bold' => false],
                ['text' => number_format($cv),      'bold' => false],
                ['text' => number_format($voted),   'bold' => true, 'color' => [56,0,65]],
                ['text' => number_format($notV),    'bold' => false, 'color' => $notV > 0 ? [160,20,20] : null],
                ['text' => $pct . '%',              'bold' => true,  'color' => $pct >= 75 ? [20,120,20] : ($pct >= 50 ? [120,80,0] : [160,20,20])],
            ];
            $this->tableRow($cells, $cols, $idx % 2 === 0);

            // Mini inline bar in Turnout % cell
            $rowY  = $pdf->GetY() - 0.8;
            $bX    = 15 + 65 + 22 + 32 + 20 + 20; // x of last col
            $bW    = 21;
            $bH    = 1.2;
            $bFill = $bW * ($pct / 100);
            $this->fillGold();
            $this->borderNone();
            $pdf->Rect($bX, $rowY - $bH, $bFill, $bH, 'F');
        }

        $pdf->Ln(8);

        // ── Voters who HAVE NOT voted ──
        $this->sectionHeading('Voters Who Have Not Yet Cast Their Ballot');

        $notVotedVoters = User::where('role', 'voter')
            ->whereDoesntHave('votes')
            ->with('college')
            ->orderBy('last_name')
            ->get();

        if ($notVotedVoters->isEmpty()) {
            $pdf->SetFont('Helvetica', 'I', 8);
            $this->setGray();
            $pdf->SetX(15);
            $pdf->Cell($w - 30, 8, 'All registered voters have cast their ballots. 100% participation!', 0, 1, 'C');
        } else {
            $cols2 = [
                ['label' => '#',               'w' => 8,  'align' => 'C'],
                ['label' => 'Full Name',        'w' => 65, 'align' => 'L'],
                ['label' => 'Student No.',      'w' => 30, 'align' => 'L'],
                ['label' => 'College',          'w' => 35, 'align' => 'L'],
                ['label' => 'Course',           'w' => 30, 'align' => 'L'],
                ['label' => 'Year',             'w' => 12, 'align' => 'C'],
            ];
            $pdf->SetX(15);
            $this->tableHeader($cols2);

            foreach ($notVotedVoters as $idx => $v) {
                $cells2 = [
                    ['text' => $idx + 1,                              'bold' => false],
                    ['text' => $v->full_name,                         'bold' => false],
                    ['text' => $v->student_number ?? '—',             'bold' => false],
                    ['text' => $v->college?->acronym ?? $v->college?->name ?? '—', 'bold' => false],
                    ['text' => $v->course ?? '—',                     'bold' => false],
                    ['text' => $v->year_level ?? '—',                 'bold' => false],
                ];
                $this->tableRow($cells2, $cols2, $idx % 2 === 0);
            }
        }

        $this->pageFooter();

        return response($pdf->Output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="voter-turnout-' . now()->format('Y-m-d-His') . '.pdf"');
    }

    // ═════════════════════════════════════════════════════════════════════
    // 4. FULL BALLOT LOG REPORT (all transactions)
    // GET /admin/reports/ballots
    // ═════════════════════════════════════════════════════════════════════

    public function ballots(Request $request): \Illuminate\Http\Response
    {
        $this->initPdf('L'); // Landscape for wide table
        $pdf = $this->pdf;

        $electionName = ElectionSetting::get('election_name', 'Student Council Election');
        $w            = $pdf->GetPageWidth();

        // ── Data ──
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
        $this->pageHeader('Full Ballot Transaction Log', $electionName);

        // Summary strip
        $kpiY = $pdf->GetY() + 2;
        $kpiW = ($w - 30 - 9) / 4;
        $this->statBox(15,                $kpiY, $kpiW, 20, 'Total Ballots', number_format($transactions->count()), true);
        $this->statBox(15 + ($kpiW+3),    $kpiY, $kpiW, 20, 'Date From',    $transactions->first()?->voted_at ? \Carbon\Carbon::parse($transactions->first()->voted_at)->format('M d, Y') : '—', false);
        $this->statBox(15 + ($kpiW+3)*2,  $kpiY, $kpiW, 20, 'Date To',      $transactions->last()?->voted_at  ? \Carbon\Carbon::parse($transactions->last()->voted_at)->format('M d, Y')  : '—', false);
        $this->statBox(15 + ($kpiW+3)*3,  $kpiY, $kpiW, 20, 'Status',       ucfirst(ElectionSetting::status()), true);
        $pdf->SetY($kpiY + 26);

        $this->sectionHeading('All Submitted Ballots');

        $cols = [
            ['label' => '#',              'w' => 8,  'align' => 'C'],
            ['label' => 'Transaction No.','w' => 48, 'align' => 'L'],
            ['label' => 'Voter Name',     'w' => 55, 'align' => 'L'],
            ['label' => 'Student No.',    'w' => 32, 'align' => 'L'],
            ['label' => 'College',        'w' => 30, 'align' => 'L'],
            ['label' => 'Positions Voted','w' => 28, 'align' => 'C'],
            ['label' => 'Out of',         'w' => 18, 'align' => 'C'],
            ['label' => 'Date & Time',    'w' => 42, 'align' => 'L'],
        ];
        $pdf->SetX(15);
        $this->tableHeader($cols);

        foreach ($transactions as $idx => $tx) {
            $voter = $voters->get($tx->voter_id);
            $cells = [
                ['text' => $idx + 1,                                          'bold' => false],
                ['text' => $tx->transaction_number ?? '—',                    'bold' => false, 'color' => [56,0,65]],
                ['text' => $voter?->full_name ?? 'Unknown',                   'bold' => false],
                ['text' => $voter?->student_number ?? '—',                    'bold' => false],
                ['text' => $voter?->college?->acronym ?? $voter?->college?->name ?? '—', 'bold' => false],
                ['text' => number_format((int)$tx->positions_voted),          'bold' => true],
                ['text' => number_format((int)$tx->positions_count),          'bold' => false],
                ['text' => $tx->voted_at ? \Carbon\Carbon::parse($tx->voted_at)->format('M d, Y H:i') : '—', 'bold' => false],
            ];
            $this->tableRow($cells, $cols, $idx % 2 === 0);
        }

        $this->pageFooter();

        return response($pdf->Output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="ballot-log-' . now()->format('Y-m-d-His') . '.pdf"');
    }

    // ═════════════════════════════════════════════════════════════════════
    // 5. CANDIDATE SUMMARY REPORT
    // GET /admin/reports/candidates
    // ═════════════════════════════════════════════════════════════════════

    public function candidates(): \Illuminate\Http\Response
    {
        $this->initPdf('L');
        $pdf = $this->pdf;

        $electionName = ElectionSetting::get('election_name', 'Student Council Election');
        $w            = $pdf->GetPageWidth();

        $candidates = Candidate::with(['position', 'partylist', 'college', 'organization'])
            ->withCount('votes')
            ->orderBy('position_id')
            ->orderByDesc('votes_count')
            ->get();

        $pdf->AddPage();
        $this->pageHeader('Candidate Summary Report', $electionName);

        $kpiY = $pdf->GetY() + 2;
        $kpiW = ($w - 30 - 9) / 4;
        $this->statBox(15,                $kpiY, $kpiW, 20, 'Total Candidates',  $candidates->count(), false);
        $this->statBox(15 + ($kpiW+3),    $kpiY, $kpiW, 20, 'Positions',         Position::count(), true);
        $this->statBox(15 + ($kpiW+3)*2,  $kpiY, $kpiW, 20, 'Party Lists',       \App\Models\Partylist::count(), false);
        $this->statBox(15 + ($kpiW+3)*3,  $kpiY, $kpiW, 20, 'Total Votes Cast',  number_format($candidates->sum('votes_count')), true);
        $pdf->SetY($kpiY + 26);

        $this->sectionHeading('All Candidates & Vote Counts');

        $cols = [
            ['label' => '#',            'w' => 8,  'align' => 'C'],
            ['label' => 'Full Name',    'w' => 55, 'align' => 'L'],
            ['label' => 'Position',     'w' => 40, 'align' => 'L'],
            ['label' => 'Party List',   'w' => 38, 'align' => 'L'],
            ['label' => 'College',      'w' => 32, 'align' => 'L'],
            ['label' => 'Organization', 'w' => 40, 'align' => 'L'],
            ['label' => 'Course',       'w' => 28, 'align' => 'L'],
            ['label' => 'Votes',        'w' => 20, 'align' => 'C'],
        ];
        $pdf->SetX(15);
        $this->tableHeader($cols);

        foreach ($candidates as $idx => $c) {
            $cells = [
                ['text' => $idx + 1,                                          'bold' => false],
                ['text' => $c->full_name,                                     'bold' => false],
                ['text' => $c->position?->name ?? '—',                       'bold' => false],
                ['text' => $c->partylist?->name ?? '—',                      'bold' => false],
                ['text' => $c->college?->acronym ?? $c->college?->name ?? '—','bold' => false],
                ['text' => $c->organization?->name ?? '—',                   'bold' => false],
                ['text' => $c->course ?? '—',                                'bold' => false],
                ['text' => number_format($c->votes_count),                   'bold' => true, 'color' => $c->votes_count > 0 ? [56,0,65] : [160,140,170]],
            ];
            $this->tableRow($cells, $cols, $idx % 2 === 0);
        }

        $this->pageFooter();

        return response($pdf->Output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="candidates-summary-' . now()->format('Y-m-d-His') . '.pdf"');
    }
}