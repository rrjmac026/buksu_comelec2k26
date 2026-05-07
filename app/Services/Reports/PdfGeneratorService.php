<?php

namespace App\Services\Reports;

use App\Helpers\CustomPDF;
use Carbon\Carbon;

class PdfGeneratorService
{
    // =========================================================
    //  Brand Palette (from Welcome Blade)
    //  Deep purple:  56,  0,  65  (#380041)
    //  Gold:        249,180, 15   (#f9b40f)
    //  Gold light:  252,213, 88   (#fcd558)
    //  Row even:    243,234,247   (#f3eaf7 — soft lavender)
    //  Row odd:     255,255,255   (white)
    //  Body text:    26,  0, 38   (#1a0026 — near-black purple)
    //  Muted text:   80, 50, 90   (mid-purple gray)
    // =========================================================

    // =========================================================
    //  PDF Generators (public entry points)
    // =========================================================

    public function generateSSCPDF(array $data, string $filename)
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

    public function generateSBOPDF(array $data, string $filename)
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

    public function generateFullPDF(array $data, string $filename)
    {
        $pdf = $this->makePDF('P');
        $pdf->AddPage();

        $this->addHeaderToPage($pdf, 'All Election Results', $data['generatedAt']);
        $this->addStatsSection($pdf, $data);

        $pdf->SetTextColor(56, 0, 65);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Supreme Student Council (SSC) Results', 0, 1, 'L');
        $pdf->SetTextColor(26, 0, 38);
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

            $pdf->SetTextColor(56, 0, 65);
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(0, 10, $this->utf8($college['college']->name . ' Results'), 0, 1, 'L');
            $pdf->SetTextColor(26, 0, 38);
            $pdf->Ln(2);

            if ($college['positions']->isNotEmpty()) {
                $this->drawTableHeader($pdf, $widths);

                foreach ($college['positions'] as $position) {
                    if ($pdf->GetY() > 250) {
                        $pdf->AddPage();
                        $pdf->SetTextColor(56, 0, 65);
                        $pdf->SetFont('Arial', 'B', 14);
                        $pdf->Cell(0, 10, $this->utf8($college['college']->name . ' Results (continued)'), 0, 1, 'L');
                        $pdf->SetTextColor(26, 0, 38);
                        $pdf->Ln(2);
                        $this->drawTableHeader($pdf, $widths);
                    }
                    $this->drawPositionSection($pdf, $position, $college['totalVoted'], $widths, $college['college']->id);
                }
            } else {
                $pdf->SetFont('Arial', '', 11);
                $pdf->SetTextColor(80, 50, 90);
                $pdf->Cell(0, 10, 'No candidates found for this college.', 0, 1, 'L');
                $pdf->SetTextColor(26, 0, 38);
            }
        }

