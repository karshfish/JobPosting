<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class LinkedInService
{
    protected $base = 'https://api.linkedin.com/v2';

    public function fetchFullProfile(string $accessToken)
    {
        $headers = [
            'Authorization' => "Bearer {$accessToken}",
            'X-Restli-Protocol-Version' => '2.0.0',
        ];

        // Get basic profile fields (projection). See LinkedIn API docs for correct projections.
        $profile = Http::withHeaders($headers)
            ->get("{$this->base}/me?projection=(id,firstName,lastName,profilePicture(displayImage~:playableStreams))");

        $email = Http::withHeaders($headers)
            ->get("{$this->base}/emailAddress?q=members&projection=(elements*(handle~))");

        if ($profile->failed()) {
            return null;
        }

        // Map fields into a consistent structure for your application
        $mapped = [
            'id' => $profile->json('id'),
            'first_name' => $this->localizedValue($profile->json('firstName')),
            'last_name' => $this->localizedValue($profile->json('lastName')),
            'email' => $email->json('elements.0.handle~.emailAddress') ?? null,
            // profile picture mapping
            'avatar' => $this->extractProfilePicture($profile->json('profilePicture')),
            // TODO: fetch other endpoints for experience/education if scopes + permissions allowed
        ];

        return $mapped;
    }

    protected function localizedValue($field)
    {
        // LinkedIn stores localized fields in `localized` keyed by locale. pick first value.
        if (! $field) return null;
        $localized = $field['localized'] ?? null;
        if ($localized && is_array($localized)) {
            return array_values($localized)[0] ?? null;
        }
        return null;
    }

    protected function extractProfilePicture($field)
    {
        // Defensive — find best available image
        if (! $field) return null;
        $streams = data_get($field, 'displayImage~.elements', []);
        $last = end($streams);
        if ($last && ! empty($last['identifiers'])) {
            return $last['identifiers'][0]['identifier'] ?? null;
        }
        return null;
    }
}
