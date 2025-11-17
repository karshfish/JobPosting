<?php

namespace App\Models;

use App\Policies\JobsPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[UsePolicy(JobsPolicy::class)]
class JobPost extends Model
{
    /** @use HasFactory<\Database\Factories\JobPostFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'responsibilities',
        'skills',
        'qualifications',
        'technologies',
        'salary_min',
        'salary_max',
        'benefits',
        'location',
        'work_type',
        'branding_image',
        'application_deadline',
        'status',
    ];

    protected $casts = [
    'skills' => 'array',
    'qualifications' => 'array',
    'technologies' => 'array',
    'benefits' => 'array',
    'salary_min' => 'decimal:2',
    'salary_max' => 'decimal:2',
    'application_deadline' => 'date',
];


    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'job_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'job_id');
    }
}
