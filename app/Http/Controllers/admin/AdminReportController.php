<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Models\College;
use App\Models\CastedVote;
use App\Models\User;
use App\Models\Candidate;
use App\Helpers\CustomPDF;
use Carbon\Carbon;

class AdminReportController extends Controller
{
    // =========================================================
    //  Route Handlers
    // =========================================================

    public function results()
    {
        $data     = $this->getSSCReportData();
        $filename = 'SSC_election_results.pdf';
        return $this->generateSSCPDF($data, $filename);
    }

    public function byCollege()
    {
        $data     = $this->getReportData();
        $filename = 'ALL_election_results.pdf';
        return $this->generateFullPDF($data, $filename);
    }

    public function turnout()
    {
        $data     = $this->getTurnoutData();
        $filename = 'voter_turnout.pdf';
        return $this->generateTurnoutPDF($data, $filename);
    }

    public function ballots()
    {
        $data     = $this->getBallotLogData();
        $filename = 'ballot_transaction_log.pdf';
        return $this->generateBallotLogPDF($data, $filename);
    }

    public function candidates()
    {
        $data     = $this->getCandidateSummaryData();
        $filename = 'candidate_summary.pdf';
        return $this->generateCandidateSummaryPDF($data, $filename);
    }

    // =========================================================
    //  PDF Factory  — SetMargins(15, 15, 15) matches original
    // =========================================================

    private function makePDF(string $orientation = 'P'): CustomPDF
    {
        $pdf = new CustomPDF($orientation, 'mm', 'A4');
        $pdf->SetAutoPageBreak(true, 25);
        $pdf->AliasNbPages();
        $pdf->SetMargins(15, 15, 15);   // ← same as original working code
        return $pdf;
    }

    // =========================================================
    //  PDF Generators  (original design 1:1)
    // =========================================================

    private function generateSSCPDF($data, $filename)
    {
        $pdf = $this->makePDF('P');
        $pdf->AddPage();

        $this->addHeaderToPage($pdf, 'Supreme Student Council (SSC) Election Results', $data['generatedAt']);
        $this->addStatsSection($pdf, $data);

        $widths = [70, 30, 35, 25, 20];
        $this->drawTableHeader($pdf, $widths);

        foreach ($data['positions'] as $position) {
            if ($pdf->GetY() > 250) {
                $pdf->AddPage();
                $this->drawTableHeader($pdf, $widths);
            }
            $this->drawPositionSection($pdf, $position, $data['totalVoted'], $widths);
        }

        $pdf->AddSignatories();
        return $pdf->Output('D', $filename);
    }

    private function generateSBOPDF($data, $filename)
    {
        $pdf = $this->makePDF('P');
        $pdf->AddPage();

        $title = $data['college']->name . "\nStudent Body Organization (SBO) Election Results";
        $this->addHeaderToPage($pdf, $title, $data['generatedAt']);
        $this->addStatsSection($pdf, $data);

        $widths = [70, 30, 35, 25, 20];
        $this->drawTableHeader($pdf, $widths);

        foreach ($data['positions'] as $position) {
            if ($pdf->GetY() > 250) {
                $pdf->AddPage();
                $this->drawTableHeader($pdf, $widths);
            }
            $this->drawPositionSection($pdf, $position, $data['totalVoted'], $widths);
        }

        $pdf->AddSignatories();
        return $pdf->Output('D', $filename);
    }

