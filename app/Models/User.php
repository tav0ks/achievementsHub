<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'steam_id',
        'retroachievements_username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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

    /**
     * Get the user's Steam ID.
     */
    public function getSteamId(): ?string
    {
        return $this->steam_id;
    }

    /**
     * Set the user's Steam ID.
     */
    public function setSteamId(string $steamId): void
    {
        $this->steam_id = $steamId;
    }

    /**
     * Determine if the user has a Steam ID.
     */
    public function hasSteamId(): bool
    {
        return $this->steam_id !== null;
    }

    /**
     * Get the user's Steam profile URL.
     */
    public function getSteamProfileUrl(): ?string
    {
        return $this->hasSteamId() ? "https://steamcommunity.com/profiles/{$this->steam_id}" : null;
    }
}
