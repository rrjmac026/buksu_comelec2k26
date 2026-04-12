<?php

namespace App\Http\Middleware;

use App\Models\ElectionSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ElectionStatusMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $status       = ElectionSetting::status();
        $electionName = ElectionSetting::get('election_name', 'Student Council Election');

        // ── Share with ALL voter views automatically ────────────────
        view()->share('electionStatus', $status);
        view()->share('electionName', $electionName);

        // ── Block voting routes when election is not ongoing ────────
        $isVotingRoute = $request->routeIs(
            'voter.vote',
            'voter.vote.intro',
            'voter.vote.step',
            'voter.vote.step.save',
            'voter.vote.review',
            'voter.vote.store',
        );

        if ($isVotingRoute) {
            if ($status === 'upcoming') {
                return redirect()->route('voter.dashboard')
                    ->with('election_blocked', 'upcoming');
            }

            if ($status === 'ended') {
                return redirect()->route('voter.dashboard')
                    ->with('election_blocked', 'ended');
            }
        }

        return $next($request);
    }
}