    private function generateFullPDF($data, $filename)
    {
        $pdf = $this->makePDF('P');
        $pdf->AddPage();

        $this->addHeaderToPage($pdf, 'Complete Election Results Report', $data['generatedAt']);
        $this->addStatsSection($pdf, $data);

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Supreme Student Council (SSC) Results', 0, 1, 'L');
        $pdf->Ln(2);

        $widths = [70, 30, 35, 25, 20];
        $this->drawTableHeader($pdf, $widths);

        foreach ($data['sscPositions'] as $position) {
            if ($pdf->GetY() > 250) {
                $pdf->AddPage();
                $this->drawTableHeader($pdf, $widths);
            }
            $this->drawPositionSection($pdf, $position, $data['totalVoted'], $widths);
        }

        foreach ($data['collegeResults'] as $college) {
            $pdf->AddPage();

            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(0, 10, $college['college']->name . ' Results', 0, 1, 'L');
            $pdf->Ln(2);

            if ($college['positions']->isNotEmpty()) {
                $this->drawTableHeader($pdf, $widths);

                foreach ($college['positions'] as $position) {
                    if ($pdf->GetY() > 250) {
                        $pdf->AddPage();
                        $pdf->SetFont('Arial', 'B', 14);
                        $pdf->Cell(0, 10, $college['college']->name . ' Results (continued)', 0, 1, 'L');
                        $pdf->Ln(2);
                        $this->drawTableHeader($pdf, $widths);
                    }
                    $this->drawPositionSection($pdf, $position, $college['totalVoted'], $widths);
                }
            } else {
                $pdf->SetFont('Arial', '', 11);
                $pdf->Cell(0, 10, 'No candidates found for this college.', 0, 1, 'L');
            }
        }

        $pdf->AddSignatories();
        return $pdf->Output('D', $filename);
    }

    private function generateTurnoutPDF($data, $filename)
    {
        $pdf = $this->makePDF('P');
        $pdf->AddPage();

        $this->addHeaderToPage($pdf, 'Voter Turnout Report', $data['generatedAt']);
        $this->addStatsSection($pdf, $data);

        // Per-college table
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Turnout by College', 0, 1, 'L');
        $pdf->Ln(2);

        $cw = [80, 35, 35, 30];
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetFillColor(168, 85, 247);
        $pdf->SetTextColor(255);
        foreach (['College', 'Total Voters', 'Votes Cast', 'Turnout'] as $i => $h) {
            $pdf->Cell($cw[$i], 10, $h, 1, 0, 'C', true);
        }
        $pdf->Ln();
        $pdf->SetTextColor(0);

        foreach ($data['collegeStats'] as $i => $row) {
            $fill = $i % 2 === 0;
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell($cw[0], 10, $row['name'],                       1, 0, 'L', $fill);
            $pdf->Cell($cw[1], 10, number_format($row['totalVoters']), 1, 0, 'C', $fill);
            $pdf->Cell($cw[2], 10, number_format($row['votedCount']),  1, 0, 'C', $fill);
            $pdf->Cell($cw[3], 10, $row['percentage'] . '%',           1, 0, 'C', $fill);
            $pdf->Ln();
        }

        // Non-voters list
        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Non-Voters (' . $data['nonVoters']->count() . ')', 0, 1, 'L');
        $pdf->Ln(2);

        $nw      = [65, 40, 30, 45];
        $headers = ['Name', 'Student Number', 'College', 'Course'];
        $this->drawSmallHeader($pdf, $nw, $headers);

        foreach ($data['nonVoters'] as $i => $voter) {
            if ($pdf->GetY() > 265) {
                $pdf->AddPage();
                $this->drawSmallHeader($pdf, $nw, $headers);
            }
            $fill = $i % 2 === 0;
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell($nw[0], 10, $voter->full_name,                1, 0, 'L', $fill);
            $pdf->Cell($nw[1], 10, $voter->student_number ?? '—',    1, 0, 'C', $fill);
            $pdf->Cell($nw[2], 10, $voter->college?->acronym ?? '—', 1, 0, 'C', $fill);
            $pdf->Cell($nw[3], 10, $voter->course ?? '—',            1, 0, 'L', $fill);
            $pdf->Ln();
        }

        $pdf->AddSignatories();
        return $pdf->Output('D', $filename);
    }

