<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Establishment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Edwink\FilamentUserActivity\Traits\UserActivityTrait;
use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use BezhanSalleh\FilamentShield\Facades\FilamentShield;
use BezhanSalleh\FilamentShield\Support\Utils;
use EightyNine\FilamentPasswordExpiry\Concerns\HasPasswordExpiry;

use Illuminate\Support\Facades\Route;


class User extends Authenticatable implements FilamentUser, MustVerifyEmail, HasAvatar, HasName, HasMedia
{
    use InteractsWithMedia;
    use HasUuids, HasRoles;
    use HasApiTokens, HasFactory, Notifiable;
    use TwoFactorAuthenticatable;
    use HasPanelShield;
    // use HasPasswordExpiry;

     /**
     * The primary key associated with the table.
     *
     * @var string
     */

     /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */

    /**
     * The data type of the primary key ID.
     *
     * @var string
     */

     protected $primaryKey = 'id';
     public $incrementing = false;
     protected $keyType = 'string';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'location',
        'email',
        'firstname',
        'lastname',
        'password',
        'authority',
        'est_id',
        'password_expires_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getFilamentName(): string
    {
        return $this->username;
    }

    protected static function booted(): void
    {
        if(config('filament-shield.admin.enabled', false)){
            FilamentShield::createRole(name: config('filament-shield.admin.name', 'admin'));
        }
        if(config('filament-shield.focal.enabled', false)){
            FilamentShield::createRole(name: config('filament-shield.focal.name', 'focal'));
        }
        if(config('filament-shield.focal.enabled', false)){
            FilamentShield::createRole(name: config('filament-shield.focal_custom.name', 'focal_custom'));
        }
        if(config('filament-shield.bwc_focal.enabled', false)){
            FilamentShield::createRole(name: config('filament-shield.bwc_focal.name', 'bwc_focal'));
        }
        if(config('filament-shield.user.enabled', false)){
            FilamentShield::createRole(name: config('filament-shield.user.name', 'user'));
        }
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // dd(Route::currentRouteName());
        if (Route::currentRouteName() === 'filament.user.auth.email-verification.verify' || Route::currentRouteName() === 'filament.user.auth.email-verification.prompt' || str_starts_with(Route::currentRouteName(), 'filament.user.auth.email-verification.')) {
            return true;
        }
        if ($panel->getId() === 'admin') {
            // return $this->hasRole('admin') || $this->hasRole('super_admin') && $this->hasVerifiedEmail();
            return $this->hasRole('admin') || $this->hasRole(Utils::getSuperAdminName());
        } elseif ($panel->getId() === 'user') {
            return $this->hasRole('user');
        } elseif ($panel->getId() === 'bwc_focal') {
            return $this->hasRole('bwc_focal') || $this->hasRole('bwc_custom');
        } elseif ($panel->getId() === 'focal') {
            return ($this->hasRole('focal') || $this->hasRole('focal_custom'));
        } else {
            return false;
        }
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->getMedia('avatars')?->first()?->getUrl() ?? $this->getMedia('avatars')?->first()?->getUrl('thumb') ?? null;
    }

    // Define an accessor for the 'name' attribute
    public function getNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole(config('filament-shield.super_admin.name'));
    }

    public function registerMediaConversions(Media|null $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }
}
