<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\UserDocument;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

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
        'pfp_path',
        'first_session',
        'email_verified_at',
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

    public function orders() {
        return $this->hasMany(Order::class);
    }

    protected static function booted()
    {
        static::created(function ($user) {
            // Créer automatiquement une chatbox pour les membres
            if ($user->role === 'member') {
                $user->chatbox()->create();
            }
        });
    }

    public function toOthers()
    {
        return $this->except($this->id);
    }

    public function scopeMembers(Builder $query)
    {
        return $query->where('role', 'member')->orderBy('id', 'desc');
    }

    public function scopeAdmins(Builder $query)
    {
        return $query->where('role', 'admin')->orderBy('id', 'desc');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function generatePasswordToken()
    {
        $this->password_token = Str::random(30);
        $this->password_token_expires_at = now()->addDay();
        $this->save();
    }

    public function generateEmailToken()
    {
        $this->email_token = Str::random(30);
        $this->email_token_expires_at = now()->addDay();
        $this->save();
    }

    public function generateUserToken()
    {
        $this->user_token = Str::random(50);
        $this->user_token_expires_at = now()->addDay();
        $this->save();
    }

    public function removePasswordToken()
    {
        $this->password_token = null;
        $this->password_token_expires_at = null;
        $this->save();
    }

    public function removeEmailToken()
    {
        $this->email_token = null;
        $this->email_token_expires_at = null;
        $this->save();
    }

    public function removeUserToken()
    {
        $this->user_token = null;
        $this->user_token_expires_at = null;
        $this->save();
    }

    public function verifyEmail()
    {
        $this->email_verified_at = now();
    }


    public function documents() {
        return $this->hasMany(UserDocument::class);
    }

    public function plans() {
        return $this->hasMany(Plan::class);
    }

    public function workouts() {
        return $this->hasMany(Workout::class);
    }

    public function hasCurrentPlan() {
        return $this->currentPlan()->exists();
    }

    public function currentPlan() {
        return $this->hasOne(Plan::class)
                ->where('expiration_date', '>', now())
                ->orderBy('expiration_date', 'desc');
    }

    public function getProfilePicture() {
        return asset('storage/' . str_replace('public/', '', $this->pfp_path)) ?? null;
    }

    public function hasChatbox() {
        return $this->chatbox()->exists();
    }

    public function chatbox() {
        return $this->hasOne(Chatbox::class);
    }

}
