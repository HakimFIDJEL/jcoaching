<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatboxMessageFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'chatbox_message_id',
        'filename',
        'path',
        'type',
        'size',
        'extension',
    ];

    public function message() {
        return $this->belongsTo(ChatboxMessage::class);
    }

    public function getUrl() {
        return Storage::url($this->path) ?? null;
    }
}
