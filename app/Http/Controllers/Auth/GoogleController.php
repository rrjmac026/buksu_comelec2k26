<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect the voter to Google's OAuth page.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Google login failed. Please try again.');
        }

        // Find existing user by google_id OR email
        $user = User::where('google_id', $googleUser->getId())
                    ->orWhere('email', $googleUser->getEmail())
                    ->first();

        if ($user) {
            // Update google_id if logging in via email match for first time
            if (!$user->google_id) {
                $user->update(['google_id' => $googleUser->getId()]);
            }

            // Only allow voters via Google OAuth
            if ($user->role !== 'voter') {
                return redirect()->route('login')
                    ->with('error', 'Admin accounts cannot use Google login.');
            }

            // Block inactive voters
            if ($user->status === 'inactive') {
                return redirect()->route('login')
                    ->with('error', 'Your account is inactive. Contact the administrator.');
            }

        } else {
            // Auto-register as a new voter (incomplete profile — needs to complete later)
            $user = User::create([
                'name'      => $googleUser->getName(),
                'email'     => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'role'      => 'voter',
                'status'    => 'active',
                'password'  => null,
            ]);
        }

        Auth::login($user, remember: true);

        return redirect()->route('voter.dashboard');
    }
}