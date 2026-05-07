<?php

namespace App\Services\Reports;

use App\Models\Position;
use App\Models\College;
use App\Models\CastedVote;
use App\Models\User;
use App\Models\Candidate;
use App\Models\Feedback;
use Carbon\Carbon;

class ReportDataService
{
    // =========================================================
    //  Year-rep position → eligible voter year_level mapping
    //  Mirrors the SQL query logic exactly.
    // =========================================================

    public array $yrLevelMap = [
        'Second Year Representative' => 1,
        'Third Year Representative'  => 2,
        'Fourth Year Representative' => 3,
        'Fifth Year Representative'  => 4,
    ];

    // =========================================================
    //  Public Data Builders
    // =========================================================

    public function getSSCReportData(): array
    {
        [$totalVoters, $totalVoted] = $this->overallTurnout();

        return [
            'positions'   => $this->sscPositionsQuery()->get(),
            'totalVoters' => $totalVoters,
            'totalVoted'  => $totalVoted,
            'generatedAt' => $this->timestamp(),
        ];
    }

    public function getReportData(): array
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

            // Enrich year-rep candidates with yr_vote_count + yr_denominator
            $this->enrichYearRepCandidates($positions, $college->id);

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

    public function getSBOReportData(string $collegeAcronym): array
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

        // Enrich year-rep candidates with yr_vote_count + yr_denominator
        $this->enrichYearRepCandidates($positions, $collegeInfo->id);

        [$totalVoters, $totalVoted] = $this->collegeTurnout($collegeInfo->id);

        return [
            'college'     => $collegeInfo,
            'positions'   => $positions,
            'totalVoters' => $totalVoters,
            'totalVoted'  => $totalVoted,
            'generatedAt' => $this->timestamp(),
        ];
    }

    public function getTurnoutData(): array
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

    public function getBallotLogData(): array
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

    public function getCandidateSummaryData(): array
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

    public function getFeedbackData(): array
    {
        $feedbacks = Feedback::with(['user.college'])
            ->latest('updated_at')
            ->get();

        $totalCount    = $feedbacks->count();
        $averageRating = $totalCount > 0 ? $feedbacks->avg('rating') : 0;
        $ratingCounts  = $feedbacks->groupBy('rating')
            ->map(fn($group) => $group->count());

        return [
            'feedbacks'     => $feedbacks,
            'totalCount'    => $totalCount,
            'averageRating' => $averageRating,
            'ratingCounts'  => $ratingCounts,
            'generatedAt'   => $this->timestamp(),
        ];
    }

    // =========================================================
    //  Query Helpers
    // =========================================================

    public function sscPositionsQuery()
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

    public function sboPositionsQuery()
    {
        return Position::whereIn('id', range(4, 15))
            ->orderBy('sort_order');
    }

    // =========================================================
    //  Turnout Helpers
    // =========================================================

    public function collegeTurnout(int $collegeId): array
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

    public function overallTurnout(): array
    {
        return [
            User::where('role', 'voter')->where('status', 'Active')->count(),
            CastedVote::distinct('voter_id')->count(),
        ];
    }

    /**
     * Returns [total_enrolled, total_voted] for a specific college + year level.
     * year_level: 1 = 2nd Year Rep voters, 2 = 3rd Year, 3 = 4th Year, 4 = 5th Year
     */
    public function yrLevelTurnout(int $collegeId, int $yearLevel): array
    {
        $voterIds = User::where('role', 'voter')
            ->whereRaw('LOWER(status) = ?', ['active'])
            ->where('college_id', $collegeId)
            ->where('year_level', $yearLevel)
            ->pluck('id');

        return [
            $voterIds->count(),
            CastedVote::whereIn('voter_id', $voterIds)->distinct('voter_id')->count(),
        ];
    }

    /**
     * For year-rep positions, attach yr_vote_count (votes from the correct
     * year-level students only) and yr_denominator (total_yr_voted for that
     * college + year level) onto each candidate.
     * Non-year-rep candidates are left completely untouched.
     */
    private function enrichYearRepCandidates($positions, int $collegeId): void
    {
        foreach ($positions as $position) {
            if (! isset($this->yrLevelMap[$position->name])) {
                continue;
            }

            $yearLevel = $this->yrLevelMap[$position->name];
            [, $yrVoted] = $this->yrLevelTurnout($collegeId, $yearLevel);

            $yrVoterIds = User::where('role', 'voter')
                ->where('status', 'active')
                ->where('college_id', $collegeId)
                ->where('year_level', $yearLevel)
                ->pluck('id');

            foreach ($position->candidates as $candidate) {
                $candidate->yr_vote_count  = CastedVote::where('candidate_id', $candidate->candidate_id)
                    ->whereIn('voter_id', $yrVoterIds)
                    ->count();
                $candidate->yr_denominator = $yrVoted;
            }
        }
    }

    // =========================================================
    //  Utility
    // =========================================================

    public function timestamp(): string
    {
        return Carbon::now('Asia/Manila')->format('F j, Y H:i:s T');
    }
}