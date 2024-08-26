<?php

namespace App\Http\Controllers\admin;

// Includes
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

// Requests
use App\Http\Requests\admin\admins\StoreRequest;
use App\Http\Requests\admin\admins\UpdateRequest;
use App\Http\Requests\admin\admins\UpdatePasswordRequest;

// Models
use App\Models\User;

// Mails
use App\Mail\admin\StoreAdmin;


class AdminController extends Controller
{
    public function index()
    {
        $admins = User::admins()->get();
        return view('admin.admins.index')->with(['admins' => $admins]);
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function edit()
    {
        return view('admin.admins.edit')->with(['admin' => Auth::user()]);
    }

    public function store(StoreRequest $request)
    {
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
        Mail::send(new StoreAdmin($user, $temporary_password));

        return redirect()->route('admin.admins.index')->with(['success' => 'Administrateur créé avec succès']);
    }

    public function update(UpdateRequest $request)
    {
        $data = $request->validated();

        $user = Auth::user();
        $email = $data['email'];

        if ($email != $user->email) {
            $email_exists = User::where('email', $email)->where('id', '!=', $user->id)->exists();

            if ($email_exists) {
                return redirect()->route('admin.admins.edit')->with(['error' => 'Cet email est déjà utilisé']);
            }
        }

        // Utilisation de la méthode `update()` sur l'instance de l'utilisateur
        $user->update([
            'firstname'          => $data['firstname'],
            'lastname'           => $data['lastname'],
            'email'              => $data['email'],
            'phone'              => $data['phone'],
            'address'            => $data['address'],
            'city'               => $data['city'],
            'postal_code'        => $data['postal_code'],
            'address_complement' => $data['address_complement'],
            'country'            => $data['country'],
        ]);

        return redirect()->route('admin.admins.index')->with(['success' => 'Administrateur modifié avec succès']);
    }


    public function updatePassword(updatePasswordRequest $request)
    {
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

    

    public function softDelete(User $user)
    {
        if($user != Auth::user())
        {
            $user->softDelete();
            return redirect()->route('admin.admins.index')->with(['success' => 'Administrateur mis à la corbeille avec succès']);
        }
        return redirect()->route('admin.admins.index')->with(['error' => 'Vous ne pouvez pas supprimer votre propre compte']);
    }

    public function delete()
    {
        if($user != Auth::user())
        {
            $user->delete();
            return redirect()->route('admin.admins.index')->with(['success' => 'Administrateur supprimé avec succès']);
        }
        return redirect()->route('admin.admins.index')->with(['error' => 'Vous ne pouvez pas supprimer votre propre compte']);
    }
}
