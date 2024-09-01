<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $dates = ['date', 'deleted_at'];

    protected $fillable = [
        'user_id',
        'plan_id',
        'date',
        'status',
    ];

    public function plan() {
        return $this->belongsTo(Plan::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function scopeIndependant($query) {
        return $query->where('plan_id', null);
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
