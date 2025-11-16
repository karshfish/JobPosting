<?php

namespace App\Services;

class LinkedInService
{
    public function mapLinkedInData($data)
    {
        return [
            'first_name' => $data['firstName']['localized'] ?? null,
            'last_name' => $data['lastName']['localized'] ?? null,
            'headline' => $data['headline'] ?? null,
            'email' => $data['email'] ?? null,
            'picture' => $data['picture'] ?? null,
        ];
    }
}
