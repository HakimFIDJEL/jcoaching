<?php

namespace App\Http\Controllers\admin;

// Includes
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

// Requests
use App\Http\Requests\admin\admins\StoreRequest;
use App\Http\Requests\admin\admins\UpdateRequest;
use App\Http\Requests\admin\admins\UpdatePasswordRequest;
use App\Http\Requests\admin\admins\PfpRequest;

// Models
use App\Models\User;

// Mails
use App\Mail\admin\StoreAdmin;

// Jobs
use App\Jobs\SendEmailJob;


class AdminController extends Controller
{
    public function index() {
        $admins = User::admins()->get();
        return view('admin.admins.index')->with(['admins' => $admins]);
    }

    public function create() {
        return view('admin.admins.create');
    }

    public function edit() {
        return view('admin.admins.edit')->with(['admin' => Auth::user()]);
    }

    public function pfp() {
        return view('admin.admins.pfp')->with(['admin' => Auth::user()]);
    }

    public function security() {
        return view('admin.admins.security')->with(['admin' => Auth::user()]);
    }

    public function store(StoreRequest $request) {
        $data = $request->validated();

        // Create user
        $temporary_password = Str::random(10);
        $user = User::create([
            'role'               => 'admin',
            'firstname'          => $data['firstname'],
            'lastname'           => $data['lastname'],
            'email'              => $data['email'],
            'phone'              => $data['phone'],
            'address'            => $data['address'],
            'city'               => $data['city'],
            'postal_code'        => $data['postal_code'],
            'address_complement' => $data['address_complement'],
            'country'            => $data['country'],
            'phone'              => $data['phone'],
            'password'           => Hash::make($temporary_password),
            'password_expires_at'=> now(),
        ]);
        $user->save();

        if($data['email_verified']) {
            $user->email_verified_at = now();
            $user->save();
        }


        // Send email
        $mail = new StoreAdmin($user, $temporary_password);
        SendEmailJob::dispatch($mail);

        return redirect()->route('admin.admins.index')->with(['success' => 'Administrateur créé avec succès']);
    }

    public function update(UpdateRequest $request) {
        $data = $request->validated();
        $user = Auth::user();

        $user->update($data);

        $user->save();

        return redirect()->route('admin.admins.index')->with('success', 'Administrateur modifié avec succès');
    }



    public function updatePassword(updatePasswordRequest $request) {
        $data = $request->validated();

        $user = Auth::user();

        // Mot de passe incorrect
        if(!Hash::check($data['current_password'], $user->password))
        {
            return redirect()->back()->with(['error' => 'Le mot de passe actuel est incorrect']);
        }

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

        return redirect()->route('admin.admins.index')->with(['success' => 'Mot de passe modifié avec succès']);
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

        return redirect()->back()->withInput()->with(['success' => 'Photo de profil modifiée avec succès']);
    }

  
    public function downloadPfp() {
        $user = Auth::user();
        $path = $user->pfp_path;
        return Storage::download($path);
    }

    public function softDelete(User $user) {
        if($user->id !== Auth::id())
        {
            $user->delete();
            return redirect()->route('admin.admins.index')->with(['success' => 'Administrateur mis à la corbeille avec succès']);
        }
        return redirect()->route('admin.admins.index')->with(['error' => 'Vous ne pouvez pas supprimer votre propre compte']);
    }

    public function restore(int $id) {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->back()->with(['success' => 'Administrateur restauré avec succès']);
    }

    public function delete(int $id) {

        $user = User::withTrashed()->findOrFail($id);

        if($user->id !== Auth::id())
        {
            // Supprime la photo de profil
            if ($user->pfp_path) {
                Storage::delete($user->pfp_path);
            }

            $user->forceDelete();
            return redirect()->back()->with(['success' => 'Administrateur supprimé avec succès']);
        }
        return redirect()->back()->with(['error' => 'Vous ne pouvez pas supprimer votre propre compte']);
    }
}
