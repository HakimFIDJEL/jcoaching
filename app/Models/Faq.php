<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

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

    public function softDelete() {
        $this->deleted_at = now();
        $this->save();
    }

    public function restore() {
        $this->deleted_at = null;
        $this->save();
    }
}
