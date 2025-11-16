<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class LinkedInController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('linkedin')
            ->scopes(['r_liteprofile', 'r_emailaddress'])
            ->redirect();
    }

    public function callback()
    {
        try {
            $linkedinUser = Socialite::driver('linkedin')->user();
        } catch (\Exception $e) {
            return redirect('/profile')->with('error', 'Failed to authenticate with LinkedIn.');
        }

        auth()->user()->update([
            'linkedin_data' => [
                'id'        => $linkedinUser->id,
                'name'      => $linkedinUser->name,
                'email'     => $linkedinUser->email,
                'avatar'    => $linkedinUser->avatar,
            ]
        ]);

        return redirect('/profile')->with('success', 'LinkedIn data imported successfully.');
    }
}
