<?php

namespace App\Models;

use App\Policies\JobsPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[UsePolicy(JobsPolicy::class)]
class JobPost extends Model
{

    /** @use HasFactory<\Database\Factories\JobPostFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'responsibilities',
        'skills',
        'qualifications',
        'salary_range',
        'benefits',
        'category',
        'location',
        'work_type',
        'branding_image',
        'application_deadline',
        'status',
    ];
    protected $casts = [
        'skills' => 'array',
        'qualifications' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function applications()
    // {
    //     return $this->hasMany(JobApplication::class);
    // }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'job_id');
    }
}
