<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // مهم جداً
    ];

    // علاقة User مع Candidate (لو المستخدم شخص متقدم للوظائف)
    public function candidate(): HasOne
    {
        return $this->hasOne(Candidate::class);
    }

    // علاقة User مع Job (لو المستخدم Employer)
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class, 'employer_id');
    }
}
