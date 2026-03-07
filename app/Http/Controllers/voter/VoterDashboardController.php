<?php

namespace App\Http\Controllers\Voter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class VoterDashboardController extends Controller
{
    public function index()
    {
        return view('voter.dashboard');
    }
}