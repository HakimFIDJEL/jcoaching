<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Feedback extends Model
{
    use HasFactory;
    

    protected $fillable = ['name', 'job', 'message', 'online'];

    public function scopeOnline(Builder $query)
    {
        return $query->where('online', 1);
    }

    public function softDelete()
    {
        $this->deleted_at = now();
        $this->save();
    }

    public function restore()
    {
        $this->deleted_at = null;
        $this->save();
    }
}
