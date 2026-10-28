<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSeeker extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'location',
        'job_title',
        'skills',
        'experience_level',
        'expected_salary',
        'about',
        'portfolio_url',
        'linkedin_url',
        'photo_url',
        'availability',
        'status',
    ];

    protected $casts = [
        'skills' => 'array',
    ];
}
