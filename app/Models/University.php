<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'npsn',
        'type',
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
        'gallery',
        'latitude',
        'longitude',
        'map_link',
        'tags',
        'total_students',
        'total_faculties',
        'accreditation',
        'founded',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'gallery' => 'array',
            'latitude' => 'float',
            'longitude' => 'float',
            'total_students' => 'integer',
            'total_faculties' => 'integer',
            'founded' => 'integer',
        ];
    }
}
