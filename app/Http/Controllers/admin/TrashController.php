<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\User;
use App\Models\Contact;
use App\Models\Faq;
use App\Models\Feedback;
use App\Models\Media;
use App\Models\Plan;
use App\Models\Pricing;
use App\Models\Reduction;
use App\Models\Workout;

// Controllers

class TrashController extends Controller
{
    public function users() {
        $users = User::onlyTrashed()->get();
        return view('admin.trash.users')->with(['users' => $users]);
    }

    public function restoreAllUsers() {
        // 
    }

    public function deleteAllUsers() {
        //
    }

    public function contacts() {
        $contacts = Contact::onlyTrashed()->get();
        return view('admin.trash.contacts')->with(['contacts' => $contacts]);
    }

    public function faqs() {
        $faqs = Faq::onlyTrashed()->get();
        return view('admin.trash.faqs')->with(['faqs' => $faqs]);
    }

    public function feedbacks() {
        $feedbacks = Feedback::onlyTrashed()->get();
        return view('admin.trash.feedbacks')->with(['feedbacks' => $feedbacks]);
    }

    public function medias() {
        $medias = Media::onlyTrashed()->get();
        return view('admin.trash.medias')->with(['medias' => $medias]);
    }

    public function plans() {
        $plans = Plan::onlyTrashed()->get();
        return view('admin.trash.plans')->with(['plans' => $plans]);
    }

    public function pricings() {
        $pricings = Pricing::onlyTrashed()->get();
        return view('admin.trash.pricings')->with(['pricings' => $pricings]);
    }

    public function reductions() {
        $reductions = Reduction::onlyTrashed()->get();
        return view('admin.trash.reductions')->with(['reductions' => $reductions]);
    }

    public function workouts() {
        $workouts = Workout::onlyTrashed()->get();
        return view('admin.trash.workouts')->with(['workouts' => $workouts]);
    }
}