    private function generateBallotLogPDF($data, $filename)
    {
        $pdf = $this->makePDF('L');
        $pdf->AddPage();

        $this->addHeaderToPage($pdf, 'Ballot Transaction Log', $data['generatedAt']);

        $cw      = [65, 72, 40, 35, 55];
        $headers = ['Transaction #', 'Voter Name', 'Student #', 'College', 'Timestamp'];
        $this->drawSmallHeader($pdf, $cw, $headers);

        foreach ($data['ballots'] as $i => [$txn, $votes]) {
            if ($pdf->GetY() > 185) {
                $pdf->AddPage();
                $this->drawSmallHeader($pdf, $cw, $headers);
            }

            $fill    = $i % 2 === 0;
            $first   = $votes->first();
            $voter   = $first->voter;
            $time    = Carbon::parse($first->voted_at)->timezone('Asia/Manila')->format('M j, Y H:i');

            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell($cw[0], 10, $txn,                               1, 0, 'L', $fill);
            $pdf->Cell($cw[1], 10, $voter?->full_name ?? '—',          1, 0, 'L', $fill);
            $pdf->Cell($cw[2], 10, $voter?->student_number ?? '—',     1, 0, 'C', $fill);
            $pdf->Cell($cw[3], 10, $voter?->college?->acronym ?? '—',  1, 0, 'C', $fill);
            $pdf->Cell($cw[4], 10, $time,                              1, 0, 'C', $fill);
            $pdf->Ln();
        }

        $pdf->AddSignatories();
        return $pdf->Output('D', $filename);
    }

    private function generateCandidateSummaryPDF($data, $filename)
    {
        $pdf = $this->makePDF('L');
        $pdf->AddPage();

        $this->addHeaderToPage($pdf, 'Candidate Summary', $data['generatedAt']);

        $cw      = [55, 40, 35, 30, 35, 30, 18];
        $headers = ['Name', 'Position', 'Partylist', 'College', 'Organization', 'Course', 'Votes'];
        $this->drawSmallHeader($pdf, $cw, $headers);

        foreach ($data['candidates'] as $i => $candidate) {
            if ($pdf->GetY() > 185) {
                $pdf->AddPage();
                $this->drawSmallHeader($pdf, $cw, $headers);
            }

            $fill = $i % 2 === 0;
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell($cw[0], 10, $candidate->full_name,                          1, 0, 'L', $fill);
            $pdf->Cell($cw[1], 10, $candidate->position?->name ?? '—',             1, 0, 'L', $fill);
            $pdf->Cell($cw[2], 10, $candidate->partylist?->name ?? '—',            1, 0, 'C', $fill);
            $pdf->Cell($cw[3], 10, $candidate->college?->acronym ?? '—',           1, 0, 'C', $fill);
            $pdf->Cell($cw[4], 10, $candidate->organization?->acronym ?? '—',      1, 0, 'C', $fill);
            $pdf->Cell($cw[5], 10, $this->truncate($candidate->course ?? '—', 18), 1, 0, 'L', $fill);
            $pdf->Cell($cw[6], 10, $candidate->vote_count ?? 0,                    1, 0, 'R', $fill);
            $pdf->Ln();
        }

        $pdf->AddSignatories();
        return $pdf->Output('D', $filename);
    }

    // =========================================================
    //  Shared PDF Helpers  (original design 1:1)
    // =========================================================

