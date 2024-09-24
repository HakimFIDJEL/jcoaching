<?php

namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use ZipArchive;


// Models
use App\Models\User;
use App\Models\UserDocument;

// Requests
use App\Http\Requests\member\account\UpdateRequest;
use App\Http\Requests\member\account\updatePasswordRequest;
use App\Http\Requests\member\account\PfpRequest;

class AccountController extends Controller
{
    public function index() {
        return view('member.account.index')->with(['member' => Auth::user()]);
    }

    public function pfp() {
        return view('member.account.pfp')->with(['member' => Auth::user()]);
    }

    public function security() {
        return view('member.account.security')->with(['member' => Auth::user()]);
    }

    public function documents() {
        return view('member.account.documents')->with(['member' => Auth::user()]);
    }

    public function update(UpdateRequest $request) {
        $data = $request->validated();
        $user = Auth::user();

        $user->update($data);

        $user->save();

        return redirect()->back()->with('success', 'Vos informations ont été modifié avec succès');
    }

    public function updatePassword(updatePasswordRequest $request) {
        $data = $request->validated();

        $user = Auth::user();

        // Même mot de passe que l'ancien
        if(Hash::check($data['password'], $user->password))
        {
            return redirect()->back()->with(['error' => 'Le nouveau mot de passe doit être différent de l\'ancien']);
        }

        $user->update([
            'password' => Hash::make($data['password']),
            'password_expires_at' => now()->addYear(),
        ]);

        $user->save();

        return redirect()->back()->with(['success' => 'Votre mot de passe a été modifié avec succès']);
    }

    public function updatePfp(PfpRequest $request) {
        $data = $request->validated();
        $user = Auth::user();

        // Supprime l'ancienne photo de profil
        if ($user->pfp_path) {
            Storage::delete($user->pfp_path);
            $user->update(['pfp_path' => null]);
        }

        // Enregistre la nouvelle photo de profil
        if(isset($data['pfp']))
        {
            $path = $data['pfp']->store('public/users/pfps');
            $user->update(['pfp_path' => $path]);
        }

        return redirect()->back()->withInput()->with(['success' => 'Votre photo de profil a été modifiée avec succès']);
    }

  
    public function downloadPfp() {
        $user = Auth::user();
        $path = $user->pfp_path;
        return Storage::download($path);
    }

    // DOWNLOAD DOCUMENTS - DONE
    public function downloadDocuments() {

        $zip = new ZipArchive;
        $user = Auth::user();
        $zipFileName = $user->firstname.'_'.$user->lastname.'_documents.zip';
       

        if ($zip->open(public_path($zipFileName), ZipArchive::CREATE) === TRUE) {
            
            foreach ($user->documents as $document) {
                $zip->addFile(storage_path('app/'.$document->path), $document->filename);
            }
            $zip->close();

            return response()->download(public_path($zipFileName))->deleteFileAfterSend(true);
        } else {
            return "Failed to create the zip file.";
        };

    }
}
