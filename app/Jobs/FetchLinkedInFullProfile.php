<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\LinkedInService;

class FetchLinkedInFullProfile implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(LinkedInService $service)
    {
        if (! $this->user->linkedin_token) return;

        $mapped = $service->fetchFullProfile($this->user->linkedin_token);
        if ($mapped) {
            $this->user->update([
                'linkedin_data' => array_merge($this->user->linkedin_data ?? [], $mapped)
            ]);
        }
    }
}