    private function addHeaderToPage($pdf, $title, $date)
    {
        $timestamp = Carbon::now('Asia/Manila')->format('F j, Y H:i:s T');

        $pdf->SetFont('Arial', 'B', 16);
        foreach (explode("\n", $title) as $line) {
            $pdf->Cell(0, 10, $line, 0, 1, 'C');
        }
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'Generated on: ' . $timestamp, 0, 1, 'C');
        $pdf->Ln(5);
    }

    private function addStatsSection($pdf, $data)
    {
        $totalVoters = $data['totalVoters'] ?? 0;
        $totalVoted  = $data['totalVoted']  ?? 0;
        $pct         = $totalVoters > 0 ? round($totalVoted / $totalVoters * 100, 2) : 0;

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Voting Statistics', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);

        foreach ([
            ['Total Eligible Voters:', number_format($totalVoters)],
            ['Total Votes Cast:',      number_format($totalVoted)],
            ['Voter Turnout:',         $pct . '%'],
        ] as $stat) {
            $pdf->Cell(60, 8, $stat[0], 0, 0, 'L');
            $pdf->Cell(0,  8, $stat[1], 0, 1, 'L');
        }
        $pdf->Ln(5);
    }

    private function drawTableHeader($pdf, $widths)
    {
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetFillColor(168, 85, 247);
        $pdf->SetTextColor(255);

        foreach (['Candidate Name', 'College', 'Partylist', 'Votes', '%'] as $i => $h) {
            $pdf->Cell($widths[$i], 10, $h, 1, 0, 'C', true);
        }
        $pdf->Ln();
        $pdf->SetTextColor(0);
    }

    private function drawPositionSection($pdf, $position, $totalVoted, $widths)
    {
        $widths = [70, 30, 35, 25, 20];

        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(0, 8, $position->name, 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);

        foreach ($position->candidates as $index => $candidate) {
            if ($pdf->GetY() > 270) {
                $pdf->AddPage();
                $this->drawTableHeader($pdf, $widths);
            }
            $this->drawCandidateRow($pdf, $candidate, $totalVoted, $widths, $index % 2 == 0);
        }

        $pdf->Ln(3);
    }

    private function drawCandidateRow($pdf, $candidate, $totalVoted, $widths, $fill = false)
    {
        $pct = $totalVoted > 0 ? round($candidate->vote_count / $totalVoted * 100, 2) : 0;

        $pdf->Cell($widths[0], 10, $candidate->full_name,                  1, 0, 'L', $fill);
        $pdf->Cell($widths[1], 10, $candidate->college?->acronym  ?? '—',  1, 0, 'C', $fill);
        $pdf->Cell($widths[2], 10, $candidate->partylist?->acronym ?? '—', 1, 0, 'C', $fill);
        $pdf->Cell($widths[3], 10, $candidate->vote_count,                 1, 0, 'R', $fill);
        $pdf->Cell($widths[4], 10, $pct . '%',                             1, 0, 'R', $fill);
        $pdf->Ln();
    }

    /** Purple header row for non-candidate tables. */
    private function drawSmallHeader($pdf, array $widths, array $headers): void
    {
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetFillColor(168, 85, 247);
        $pdf->SetTextColor(255);
        foreach ($headers as $i => $h) {
            $pdf->Cell($widths[$i], 10, $h, 1, 0, 'C', true);
        }
        $pdf->Ln();
        $pdf->SetTextColor(0);
    }

    // =========================================================
    //  Data Builders
    // =========================================================

    private function getReportData()
    {
        $sscPositions = $this->sscPositionsQuery()->get();

        $collegeResults = College::all()->map(function (College $college) {
            $positions = $this->sboPositionsQuery()
                ->with(['candidates' => function ($q) use ($college) {
                    $q->where('college_id', $college->id)
                        ->selectRaw('candidates.*, (
                            SELECT COUNT(*) FROM casted_votes cv
                            WHERE cv.candidate_id = candidates.candidate_id
                              AND cv.position_id  = candidates.position_id
                        ) AS vote_count')
                        ->with(['partylist', 'college'])
                        ->orderByDesc('vote_count');
                }])
                ->get()
                ->filter(fn($p) => $p->candidates->isNotEmpty());

            [$totalVoters, $totalVoted] = $this->collegeTurnout($college->id);

            return compact('college', 'positions', 'totalVoters', 'totalVoted');
        });

        [$totalVoters, $totalVoted] = $this->overallTurnout();

        return [
            'sscPositions'   => $sscPositions,
            'collegeResults' => $collegeResults,
            'totalVoters'    => $totalVoters,
            'totalVoted'     => $totalVoted,
            'generatedAt'    => $this->timestamp(),
        ];
    }

    private function getSSCReportData()
    {
        [$totalVoters, $totalVoted] = $this->overallTurnout();

        return [
            'positions'   => $this->sscPositionsQuery()->get(),
            'totalVoters' => $totalVoters,
            'totalVoted'  => $totalVoted,
            'generatedAt' => $this->timestamp(),
        ];
    }

    private function getSBOReportData(string $collegeAcronym)
    {
        $collegeInfo = College::where('acronym', $collegeAcronym)->firstOrFail();

        $positions = $this->sboPositionsQuery()
            ->with(['candidates' => function ($q) use ($collegeInfo) {
                $q->where('college_id', $collegeInfo->id)
                    ->selectRaw('candidates.*, (
                        SELECT COUNT(*) FROM casted_votes cv
                        WHERE cv.candidate_id = candidates.candidate_id
                          AND cv.position_id  = candidates.position_id
                    ) AS vote_count')
                    ->with(['partylist', 'college'])
                    ->orderByDesc('vote_count');
            }])
            ->get()
            ->filter(fn($p) => $p->candidates->isNotEmpty());

        [$totalVoters, $totalVoted] = $this->collegeTurnout($collegeInfo->id);

        return [
            'college'     => $collegeInfo,
            'positions'   => $positions,
            'totalVoters' => $totalVoters,
            'totalVoted'  => $totalVoted,
            'generatedAt' => $this->timestamp(),
        ];
    }

    private function getTurnoutData()
    {
        $collegeStats = College::all()->map(function (College $college) {
            [$totalVoters, $votedCount] = $this->collegeTurnout($college->id);
            return [
                'name'        => $college->name,
                'acronym'     => $college->acronym,
                'totalVoters' => $totalVoters,
                'votedCount'  => $votedCount,
                'percentage'  => $totalVoters > 0 ? round($votedCount / $totalVoters * 100, 2) : 0,
            ];
        });

        $nonVoters = User::where('role', 'voter')
            ->where('status', 'Active')
            ->whereDoesntHave('votes')
            ->with('college')
            ->orderBy('last_name')
            ->get();

        [$totalVoters, $totalVoted] = $this->overallTurnout();

        return compact('collegeStats', 'nonVoters', 'totalVoters', 'totalVoted')
            + ['generatedAt' => $this->timestamp()];
    }

    private function getBallotLogData()
    {
        $ballots = CastedVote::with(['voter.college', 'position', 'candidate'])
            ->orderBy('voted_at')
            ->get()
            ->groupBy('transaction_number')
            ->map(fn($votes, $txn) => [$txn, $votes])
            ->values();

        return [
            'ballots'     => $ballots,
            'generatedAt' => $this->timestamp(),
        ];
    }

    private function getCandidateSummaryData()
    {
        $candidates = Candidate::with(['position', 'partylist', 'college', 'organization'])
            ->join('positions', 'positions.id', '=', 'candidates.position_id')
            ->orderBy('positions.sort_order')
            ->select('candidates.*')
            ->selectRaw('(
                SELECT COUNT(*) FROM casted_votes cv
                WHERE cv.candidate_id = candidates.candidate_id
                  AND cv.position_id  = candidates.position_id
            ) AS vote_count')
            ->orderByDesc('vote_count')
            ->get();

        return [
            'candidates'  => $candidates,
            'generatedAt' => $this->timestamp(),
        ];
    }

    // =========================================================
    //  Query Helpers
    // =========================================================

    private function sscPositionsQuery()
    {
        return Position::whereIn('id', [1, 2, 3])
            ->with(['candidates' => function ($q) {
                $q->selectRaw('candidates.*, (
                        SELECT COUNT(*) FROM casted_votes cv
                        WHERE cv.candidate_id = candidates.candidate_id
                          AND cv.position_id  = candidates.position_id
                    ) AS vote_count')
                    ->with(['partylist', 'college'])
                    ->orderByDesc('vote_count');
            }])
            ->orderBy('sort_order');
    }

    private function sboPositionsQuery()
    {
        return Position::whereIn('id', range(4, 14))
            ->orderBy('sort_order');
    }

    private function collegeTurnout(int $collegeId): array
    {
        $voterIds = User::where('role', 'voter')
            ->where('status', 'Active')
            ->where('college_id', $collegeId)
            ->pluck('id');

        return [
            $voterIds->count(),
            CastedVote::whereIn('voter_id', $voterIds)->distinct('voter_id')->count(),
        ];
    }

    private function overallTurnout(): array
    {
        return [
            User::where('role', 'voter')->where('status', 'Active')->count(),
            CastedVote::distinct('voter_id')->count(),
        ];
    }

    private function timestamp(): string
    {
        return Carbon::now('Asia/Manila')->format('F j, Y H:i:s T');
    }

    private function truncate(string $text, int $max): string
    {
        return mb_strlen($text) > $max ? mb_substr($text, 0, $max - 1) . '…' : $text;
    }
}