<?php

namespace App\Models;

use App\Policies\ApplicationsPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\JobPost;

#[UsePolicy(ApplicationsPolicy::class)]
class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_id',
        'resume',
        'status',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function job()
{
    return $this->belongsTo(JobPost::class, 'job_id');
}
}
