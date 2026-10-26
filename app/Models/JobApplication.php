<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobApplication extends Model
{
    use HasFactory;

    public const STATUS_LABELS = [
        'pending' => 'Menunggu Review',
        'reviewed' => 'Sedang Ditinjau',
        'shortlisted' => 'Masuk Shortlist',
        'rejected' => 'Tidak Lolos',
    ];

    protected $fillable = [
        'job_listing_id',
        'internship_id',
        'user_id',
        'full_name',
        'email',
        'phone',
        'linkedin',
        'portfolio',
        'cover_letter',
        'resume_path',
        'status',
    ];

    public function jobListing(): BelongsTo
    {
        return $this->belongsTo(JobListing::class);
    }

    public function internship(): BelongsTo
    {
        return $this->belongsTo(Internship::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(JobApplicationStatusHistory::class)->latest('id');
    }

    public function statusLabel(): string
    {
        return self::STATUS_LABELS[$this->status] ?? ucfirst($this->status);
    }

    public function positionTitle(): string
    {
        return $this->jobListing?->title
            ?? $this->internship?->title
            ?? 'Lowongan tidak tersedia';
    }

    public function companyName(): string
    {
        return $this->jobListing?->company
            ?? $this->internship?->company
            ?? '-';
    }
}
