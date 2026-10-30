<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'npsn',
        'type',
        'industry',
        'city',
        'province',
        'location',
        'address',
        'status',
        'logo_url',
        'logo_name',
        'logo_text',
        'logo_bg',
        'email',
        'website',
        'phone',
        'description',
        'tags',
        'total_employees',
        'founded',
        'projects_completed',
        'specialties',
        'tech_stack',
        'gallery',
        'latitude',
        'longitude',
        'map_link',
    ];

    protected $casts = [
        'tags' => 'array',
        'specialties' => 'array',
        'tech_stack' => 'array',
        'gallery' => 'array',
        'total_employees' => 'integer',
        'founded' => 'integer',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];
}
