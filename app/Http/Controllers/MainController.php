<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Mail\auth\RegisterMail;

use App\Models\Pricing;
use App\Models\Media;
use App\Models\Feedback;
use App\Models\Faq;
use App\Models\Setting;


class MainController extends Controller
{
    // Index - Done
    public function index()
    {
        $pricings = Pricing::all();
        $medias = Media::limit(6)->get();
        $feedbacks = Feedback::all();

        return view('jerhome.index')->with([
            'pricings' => $pricings,
            'medias' => $medias,
            'feedbacks' => $feedbacks,
        ]);
    }

    // About - Done
    public function about()
    {
        return view('jerhome.about');
    }

    // Media - Done
    public function media()
    {
        $medias = Media::all();

        return view('jerhome.media')->with([
            'medias' => $medias,
        ]);
    }

    // Pricings - Done
    public function pricings()
    {
        $pricings = Pricing::all();
        $nutrition_price = Setting::first()->nutrition_price;
        $workout_price = Setting::first()->workout_price;

        return view('jerhome.pricings')->with([
            'pricings' => $pricings,
            'nutrition_price' => $nutrition_price,
            'workout_price' => $workout_price,
        ]);
    }

    // Contact - Done
    public function contact()
    {
        return view('jerhome.contact');
    }


    // Account - Done
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
