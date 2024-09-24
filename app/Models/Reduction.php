<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reduction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'percentage',
        'start_date',
        'end_date',
        'online',
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];

    public function scopeAvailable($query)
    {
        return $query->where('online', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }   

    public function isAvailable(): bool
    {
        return $this->online && $this->start_date <= now() && $this->end_date >= now();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'reduction_users');
    }
}
