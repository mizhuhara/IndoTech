<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_listing_id',
        'internship_id',
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
