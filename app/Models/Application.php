<?php

namespace App\Models;

use App\Policies\ApplicationsPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[UsePolicy(ApplicationsPolicy::class)]
class Application extends Model
{

    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'job_id',
        'resume',
        'status',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function job()
    {
        return $this->belongsTo(JobPost::class);
    }
}
