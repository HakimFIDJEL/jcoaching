<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Mail\auth\RegisterMail;

// Models
use App\Models\Pricing;
use App\Models\Media;
use App\Models\Feedback;
use App\Models\Faq;
use App\Models\Setting;
use App\Models\Contact;
use App\Models\User;

// Requests
use App\Http\Requests\ContactRequest;

// Jobs
use App\Jobs\SendEmailJob;

// Mail
use App\Mail\ContactMail;

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
    public function galerie()
    {
         
        $medias = Media::all();

        return view('jerhome.galerie')->with([
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
        $faqs = Faq::all();
        return view('jerhome.contact')->with([
            'faqs' => $faqs,
        ]);
    }

    public function contactPost(ContactRequest $request) {
        $data = $request->validated();

        // Create Contact
        $contact = Contact::create($data);

        // Send Email
        $admins = User::admins()->get();

        foreach($admins as $admin) {
            SendEmailJob::dispatch(new ContactMail($contact, $admin->email));
        }

        return redirect()->route('main.contact')->with(['success' => 'Votre message a bien été envoyé']);
    }


    // Account - Done
    public function account()
    {
        $user = Auth::user();

        if(!$user) {
            return redirect()->route('main.index');
        }


        if($user->role == 'admin') {
            return redirect()->route('admin.index');
        } else if ($user->role == 'member') {
            return redirect()->route('member.index');
        } else {
            return redirect()->route('main.index')->with(['error' => 'Vous n\'avez pas de rôle']);
        }
    }


    // Mentions Légales - DONE
    public function mentions()
    {
        return view('jerhome.legal.mentions');
    }

    // Politique de confidentialité - DONE
    public function privacy()
    {
        return view('jerhome.legal.privacy');
    }

    // Conditions Générales de Vente - DONE
    public function sales()
    {
        return view('jerhome.legal.sales');
    }

    // Conditions Générales d'Utilisation - DONE
    public function terms()
    {
        return view('jerhome.legal.terms');
    }

    // Cookies - DONE
    public function cookies()
    {
        return view('jerhome.legal.cookies');
    }


}
