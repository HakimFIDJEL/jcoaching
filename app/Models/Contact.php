<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'lastname',
        'firstname',
        'email',
        'subject',
        'message',
        'read_at',
        'deleted_at'
    ];

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
