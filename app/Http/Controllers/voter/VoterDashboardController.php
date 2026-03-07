<?php

namespace App\Http\Controllers\voter;

use app\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voter;


class VoterDashboardController extends Controller
{
    public function index()
    {
        $voters = Voter::all();
        return view('voter.dashboard', compact('voters'));
    }
}