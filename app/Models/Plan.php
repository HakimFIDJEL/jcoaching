<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Plan extends Model
{
    use HasFactory;

    protected $dates = [
        'start_date',
        'expiration_date',
    ];

    protected $fillable = [
        'user_id',
        'pricing_id',
        'start_date',
        'expiration_date',
        'nutrition_option',
        'sessions_left',
    ];

    public function isExpired() {
        return now() > $this->expiration_date;
    }

    public function pricing() {
        return $this->belongsTo(Pricing::class);
    }

    public function workouts() {
        return $this->hasMany(Workout::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getDaysLeft() {
        return intval(now()->diffInDays($this->expiration_date));
    }

    public function softDelete() {
        $this->deleted_at = now();
        $this->save();
    }

    public function restore() {
        $this->deleted_at = null;
        $this->save();
    }

    
}
