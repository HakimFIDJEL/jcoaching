<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Models\Chatbox;
use App\Models\ChatboxMessage;
use App\Models\ChatboxMessageFile;

// Requests
use App\Http\Requests\MessageRequest;

class ChatboxController extends Controller
{
    public function index() {
        if(!Auth::user()->isAdmin()) {
            // Membre
        } else {
            // Admin
        }
    }

    public function show(Chatbox $chatbox) {
        if(!Auth::user()->isAdmin()) {
            // Membre
        } else {
            // Admin
        }
    }

    public function block(Chatbox $chatbox) {
        if(!Auth::user()->isAdmin()) {
            return redirect()->back()->with(['error' => 'Vous n\'avez pas les droits pour effectuer cette action.']);
        } else {
            // 
        }
    }

    public function unblock(Chatbox $chatbox) {
        if(!Auth::user()->isAdmin()) {
            return redirect()->back()->with(['error' => 'Vous n\'avez pas les droits pour effectuer cette action.']);
        } else {
            // 
        }
    }

    public function send(Chatbox $chatbox, MessageRequest $request) {
        // 
    }

    public function deleteMessages(Chatbox $chatbox) {
        if(!Auth::user()->isAdmin()) {
            return redirect()->back()->with(['error' => 'Vous n\'avez pas les droits pour effectuer cette action.']);
        } else {
            // 
        }
    }
}
