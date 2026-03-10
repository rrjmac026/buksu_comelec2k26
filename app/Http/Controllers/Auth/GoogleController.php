<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect voter to Google.
     */
    public function redirect()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    /**
     * Handle Google callback.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Google authentication failed. Please try again.');
        }

        // Only allow pre-registered voters
        $user = User::where('email', $googleUser->getEmail())
                    ->where('role', 'voter')
                    ->first();

        // Email not in the system
        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Your Google account is not registered as a voter. Please contact the administrator.');
        }

        // Account is disabled
        if ($user->status === 'inactive') {
            return redirect()->route('login')
                ->with('error', 'Your account has been deactivated. Please contact the administrator.');
        }

        // Link google_id on first login
        if (!$user->google_id) {
            $user->google_id = $googleUser->getId();
            $user->save();
        }

        Auth::login($user, true);

        return redirect()->route('voter.dashboard')
            ->with('success', 'Welcome back, ' . $user->name . '!');
    }
}