<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommunityMessageAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'community_id',
        'user_id',
        'file_name',
        'storage_path',
        'mime_type',
        'file_size',
        'file_type',
        'folder_name',
        'relative_path',
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    public function message(): BelongsTo
    {
        return $this->belongsTo(CommunityMessage::class, 'message_id');
    }

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function formattedSize(): string
    {
        $bytes = (int) $this->file_size;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2).' GB';
        }
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2).' MB';
        }
        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 1).' KB';
        }

        return $bytes.' B';
    }

    public function extension(): string
    {
        return strtolower(pathinfo($this->file_name, PATHINFO_EXTENSION));
    }

    public function isImage(): bool
    {
        return $this->file_type === 'image' || str_starts_with((string) $this->mime_type, 'image/');
    }

    public function isVideo(): bool
    {
        return $this->file_type === 'video' || str_starts_with((string) $this->mime_type, 'video/');
    }
}
