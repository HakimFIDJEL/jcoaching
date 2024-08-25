<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Mail\auth\RegisterMail;



class MainController extends Controller
{
    public function index()
    {
        return view('jerhome.index');
    }

    public function account()
    {
        $user = Auth::user();

        if(!$user) {
            return redirect()->route('auth.login')->with(['error' => 'Vous n\'êtes pas connecté']);
        }

        if($user->role == 'admin') {
            return redirect()->route('admin.index');
        } else if ($user->role == 'member') {
            return redirect()->route('member.index');
        } else {
            return redirect()->route('main.index')->with(['error' => 'Vous n\'avez pas de rôle']);
        }
    }
}
