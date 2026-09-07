<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        'npsn', 'name', 'institution_type', 'city', 'province', 'location',
        'address', 'status', 'logo_url', 'logo_text', 'logo_bg', 'email',
        'website', 'phone', 'description', 'tags', 'total_students',
        'industry_partners', 'founded', 'accreditation',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
        ];
    }
}