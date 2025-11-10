<?php

namespace App\Models;

use App\Policies\CommentsPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[UsePolicy(CommentsPolicy::class)]
class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'user_id',
        'content',
        'parent_id',
    ];

    public function job()
    {
        return $this->belongsTo(JobPost::class, 'job_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
