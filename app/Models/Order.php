<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'status',
        'user_id',
        'stripe_session_id',
        'reduction_id',
        'total_price',
        'description',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function reduction() {
        return $this->belongsTo(Reduction::class);
    }

    public function plan() {
        return $this->hasOne(Plan::class);
    }

    public function workouts() {
        return $this->hasMany(Workout::class);
    }

}
