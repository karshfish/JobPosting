<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;   // ✅ add this
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;   // ✅


class User extends Authenticatable
{
    use HasFactory, Notifiable , HasRoles;            // ✅ remove

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // if you’re storing a string role on users table
    ];

    public function candidate(): HasOne
    {
        return $this->hasOne(Candidate::class);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class, 'employer_id');
    }
}
