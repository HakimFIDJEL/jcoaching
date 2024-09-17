<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Chatbox extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'blocked_at',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function messages() {
        return $this->hasMany(ChatboxMessage::class);
    }

    public function lastMessage() {
        return $this->hasOne(ChatboxMessage::class)->latest();
    }

    public function unreadMessages() {
        return $this->hasMany(ChatboxMessage::class)->whereNull('read_at')->where('user_id', '!=', Auth::id());
    }

    public function block() {
        $this->blocked_at = now();
        $this->save();
    }

    public function unblock() {
        $this->blocked_at = null;
        $this->save();
    }

    public function isBlocked() {
        return $this->blocked_at !== null;
    }

    public function markAsRead() {
        $this->unreadMessages()->update(['read_at' => now()]);
    }
}
