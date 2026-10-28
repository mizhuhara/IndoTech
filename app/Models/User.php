<?php

namespace App\Models;

use App\Notifications\VerifyEmailNotification;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'status', 'email_verified_at', 'avatar', 'portfolio_url', 'instagram_url', 'linkedin_url', 'cv_path', 'org_contact', 'org_phone', 'org_address', 'org_doc'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    const ADMIN_EMAIL = 'admin@indotech.id';

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'email_verified_at',
        'avatar',
        'portfolio_url',
        'instagram_url',
        'linkedin_url',
        'cv_path',
        'org_contact',
        'org_phone',
        'org_address',
        'org_doc',
    ];

    public function getAvatarUrlAttribute(): ?string
    {
        if (! $this->avatar) {
            return null;
        }

        if (str_starts_with($this->avatar, 'http://') || str_starts_with($this->avatar, 'https://')) {
            return $this->avatar;
        }

        return asset('storage/'.$this->avatar);
    }

    public function getCvUrlAttribute(): ?string
    {
        if (! $this->cv_path) {
            return null;
        }

        if (str_starts_with($this->cv_path, 'http://') || str_starts_with($this->cv_path, 'https://')) {
            return $this->cv_path;
        }

        return asset('storage/'.$this->cv_path);
    }

    public function getCvNameAttribute(): ?string
    {
        if (! $this->cv_path) {
            return null;
        }

        return basename($this->cv_path);
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification);
    }

    public function createdCommunities(): HasMany
    {
        return $this->hasMany(Community::class, 'user_id');
    }

    public function communities(): BelongsToMany
    {
        return $this->belongsToMany(Community::class)
            ->withPivot(['role', 'is_banned'])
            ->withTimestamps();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
