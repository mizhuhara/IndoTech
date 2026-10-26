<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Community extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'members',
        'status',
        'description',
        'website',
        'email',
        'logo_url',
        'cover_url',
        'tags',
    ];

    protected $casts = [
        'members' => 'integer',
        'tags' => 'array',
    ];

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
