<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'events';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'organizer',
        'organizer_type',
        'category',
        'mode',
        'price',
        'date',
        'short_date',
        'full_date',
        'time',
        'location',
        'quota',
        'total_quota',
        'contact_email',
        'contact_phone',
        'description',
        'what_you_will_learn',
        'speakers',
        'image',
        'status',
        'is_verified',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'what_you_will_learn' => 'array',
            'speakers' => 'array',
            'is_verified' => 'boolean',
            'total_quota' => 'integer',
        ];
    }

    /**
     * Computed quota filled (alias for the 'quota' column value).
     */
    public function getQuotaAttribute(?string $value): ?string
    {
        return $value ?: null;
    }

    /**
     * Compute remaining quota from total_quota minus current quota.
     */
    public function getTotalQuotaAttribute(?int $value): int
    {
        return $value ?? 0;
    }

    /**
     * Convenience for Blade — human-friendly category tag.
     */
    public function getCategoryTagAttribute(): string
    {
        return strtoupper(str_replace('_', ' ', $this->category));
    }

    /**
     * Convenience for Blade — tailwind color class based on mode.
     */
    public function getModeColorAttribute(): string
    {
        return match (strtolower($this->mode)) {
            'online', 'webinar' => 'bg-emerald-500',
            'in-person', 'onsite' => 'bg-amber-600',
            'hybrid' => 'bg-indigo-600',
            default => 'bg-slate-500',
        };
    }

    /**
     * Convenience for Blade — user-friendly organizer type.
     */
    public function getTypeAttribute(): string
    {
        return $this->organizer_type;
    }

    /**
     * Convenience for Blade — proposed date (the event's date field).
     */
    public function getProposedDateAttribute(): string
    {
        return $this->date;
    }

    /**
     * Convenience for Blade — organizer logo image URL.
     */
    public function getOrganizerLogoAttribute(): ?string
    {
        return $this->attributes['organizer_logo']
            ?? ($this->relationLoaded('organizer') ? $this->organizer->logo ?? null : null)
            ?? null;
    }

    /**
     * Eager-load / normalize learning list and speakers so Blade loops
     * always receive clean arrays.
     */
    public function loadLearningAndSpeakers(): void
    {
        // speakers and what_you_will_learn are already cast to array;
        // this method is a no-op hook for controller call-sites.
        $this->setAttribute('speakers', $this->speakers);
        $this->setAttribute('what_you_will_learn', $this->what_you_will_learn);
    }
}
