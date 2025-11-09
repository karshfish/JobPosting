<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
protected $fillable = [
'employer_id',
'title',
'description',
'skills',
'location',
'work_type',
'salary_min',
'salary_max',
'status',
'deadline',
];

// علاقة كل وظيفة بصاحبها (Employer)
public function employer()
{
return $this->belongsTo(User::class, 'employer_id');
}

// علاقة الوظيفة بالـ Applications المقدمة عليها
public function applications()
{
return $this->hasMany(Application::class);
}
}