        $pdf->AddSignatories();
        return $pdf->Output('D', $filename);
    }

    public function generateTurnoutPDF(array $data, string $filename)
    {
        $pdf = $this->makePDF('P');
        $pdf->AddPage();

        $this->addHeaderToPage($pdf, 'Voter Turnout Report', $data['generatedAt']);
        $this->addStatsSection($pdf, $data);

        $pdf->SetTextColor(56, 0, 65);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Turnout by College', 0, 1, 'L');
        $pdf->SetTextColor(26, 0, 38);
        $pdf->Ln(2);

        $cw = [80, 35, 35, 30];

        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetFillColor(56, 0, 65);
        $pdf->SetTextColor(249, 180, 15);
        foreach (['College', 'Total Voters', 'Votes Cast', 'Turnout'] as $i => $h) {
            $pdf->Cell($cw[$i], 10, $h, 1, 0, 'C', true);
        }
        $pdf->Ln();
        $pdf->SetTextColor(26, 0, 38);

        foreach ($data['collegeStats'] as $i => $row) {
            $fill = $i % 2 === 0;
            $pdf->SetFillColor(...($fill ? [243, 234, 247] : [255, 255, 255]));
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell($cw[0], 10, $this->utf8($row['name']),          1, 0, 'L', $fill);
            $pdf->Cell($cw[1], 10, number_format($row['totalVoters']), 1, 0, 'C', $fill);
            $pdf->Cell($cw[2], 10, number_format($row['votedCount']),  1, 0, 'C', $fill);
            $pdf->Cell($cw[3], 10, $row['percentage'] . '%',           1, 0, 'C', $fill);
            $pdf->Ln();
        }

        $pdf->Ln(8);
        $pdf->SetTextColor(56, 0, 65);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Non-Voters (' . $data['nonVoters']->count() . ')', 0, 1, 'L');
        $pdf->SetTextColor(26, 0, 38);
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
            $pdf->SetFillColor(...($fill ? [243, 234, 247] : [255, 255, 255]));
            $pdf->SetFont('Arial', '', 10);
            $pdf->SetTextColor(26, 0, 38);
            $pdf->Cell($nw[0], 10, $this->utf8($voter->full_name),                1, 0, 'L', $fill);
            $pdf->Cell($nw[1], 10, $this->utf8($voter->student_number ?? '-'),    1, 0, 'C', $fill);
            $pdf->Cell($nw[2], 10, $this->utf8($voter->college?->acronym ?? '-'), 1, 0, 'C', $fill);
            $pdf->Cell($nw[3], 10, $this->utf8($voter->course ?? '-'),            1, 0, 'L', $fill);
            $pdf->Ln();
        }

        $pdf->AddSignatories();
        return $pdf->Output('D', $filename);
    }

    public function generateBallotLogPDF(array $data, string $filename)
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

            $fill  = $i % 2 === 0;
            $pdf->SetFillColor(...($fill ? [243, 234, 247] : [255, 255, 255]));
            $first = $votes->first();
            $voter = $first->voter;
            $time  = Carbon::parse($first->voted_at)->timezone('Asia/Manila')->format('M j, Y H:i');

            $pdf->SetFont('Arial', '', 9);
            $pdf->SetTextColor(26, 0, 38);
            $pdf->Cell($cw[0], 10, $this->utf8($txn),                              1, 0, 'L', $fill);
            $pdf->Cell($cw[1], 10, $this->utf8($voter?->full_name ?? '-'),          1, 0, 'L', $fill);
            $pdf->Cell($cw[2], 10, $this->utf8($voter?->student_number ?? '-'),     1, 0, 'C', $fill);
            $pdf->Cell($cw[3], 10, $this->utf8($voter?->college?->acronym ?? '-'),  1, 0, 'C', $fill);
            $pdf->Cell($cw[4], 10, $this->utf8($time),                              1, 0, 'C', $fill);
            $pdf->Ln();
        }

        $pdf->AddSignatories();
        return $pdf->Output('D', $filename);
    }

    public function generateCandidateSummaryPDF(array $data, string $filename)
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
            $pdf->SetFillColor(...($fill ? [243, 234, 247] : [255, 255, 255]));
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetTextColor(26, 0, 38);
            $pdf->Cell($cw[0], 10, $this->utf8($candidate->full_name),                                  1, 0, 'L', $fill);
            $pdf->Cell($cw[1], 10, $this->utf8($candidate->position?->name ?? '-'),                     1, 0, 'L', $fill);
            $pdf->Cell($cw[2], 10, $this->utf8($candidate->partylist?->name ?? '-'),                    1, 0, 'C', $fill);
            $pdf->Cell($cw[3], 10, $this->utf8($candidate->college?->acronym ?? '-'),                   1, 0, 'C', $fill);
            $pdf->Cell($cw[4], 10, $this->utf8($candidate->organization?->acronym ?? '-'),              1, 0, 'C', $fill);
            $pdf->Cell($cw[5], 10, $this->utf8($this->truncate($candidate->course ?? '-', 18)),         1, 0, 'L', $fill);
            $pdf->Cell($cw[6], 10, $candidate->vote_count ?? 0,                                         1, 0, 'R', $fill);
            $pdf->Ln();
        }

        $pdf->AddSignatories();
        return $pdf->Output('D', $filename);
    }

    public function generateFeedbackPDF(array $data, string $filename)
    {
        $pdf = $this->makePDF('P');
        $pdf->AddPage();

        $this->addHeaderToPage($pdf, 'Voter Feedback Report', $data['generatedAt']);

        $pdf->SetTextColor(56, 0, 65);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Feedback Summary', 0, 1, 'L');
        $pdf->SetTextColor(26, 0, 38);
        $pdf->SetFont('Arial', '', 12);

        $stars = [1 => 'Poor', 2 => 'Fair', 3 => 'Good', 4 => 'Great', 5 => 'Excellent'];

        foreach ([
            ['Total Responses:', number_format($data['totalCount'])],
            ['Average Rating:',  number_format($data['averageRating'], 2) . ' / 5.00'],
        ] as $stat) {
            $pdf->SetTextColor(80, 50, 90);
            $pdf->Cell(60, 8, $stat[0], 0, 0, 'L');
            $pdf->SetTextColor(26, 0, 38);
            $pdf->Cell(0,  8, $stat[1], 0, 1, 'L');
        }
        $pdf->Ln(2);

        $pdf->SetTextColor(56, 0, 65);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(0, 8, 'Rating Breakdown', 0, 1, 'L');
        $pdf->SetTextColor(26, 0, 38);

        $barMaxWidth = 100;
        foreach ([5, 4, 3, 2, 1] as $star) {
            $count = $data['ratingCounts'][$star] ?? 0;
            $pct   = $data['totalCount'] > 0 ? round($count / $data['totalCount'] * 100, 1) : 0;
            $fill  = (int) round($barMaxWidth * $pct / 100);
            $label = $star . ' - ' . $stars[$star];

            $pdf->SetFont('Arial', '', 9);
            $pdf->SetTextColor(80, 50, 90);
            $pdf->Cell(28, 7, $label, 0, 0, 'L');

            $pdf->SetFillColor(232, 216, 240);
            $pdf->Cell($barMaxWidth, 5, '', 1, 0, 'L', true);

            if ($fill > 0) {
                $x = $pdf->GetX() - $barMaxWidth;
                $y = $pdf->GetY();
                $pdf->SetXY($x, $y);
                $pdf->SetFillColor(249, 180, 15);
                $pdf->Cell($fill, 5, '', 0, 0, 'L', true);
                $pdf->SetXY($x + $barMaxWidth, $y);
            }

            $pdf->SetFont('Arial', '', 9);
            $pdf->SetTextColor(26, 0, 38);
            $pdf->Cell(0, 5, '  ' . number_format($count) . ' (' . $pct . '%)', 0, 1, 'L');
            $pdf->Ln(2);
        }

        $pdf->Ln(6);

        $pdf->SetTextColor(56, 0, 65);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Individual Responses (' . number_format($data['totalCount']) . ')', 0, 1, 'L');
        $pdf->SetTextColor(26, 0, 38);
        $pdf->Ln(2);

        $cw      = [50, 25, 22, 83];
        $headers = ['Voter Name', 'College', 'Rating', 'Feedback'];
        $this->drawSmallHeader($pdf, $cw, $headers);

        foreach ($data['feedbacks'] as $i => $fb) {
            if ($pdf->GetY() + 10 > 265) {
                $pdf->AddPage();
                $this->drawSmallHeader($pdf, $cw, $headers);
            }

            $fill      = $i % 2 === 0;
            $pdf->SetFillColor(...($fill ? [243, 234, 247] : [255, 255, 255]));
            $ratingStr = $fb->rating . ' - ' . ($stars[$fb->rating] ?? '-');

            $pdf->SetFont('Arial', '', 9);
            $pdf->SetTextColor(26, 0, 38);
            $pdf->Cell($cw[0], 10, $this->utf8($fb->user?->full_name ?? '-'),                       1, 0, 'L', $fill);
            $pdf->Cell($cw[1], 10, $this->utf8($fb->user?->college?->acronym ?? '-'),               1, 0, 'C', $fill);
            $pdf->Cell($cw[2], 10, $ratingStr,                                                       1, 0, 'C', $fill);
            $pdf->Cell($cw[3], 10, $this->utf8($this->truncate($fb->feedback ?? '-', 120)),         1, 0, 'L', $fill);
            $pdf->Ln();
        }

        $pdf->AddSignatories();
        return $pdf->Output('D', $filename);
    }

    // =========================================================
    //  PDF Factory
    // =========================================================

    private function makePDF(string $orientation = 'P'): CustomPDF
    {
        $pdf = new CustomPDF($orientation, 'mm', 'A4');
        $pdf->SetAutoPageBreak(true, 25);
        $pdf->AliasNbPages();
        $pdf->SetMargins(15, 15, 15);
        return $pdf;
    }

    // =========================================================
    //  Shared PDF Draw Helpers
    // =========================================================

    private function addHeaderToPage($pdf, string $title, string $date): void
    {
        $timestamp = Carbon::now('Asia/Manila')->format('F j, Y H:i:s T');

        $pdf->SetTextColor(56, 0, 65);
        $pdf->SetFont('Arial', 'B', 16);
        foreach (explode("\n", $title) as $line) {
            $pdf->Cell(0, 10, $this->utf8($line), 0, 1, 'C');
        }

        $pdf->SetTextColor(80, 50, 90);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'Generated on: ' . $timestamp, 0, 1, 'C');

        $pdf->SetDrawColor(249, 180, 15);
        $pdf->SetLineWidth(0.8);
        $pdf->Line(15, $pdf->GetY(), $pdf->GetPageWidth() - 15, $pdf->GetY());
        $pdf->SetLineWidth(0.2);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetTextColor(26, 0, 38);
        $pdf->Ln(6);
    }

    private function addStatsSection($pdf, array $data): void
    {
        $totalVoters = $data['totalVoters'] ?? 0;
        $totalVoted  = $data['totalVoted']  ?? 0;
        $pct         = $totalVoters > 0 ? round($totalVoted / $totalVoters * 100, 2) : 0;

        $pdf->SetTextColor(56, 0, 65);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Voting Statistics', 0, 1, 'L');

        $pdf->SetFont('Arial', '', 12);
        foreach ([
            ['Total Eligible Voters:', number_format($totalVoters)],
            ['Total Votes Cast:',      number_format($totalVoted)],
            ['Voter Turnout:',         $pct . '%'],
        ] as $stat) {
            $pdf->SetTextColor(80, 50, 90);
            $pdf->Cell(60, 8, $stat[0], 0, 0, 'L');
            $pdf->SetTextColor(26, 0, 38);
            $pdf->Cell(0,  8, $stat[1], 0, 1, 'L');
        }
        $pdf->SetTextColor(26, 0, 38);
        $pdf->Ln(5);
    }

    private function drawTableHeader($pdf, array $widths): void
    {
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetFillColor(56, 0, 65);
        $pdf->SetTextColor(249, 180, 15);

        foreach (['Candidate Name', 'College', 'Partylist', 'Votes', '%'] as $i => $h) {
            $pdf->Cell($widths[$i], 10, $h, 1, 0, 'C', true);
        }
        $pdf->Ln();
        $pdf->SetTextColor(26, 0, 38);
        $pdf->SetFillColor(255, 255, 255);
    }

    private function drawPositionSection($pdf, $position, int $totalVoted, array $widths, ?int $collegeId = null): void
    {
        $widths = [70, 30, 35, 25, 20];

        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetTextColor(56, 0, 65);
        $pdf->Cell(0, 8, $this->utf8($position->name), 0, 1, 'L');
        $pdf->SetTextColor(26, 0, 38);
        $pdf->SetFont('Arial', '', 10);

        $candidates = $collegeId
            ? $position->candidates->where('college_id', $collegeId)
            : $position->candidates;

        foreach ($candidates as $index => $candidate) {
            if ($pdf->GetY() > 270) {
                $pdf->AddPage();
                $this->drawTableHeader($pdf, $widths);
            }
            $this->drawCandidateRow($pdf, $candidate, $totalVoted, $widths, $index % 2 == 0);
        }

        $pdf->Ln(3);
    }

    private function drawCandidateRow($pdf, $candidate, int $totalVoted, array $widths, bool $fill = false): void
    {
        $pct = $totalVoted > 0 ? round($candidate->vote_count / $totalVoted * 100, 2) : 0;

        $pdf->SetFillColor(...($fill ? [243, 234, 247] : [255, 255, 255]));
        $pdf->SetTextColor(26, 0, 38);

        $pdf->Cell($widths[0], 10, $this->utf8($candidate->full_name),                  1, 0, 'L', $fill);
        $pdf->Cell($widths[1], 10, $this->utf8($candidate->college?->acronym  ?? '-'),  1, 0, 'C', $fill);
        $pdf->Cell($widths[2], 10, $this->utf8($candidate->partylist?->acronym ?? '-'), 1, 0, 'C', $fill);
        $pdf->Cell($widths[3], 10, $candidate->vote_count,                              1, 0, 'R', $fill);
        $pdf->Cell($widths[4], 10, $pct . '%',                                          1, 0, 'R', $fill);
        $pdf->Ln();
    }

    private function drawSmallHeader($pdf, array $widths, array $headers): void
    {
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetFillColor(56, 0, 65);
        $pdf->SetTextColor(249, 180, 15);
        foreach ($headers as $i => $h) {
            $pdf->Cell($widths[$i], 10, $h, 1, 0, 'C', true);
        }
        $pdf->Ln();
        $pdf->SetTextColor(26, 0, 38);
        $pdf->SetFillColor(255, 255, 255);
    }

    // =========================================================
    //  Utilities
    // =========================================================

    /**
     * Convert UTF-8 string to windows-1252 for FPDF compatibility.
     * FPDF does not support UTF-8 natively; all text must be in Latin-1/windows-1252.
     * //TRANSLIT replaces unmappable chars with ASCII equivalents.
     * //IGNORE  silently drops anything that cannot be transliterated.
     */
    private function utf8(string $text): string
    {
        return iconv('UTF-8', 'windows-1252//TRANSLIT//IGNORE', $text);
    }

    private function truncate(string $text, int $max): string
    {
        return mb_strlen($text) > $max ? mb_substr($text, 0, $max - 1) . '...' : $text;
    }
}