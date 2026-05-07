<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Reports\ReportDataService;
use App\Services\Reports\PdfGeneratorService;

class AdminReportController extends Controller
{
    public function __construct(
        private readonly ReportDataService   $data,
        private readonly PdfGeneratorService $pdf,
    ) {}

    public function results()
    {
        return $this->pdf->generateSSCPDF(
            $this->data->getSSCReportData(),
            'SSC_election_results.pdf'
        );
    }

    public function byCollege()
    {
        return $this->pdf->generateFullPDF(
            $this->data->getReportData(),
            'ALL_election_results.pdf'
        );
    }

    public function turnout()
    {
        return $this->pdf->generateTurnoutPDF(
            $this->data->getTurnoutData(),
            'voter_turnout.pdf'
        );
    }

    public function ballots()
    {
        return $this->pdf->generateBallotLogPDF(
            $this->data->getBallotLogData(),
            'ballot_transaction_log.pdf'
        );
    }

    public function candidates()
    {
        return $this->pdf->generateCandidateSummaryPDF(
            $this->data->getCandidateSummaryData(),
            'candidate_summary.pdf'
        );
    }

    public function feedback()
    {
        return $this->pdf->generateFeedbackPDF(
            $this->data->getFeedbackData(),
            'voter_feedback.pdf'
        );
    }
}