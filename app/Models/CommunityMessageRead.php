<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommunityMessageRead extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'community_id',
        'last_read_message_id',
        'last_read_at',
    ];

    protected $casts = [
        'last_read_at' => 'datetime',
        'last_read_message_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }
}
