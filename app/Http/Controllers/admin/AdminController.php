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

        if($data['email_verified'])
        {
            $user->email_verified_at = now();
            $user->save();
        }


        // Send email
        Mail::send(new StoreAdmin($user, $temporary_password));

        return redirect()->route('admin.admins.index')->with(['success' => 'Administrateur créé avec succès']);
    }

    public function update()
    {
        // 
    }

    public function soft_delete()
    {
        // 
    }

    public function delete()
    {
        // 
    }
}
