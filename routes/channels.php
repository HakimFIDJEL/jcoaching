<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Chatbox;
use App\Models\ChatboxMessage;

use App\Http\Middleware\AuthMiddleware;


// Admin
Broadcast::channel('chatbox', function ($user) {
    Log::info('2 - Broadcast channel, isAdmin: ' . $user->isAdmin()); 
    return $user->isAdmin();
});

// Member
Broadcast::channel('chatbox.{id}', function ($user, $id) {
    Log::info('2 - Broadcast channel, isAdmin: ' . $user->isAdmin() . ', isOwnerOfChatbox' . $user->id == $id); 
    return $user->id == $id;
});
 