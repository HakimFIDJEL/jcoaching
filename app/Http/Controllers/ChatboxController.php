<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

// Models
use App\Models\User;
use App\Models\Chatbox;
use App\Models\ChatboxMessage;
use App\Models\ChatboxMessageFile;

// Requests
use App\Http\Requests\chatbox\MessageRequest;

class ChatboxController extends Controller
{
    // Index
    public function index() {
        if(!Auth::user()->isAdmin()) {
            // Membre
        } else {
            // Admin
        }
    }

    // Mark as read
    public function markAsRead() {
        if(!Auth::user()->isAdmin()) {
            return redirect()->back()->with(['error' => 'Vous n\'avez pas les droits pour effectuer cette action.']);
        } else {
            $chatboxs = Chatbox::all();
            foreach($chatboxs as $chatbox) {
                $chatbox->markAsRead();
            }
            return redirect()->back()->with(['success' => 'Tous les messages ont bien été marqués comme lus.']);
        }
    }

    // Show - Done
    public function show(User $user) {
        if(!Auth::user()->isAdmin()) {
            $chatbox = Auth::user()->chatbox()->with([
                'messages.file',
                'messages.user:id,lastname,firstname,pfp_path',
                'user:id,lastname,firstname,pfp_path', 
            ])->first();

            $chatbox->markAsRead();

            return response()->json([
                'status' => 'success',
                'chatbox' => $chatbox,
            ]);

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
                    
                $chatbox->markAsRead();

                return response()->json([
                    'status' => 'success',
                    'chatbox' => $chatbox,
                ]);
            }
        }
    }

    // Block - DONE
    public function block(User $user) {
        if(!Auth::user()->isAdmin()) {
            return redirect()->back()->with(['error' => 'Vous n\'avez pas les droits pour effectuer cette action.']);
        } else {
            $chatbox = $user->chatbox()->first();
            $chatbox->update([
                'blocked_at' => now(),
            ]);
            return redirect()->back()->with(['success' => 'L\'utilisateur a bien été bloqué.']);
        }
    }

    // Unblock - DONE
    public function unblock(User $user) {
        if(!Auth::user()->isAdmin()) {
            return redirect()->back()->with(['error' => 'Vous n\'avez pas les droits pour effectuer cette action.']);
        } else {
            $chatbox = $user->chatbox()->first();
            $chatbox->update([
                'blocked_at' => null,
            ]);
            return redirect()->back()->with(['success' => 'L\'utilisateur a bien été débloqué.']);
        }
    }

    // Send - DONE
    public function send(User $user, MessageRequest $request) {
        $chatbox = $user->chatbox()->first();

        if(!$chatbox) {
            $chatbox = $user->chatbox()->create();
        }

        if($chatbox->isBlocked()) {
            return response()->json([
                'status' => 'error',
            ]);
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

    // Delete - DONE
    public function deleteMessages(User $user) {
        if(!Auth::user()->isAdmin()) {
            return redirect()->back()->with(['error' => 'Vous n\'avez pas les droits pour effectuer cette action.']);
        } else {
            $chatbox = $user->chatbox()->first();

            // Supprime tous les fichiers de messages
            $messages = $chatbox->messages()->get();
            foreach($messages as $message) {
                if($message->file) {
                    $path = $message->file->path;
                    Storage::delete($path);
                    $message->file->delete();
                }
            }

            // Supprime tous les messages
            $chatbox->messages()->delete();

            return redirect()->back()->with(['success' => 'Les messages ont bien été supprimés.']);
        }
    }
}
