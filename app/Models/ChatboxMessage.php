<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatboxMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'chatbox_id',
        'user_id',
        'content',
        'read_at',
    ];

    public function chatbox() {
        return $this->belongsTo(Chatbox::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function files() {
        return $this->hasMany(ChatboxMessageFile::class);
    }

    public function read() {
        $this->read_at = now();
        $this->save();
    }

    public function unread() {
        $this->read_at = null;
        $this->save();
    }
}
