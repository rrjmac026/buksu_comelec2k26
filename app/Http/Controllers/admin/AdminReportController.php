<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Models\College;
use App\Models\CastedVote;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\CustomPDF;
use Carbon\Carbon;

class AdminReportController extends Controller
{
    public function index()
    {
        $colleges = College::select('name', 'acronym')->get();
        $data = $this->getReportData();

        $data['positions'] = Position::with(['candidates' => function ($query) {
            $query->select('candidates.*')
                ->selectRaw('(
                    SELECT COUNT(*)
                    FROM casted_votes
                    WHERE casted_votes.candidate_id = candidates.candidate_id
                    AND casted_votes.position_id = candidates.position_id
                ) as vote_count')
                ->with(['partylist', 'college'])
                ->orderByDesc('vote_count');
        }])->get(); // sort_order is applied via global scope on Position model

        $data['collegeStats'] = College::with(['voters' => function ($query) {
            $query->where('status', 'Active');
        }])
        ->get()
        ->map(function ($college) {
            $totalVoters = $college->voters->count();
            $votedCount = CastedVote::whereIn('voter_id', $college->voters->pluck('id'))
                ->distinct('voter_id')
                ->count();

            return [
                'name'        => $college->name,
                'totalVoters' => $totalVoters,
                'votedCount'  => $votedCount,
                'percentage'  => $totalVoters > 0 ? round(($votedCount / $totalVoters) * 100, 2) : 0,
            ];
        });

        $data['colleges'] = $colleges;
        return view('admin.reports.index', $data);
    }

    public function generatePDF(Request $request)
    {
        $type    = $request->type ?? 'all';
        $college = $request->college;

        if ($type === 'ssc') {
            $data     = $this->getSSCReportData();
            $filename = 'SSC_election_results.pdf';
            return $this->generateSSCPDF($data, $filename);
        } elseif ($type === 'sbo') {
            $data     = $this->getSBOReportData($college);
            $filename = $college . '_sbo_election_results.pdf';
            return $this->generateSBOPDF($data, $filename);
        } else {
            $data     = $this->getReportData();
            $filename = 'ALL_election_results.pdf';
            return $this->generateFullPDF($data, $filename);
        }
    }

    public function results()
    {
        $data = $this->getReportData();
        $colleges = College::select('name', 'acronym')->get();
        $data['colleges'] = $colleges;

        $data['positions'] = Position::with(['candidates' => function ($query) {
            $query->select('candidates.*')
                ->selectRaw('(
                    SELECT COUNT(*) FROM casted_votes
                    WHERE casted_votes.candidate_id = candidates.candidate_id
                    AND casted_votes.position_id = candidates.position_id
                ) as vote_count')
                ->with(['partylist', 'college'])
                ->orderByDesc('vote_count');
        }])->get();

        return view('admin.reports.index', $data);
    }

    public function byCollege()
    {
        $colleges = College::select('name', 'acronym')->get();
        $data = $this->getReportData();

        $data['collegeStats'] = College::with(['voters' => function ($query) {
            $query->where('status', 'Active');
        }])
        ->get()
        ->map(function ($college) {
            $totalVoters = $college->voters->count();
            $votedCount = CastedVote::whereIn('voter_id', $college->voters->pluck('id'))
                ->distinct('voter_id')
                ->count();

            return [
                'name'        => $college->name,
                'acronym'     => $college->acronym,
                'totalVoters' => $totalVoters,
                'votedCount'  => $votedCount,
                'percentage'  => $totalVoters > 0 ? round(($votedCount / $totalVoters) * 100, 2) : 0,
            ];
        });

        $data['colleges'] = $colleges;
        return view('admin.reports.by-college', $data);
    }

    public function turnout()
    {
        $totalVoters = User::where('status', 'Active')->count();
        $totalVoted  = CastedVote::distinct('voter_id')->count();

        $collegeStats = College::with(['voters' => function ($query) {
            $query->where('status', 'Active');
        }])
        ->get()
        ->map(function ($college) {
            $totalVoters = $college->voters->count();
            $votedCount = CastedVote::whereIn('voter_id', $college->voters->pluck('id'))
                ->distinct('voter_id')
                ->count();

            return [
                'name'        => $college->name,
                'acronym'     => $college->acronym,
                'totalVoters' => $totalVoters,
                'votedCount'  => $votedCount,
                'notVoted'    => $totalVoters - $votedCount,
                'percentage'  => $totalVoters > 0 ? round(($votedCount / $totalVoters) * 100, 2) : 0,
            ];
        });

        return view('admin.reports.turnout', compact(
            'totalVoters',
            'totalVoted',
            'collegeStats',
        ));
    }

