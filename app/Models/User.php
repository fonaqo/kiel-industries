<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Support\PublicAssetUrl;

#[Fillable(['name', 'email', 'password', 'phone', 'city', 'address', 'avatar_path', 'is_admin', 'is_super_admin', 'google_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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
            'is_admin' => 'boolean',
            'is_super_admin' => 'boolean',
        ];
    }

    public function wishlistItems(): HasMany
    {
        return $this->hasMany(WishlistItem::class);
    }

    protected function avatarUrl(): Attribute
    {
        return Attribute::get(function (): string {
            if ($this->avatar_path) {
                $url = PublicAssetUrl::fromStoragePath($this->avatar_path, 'media.avatars');

                if ($url !== null) {
                    return $url;
                }
            }

            return asset('assets/img/account/default-avatar.svg');
        });
    }

    protected function displayName(): Attribute
    {
        return Attribute::get(function (): string {
            $name = trim((string) $this->name);
            if ($name !== '' && ! str_contains($name, '@')) {
                return $name;
            }

            $local = strstr((string) $this->email, '@', true);

            return $local !== false && $local !== '' ? $local : 'Client KIEL';
        });
    }
}
