<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Google authentication failed. Please try again.');
        }

        // Find pre-registered voter by email
        $user = User::where('email', $googleUser->getEmail())
                    ->where('role', 'voter')
                    ->first();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Your Google account is not registered as a voter. Please contact the administrator.');
        }

        if ($user->status === 'inactive') {
            return redirect()->route('login')
                ->with('error', 'Your account has been deactivated. Please contact the administrator.');
        }

        // Save google_id using raw DB to bypass all mutators/casts
        if (!$user->google_id) {
            DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'google_id'  => $googleUser->getId(),
                    'updated_at' => now(),
                ]);
        }

        // Re-fetch fresh model after DB update
        $user = User::find($user->id);

        Auth::login($user, true);

        return redirect()->route('voter.dashboard')
            ->with('success', 'Welcome back, ' . $user->name . '!');
    }
}