    public function ballots()
    {
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
            ->orderByDesc('voted_at')
            ->paginate(20)
            ->withQueryString();

        $voterIds = $transactions->pluck('voter_id')->unique()->filter();
        $voters   = User::whereIn('id', $voterIds)->get()->keyBy('id');

        $transactions->each(function ($row) use ($voters) {
            $row->voter = $voters->get($row->voter_id);
        });

        return view('admin.reports.ballots', compact('transactions'));
    }

    public function candidates()
    {
        $candidates = \App\Models\Candidate::with(['position', 'partylist', 'college'])
            ->selectRaw('candidates.*, (
                SELECT COUNT(*) FROM casted_votes
                WHERE casted_votes.candidate_id = candidates.candidate_id
            ) as vote_count')
            ->orderByDesc('vote_count')
            ->get();

        $totalVoted = CastedVote::distinct('voter_id')->count();

        return view('admin.reports.candidates', compact('candidates', 'totalVoted'));
    }

    // ── PDF Generators ─────────────────────────────────────────────

    private function generateSSCPDF($data, $filename)
    {
        $pdf = $this->makePDF();
        $pdf->AddPage();
        $this->addHeaderToPage($pdf, "Supreme Student Council (SSC) Election Results", $data['generatedAt']);
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

    public function generateSBOPDF($data, $filename)
    {
        $pdf = $this->makePDF();
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

    public function generateFullPDF($data, $filename)
    {
        $pdf = $this->makePDF();
        $pdf->AddPage();
        $this->addHeaderToPage($pdf, "Complete Election Results Report", $data['generatedAt']);
        $this->addStatsSection($pdf, $data);

        $widths = [70, 30, 35, 25, 20];

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Supreme Student Council (SSC) Results', 0, 1, 'L');
        $pdf->Ln(2);
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
            $pdf->Cell(0, 10, $college['name'] . ' Results', 0, 1, 'L');
            $pdf->Ln(2);

            if (!empty($college['positions']) && count($college['positions']) > 0) {
                $this->drawTableHeader($pdf, $widths);

                foreach ($college['positions'] as $position) {
                    if ($pdf->GetY() > 250) {
                        $pdf->AddPage();
                        $pdf->SetFont('Arial', 'B', 14);
                        $pdf->Cell(0, 10, $college['name'] . ' Results (continued)', 0, 1, 'L');
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

    // ── PDF Helpers ────────────────────────────────────────────────

    private function makePDF(): CustomPDF
    {
        $pdf = new CustomPDF('P', 'mm', 'A4');
        $pdf->SetAutoPageBreak(true, 25);
        $pdf->AliasNbPages();
        $pdf->SetMargins(15, 15, 15);
        return $pdf;
    }

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
        $totalVoters       = $data['totalVoters'] ?? 0;
        $totalVoted        = $data['totalVoted'] ?? 0;
        $turnoutPercentage = $totalVoters > 0 ? round(($totalVoted / $totalVoters) * 100, 2) : 0;

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Voting Statistics', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);

        foreach ([
            ['Total Eligible Voters:', number_format($totalVoters)],
            ['Total Votes Cast:',      number_format($totalVoted)],
            ['Voter Turnout:',         $turnoutPercentage . '%'],
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

        foreach (['Candidate Name', 'College', 'Partylist', 'Votes', '%'] as $i => $header) {
            $pdf->Cell($widths[$i], 10, $header, 1, 0, 'C', true);
        }
        $pdf->Ln();
        $pdf->SetTextColor(0);
    }

    private function drawPositionSection($pdf, $position, $totalVoted, $widths)
    {
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(0, 8, $position->name, 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);

        foreach ($position->candidates as $index => $candidate) {
            if ($pdf->GetY() > 270) {
                $pdf->AddPage();
                $this->drawTableHeader($pdf, $widths);
            }
            $this->drawCandidateRow($pdf, $candidate, $totalVoted, $widths, $index % 2 === 0);
        }

        $pdf->Ln(3);
    }

    private function drawCandidateRow($pdf, $candidate, $totalVoted, $widths, $fill = false)
    {
        $name       = $candidate->first_name . ' ' . $candidate->last_name;
        $percentage = $totalVoted > 0 ? round(($candidate->vote_count / $totalVoted) * 100, 2) : 0;

        $pdf->Cell($widths[0], 10, $name,                          1, 0, 'L', $fill);
        $pdf->Cell($widths[1], 10, $candidate->college->acronym,   1, 0, 'C', $fill);
        $pdf->Cell($widths[2], 10, $candidate->partylist->acronym, 1, 0, 'C', $fill);
        $pdf->Cell($widths[3], 10, $candidate->vote_count,         1, 0, 'R', $fill);
        $pdf->Cell($widths[4], 10, $percentage . '%',              1, 0, 'R', $fill);
        $pdf->Ln();
    }

    // ── Data Fetchers ──────────────────────────────────────────────

    private function getReportData()
    {
        // FIX: use 'id' not 'position_id'; sort_order applied via global scope
        $sscPositions = Position::whereIn('id', [1, 2, 3])
            ->with(['candidates' => function ($query) {
                $query->select('candidates.*')
                    ->selectRaw('(
                        SELECT COUNT(*) FROM casted_votes
                        WHERE casted_votes.candidate_id = candidates.candidate_id
                        AND casted_votes.position_id = candidates.position_id
                    ) as vote_count')
                    ->with(['partylist', 'college'])
                    ->orderByDesc('vote_count');
            }])->get();

        $collegeResults = College::all()->map(function ($college) {
            // FIX: use $college->id not $college->college_id
            $positions = Position::whereIn('id', range(4, 14))
                ->with(['candidates' => function ($query) use ($college) {
                    $query->where('college_id', $college->id)
                        ->selectRaw('candidates.*, (
                            SELECT COUNT(*) FROM casted_votes
                            WHERE casted_votes.candidate_id = candidates.candidate_id
                            AND casted_votes.position_id = candidates.position_id
                        ) as vote_count')
                        ->with(['partylist', 'college'])
                        ->orderByDesc('vote_count');
                }])
                ->get()
                ->filter(fn($p) => $p->candidates->isNotEmpty());

            // FIX: use User model, not Voter
            $voterIds = User::where('college_id', $college->id)
                ->where('status', 'Active')
                ->pluck('id');

            return [
                'name'        => $college->name,
                'positions'   => $positions,
                'totalVoters' => $voterIds->count(),
                'totalVoted'  => CastedVote::whereIn('voter_id', $voterIds)->distinct('voter_id')->count(),
            ];
        });

        return [
            'sscPositions'   => $sscPositions,
            'collegeResults' => $collegeResults,
            'totalVoters'    => User::where('status', 'Active')->count(),
            'totalVoted'     => CastedVote::distinct('voter_id')->count(),
            'generatedAt'    => now()->timezone('Asia/Manila')->format('F j, Y H:i:s T'),
        ];
    }

    private function getSSCReportData()
    {
        $positions = Position::whereIn('id', [1, 2, 3])
            ->with(['candidates' => function ($query) {
                $query->select('candidates.*')
                    ->selectRaw('(
                        SELECT COUNT(*) FROM casted_votes
                        WHERE casted_votes.candidate_id = candidates.candidate_id
                        AND casted_votes.position_id = candidates.position_id
                    ) as vote_count')
                    ->with(['partylist', 'college'])
                    ->orderByDesc('vote_count');
            }])->get();

        return [
            'positions'   => $positions,
            'totalVoters' => User::where('status', 'Active')->count(),
            'totalVoted'  => CastedVote::distinct('voter_id')->count(),
            'generatedAt' => now()->timezone('Asia/Manila')->format('F j, Y H:i:s T'),
        ];
    }

    private function getSBOReportData($college)
    {
        $collegeInfo = College::where('acronym', $college)->firstOrFail();

        // FIX: use $collegeInfo->id not $collegeInfo->college_id
        $positions = Position::whereIn('id', range(4, 14))
            ->with(['candidates' => function ($query) use ($collegeInfo) {
                $query->where('college_id', $collegeInfo->id)
                    ->selectRaw('candidates.*, (
                        SELECT COUNT(*) FROM casted_votes
                        WHERE casted_votes.candidate_id = candidates.candidate_id
                        AND casted_votes.position_id = candidates.position_id
                    ) as vote_count')
                    ->with(['partylist', 'college'])
                    ->orderByDesc('vote_count');
            }])
            ->get()
            ->filter(fn($p) => $p->candidates->isNotEmpty());

        $voterIds = User::where('college_id', $collegeInfo->id)
            ->where('status', 'Active')
            ->pluck('id');

        return [
            'college'     => $collegeInfo,
            'positions'   => $positions,
            'totalVoters' => $voterIds->count(),
            'totalVoted'  => CastedVote::whereIn('voter_id', $voterIds)->distinct('voter_id')->count(),
            'generatedAt' => now()->timezone('Asia/Manila')->format('F j, Y H:i:s T'),
        ];
    }
}