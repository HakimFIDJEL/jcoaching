<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

// Models
use App\Models\User;
use App\Models\Chatbox;
use App\Models\ChatboxMessage;
use App\Models\ChatboxMessageFile;

// Requests
use App\Http\Requests\chatbox\MessageRequest;

class ChatboxController extends Controller
{
    public function index() {
        if(!Auth::user()->isAdmin()) {
            // Membre
        } else {
            // Admin
        }
    }

    public function show(User $user) {
        if(!Auth::user()->isAdmin()) {
            // Membre
        } else {
            if($user->isAdmin()) {
                return response()->json([
                    'status'=>'error',
                ]);
            } else {
                if(!$user->hasChatbox()) {
                    $user->chatbox()->create();
                } 

                $chatbox = $user->chatbox()->with([
                    'messages.file',
                    'messages.user:id,lastname,firstname,pfp_path',
                    'user:id,lastname,firstname,pfp_path', 
                ])->first();
                
                return response()->json([
                    'status' => 'success',
                    'chatbox' => $chatbox,
                ]);
            }
        }
    }

    public function block(User $user) {
        if(!Auth::user()->isAdmin()) {
            return redirect()->back()->with(['error' => 'Vous n\'avez pas les droits pour effectuer cette action.']);
        } else {
            // 
        }
    }

    public function unblock(User $user) {
        if(!Auth::user()->isAdmin()) {
            return redirect()->back()->with(['error' => 'Vous n\'avez pas les droits pour effectuer cette action.']);
        } else {
            // 
        }
    }

    public function send(User $user, MessageRequest $request) {
        $chatbox = $user->chatbox()->first();

        if(!$chatbox) {
            $chatbox = $user->chatbox()->create();
        }

        if($request->hasFile('file')) {

            $file = $request->file('file');

            $filename = $file->getClientOriginalName();
            $randomName = Str::random(10) . '.' . $file->extension();
            $path = $file->storeAs('public/chatbox', $randomName);
            $size = $file->getSize();
            $extension = $file->extension();
            $type = $file->getMimeType();

            $message = $chatbox->messages()->create([
                'user_id' => Auth::id(),
                'content' => $request->content,
            ]);

            $message->file()->create([
                'filename' => $filename,
                'path' => $path,
                'size' => $size,
                'extension' => $extension,
                'type' => $type,
            ]);

            $message->load('user:id,lastname,firstname,pfp_path', 'file');

            return response()->json([
                'status' => 'success',
                'message' => $message,
            ]);
        } else {

            $message = $chatbox->messages()->create([
                'user_id' => Auth::id(),
                'content' => $request->content,
            ]);
    
            $message->load('user:id,lastname,firstname,pfp_path');
    
            return response()->json([
                'status' => 'success',
                'message' => $message,
            ]);
        }


    }

    public function deleteMessages(User $user) {
        if(!Auth::user()->isAdmin()) {
            return redirect()->back()->with(['error' => 'Vous n\'avez pas les droits pour effectuer cette action.']);
        } else {
            // 
        }
    }
}
