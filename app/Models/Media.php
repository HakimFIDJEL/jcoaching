<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'path',
        'type',
        'size',
        'extension',
        'online'
    ];

    public function softDelete() {
        $this->deleted_at = now();
        $this->save();
    }

    public function restore() {
        $this->deleted_at = null;
        $this->save();
    }

}
