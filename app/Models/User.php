<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role',
        'firstname',
        'lastname',
        'email',
        'password',
        'password_expires_at',
        'phone',
        'address',
        'city',
        'postal_code',
        'address_complement',
        'country',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'password_expires_at',
        'remember_token',
        'user_token',
        'user_token_expires_at',
        'email_token',
        'email_token_expires_at',
        'password_token',
        'password_token_expires_at',
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
            'password_expires_at' => 'datetime',
            'user_token_expires_at' => 'datetime',
            'email_token_expires_at' => 'datetime',
            'password_token_expires_at' => 'datetime',
            'remember_token' => 'string',
            'user_token' => 'string',
            'email_token' => 'string',
            'password_token' => 'string',
        ];
    }

    public function scopeMembers(Builder $query)
    {
        return $query->where('role', 'member')->whereNull('deleted_at')->orderBy('id', 'desc');
    }

    public function scopeAdmins(Builder $query)
    {
        return $query->where('role', 'admin')->whereNull('deleted_at')->orderBy('id', 'desc');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
