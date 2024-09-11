<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'faqs';

    protected $fillable = [
        'question',
        'answer',
        'online',
    ];

    protected $casts = [
        'online' => 'boolean',
    ];

    public function scopeOnline($query)
    {
        return $query->where('online', true);
    }

   
}
