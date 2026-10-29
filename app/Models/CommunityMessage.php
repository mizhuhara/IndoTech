<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CommunityMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'community_id',
        'user_id',
        'message',
        'type',
    ];

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(CommunityMessageAttachment::class, 'message_id');
    }

    public function isFolder(): bool
    {
        return $this->type === 'folder' || $this->attachments->contains(fn ($a) => ! empty($a->folder_name));
    }

    public function folderName(): ?string
    {
        return $this->attachments->firstWhere('folder_name', '!=', null)?->folder_name;
    }

    public function totalAttachmentSize(): int
    {
        return (int) $this->attachments->sum('file_size');
    }

    public function formattedTotalSize(): string
    {
        $bytes = $this->totalAttachmentSize();
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
}
