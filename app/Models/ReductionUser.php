<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReductionUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'reduction_id',
        'user_id',
    ];

    public function reduction() {
        return $this->belongsTo(Reduction::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
