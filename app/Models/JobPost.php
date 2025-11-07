<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

    protected $table = 'job_posts';

    protected $fillable = [
        'company_id',
        'category_id',
        'title',
        'slug',
        'description',
        'responsibilities',
        'location',
        'work_type',
        'salary_min',
        'salary_max',
        'currency',
        'experience_level',
        'technologies',
        'status',
        'posted_at',
        'application_deadline',
    ];

    protected $casts = [
        'posted_at' => 'datetime',
        'application_deadline' => 'datetime',
        'technologies' => 'array',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

