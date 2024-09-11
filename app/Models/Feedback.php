<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use HasFactory;
    use SoftDeletes;
    

    protected $fillable = [
        'name', 
        'job', 
        'message', 
        'online',
    ];

    public function scopeOnline(Builder $query)
    {
        return $query->where('online', 1);
    }

}
