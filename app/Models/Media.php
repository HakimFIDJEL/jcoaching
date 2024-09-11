<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'label',
        'path',
        'type',
        'size',
        'extension',
        'online',
    ];


    public function scopeOnline(Builder $query)
    {
        return $query->where('online', 1);
    }
}
