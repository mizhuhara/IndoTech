<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class School extends Model
{
    protected $fillable = [
        'user_id', 'npsn', 'name', 'institution_type', 'city', 'province', 'location',
        'address', 'status', 'logo_url', 'logo_text', 'logo_bg', 'email',
        'website', 'phone', 'description', 'tags', 'total_students',
        'industry_partners', 'founded', 'user_id',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
        ];
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}