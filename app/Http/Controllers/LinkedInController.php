<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Services\LinkedInService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class LinkedInController extends Controller
{
    protected $service;

    public function __construct(LinkedInService $service)
    {
        $this->service = $service;
    }

    public function redirect()
    {
        // request minimal scopes, r_liteprofile + r_emailaddress. Request other scopes if needed and approved by LinkedIn.
        return Socialite::driver('linkedin')
            ->scopes(['r_liteprofile', 'r_emailaddress'])
            ->redirect();
    }

    public function callback(Request $request)
    {
        try {
            $linkedinUser = Socialite::driver('linkedin')->user();
            // dd($linkedinUser);
        } catch (\Exception $e) {
            \Log::error('LinkedIn Auth Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            // Show detailed error in local/dev, generic in production
            $errorMsg = app()->environment('local', 'development')
                ? 'LinkedIn authentication failed: ' . $e->getMessage()
                : 'LinkedIn authentication failed. Please try again.';
            return redirect()->route('home')->with('error', $errorMsg);
        }

        $user = auth()->user();

        // Save basic info and tokens
        $user->update([
            'linkedin_id' => $linkedinUser->id,
            'linkedin_data' => [
                'name' => $linkedinUser->getName(),
                'email' => $linkedinUser->getEmail(),
                'avatar' => $linkedinUser->getAvatar(),
            ],
            'linkedin_token' => $linkedinUser->token,
            // Socialite might provide refresh token and expiresIn depending on provider & config
            'linkedin_refresh_token' => property_exists($linkedinUser, 'refreshToken') ? $linkedinUser->refreshToken : null,
            'linkedin_token_expires_at' => $linkedinUser->expiresIn ? now()->addSeconds($linkedinUser->expiresIn) : null,
        ]);

        // Optionally fetch richer profile async or now
        // dispatch(new \App\Jobs\FetchLinkedInFullProfile($user));

        return redirect()->route('profile')->with('success', 'LinkedIn connected successfully.');
    }

    // optional: returns mapped data for UI (like prefill)
    public function profile()
    {
        $user = auth()->user();

        return response()->json([
            'linkedin_data' => $user->linkedin_data,
            'connected' => (bool) $user->linkedin_id,
        ]);
    }
}
