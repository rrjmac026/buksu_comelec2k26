<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
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

    public function callback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')
                ->setHttpClient(new Client(['verify' => false]))
                ->user();

        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Google authentication failed: ' . $e->getMessage());
        }

        $user = User::where('email', $googleUser->getEmail())
                    ->where('role', 'voter')
                    ->first();

        if (!$user) {
            // Log failed attempt (unregistered Google account)
            ActivityLog::record(
                event: 'login_failed',
                email: $googleUser->getEmail(),
                ip:    $request->ip(),
                ua:    $request->userAgent() ?? ''
            );

            return redirect()->route('login')
                ->with('error', 'Your Google account is not registered as a voter. Please contact the administrator.');
        }

        if ($user->status === 'inactive') {
            ActivityLog::record(
                event: 'login_failed',
                user:  $user,
                ip:    $request->ip(),
                ua:    $request->userAgent() ?? ''
            );

            return redirect()->route('login')
                ->with('error', 'Your account has been deactivated. Please contact the administrator.');
        }

        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'google_id'  => $googleUser->getId(),
                'updated_at' => now(),
            ]);

        $user = User::find($user->id);

        Auth::login($user, true);
        $request->session()->regenerate();

        // ── Log Google login ───────────────────────────────────
        ActivityLog::record(
            event: 'login',
            user:  $user,
            ip:    $request->ip(),
            ua:    $request->userAgent() ?? ''
        );

        return redirect()->route('voter.dashboard')
            ->with('success', 'Welcome back, ' . $user->full_name . '!');
    }
}