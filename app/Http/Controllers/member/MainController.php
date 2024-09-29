<?php

namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Setting;
use App\Models\Workout;

class MainController extends Controller
{
    public function index()
    {
        $workouts = Auth::user()->workouts()->get();
        $workouts->load('user');

        $nutrition_idea = "";

        if(Auth::user()->hasCurrentPlan())
        {
            if(Auth::user()->currentPlan->nutrition_option)
            {
                $nutrition_idea = Setting::first()->nutrition_idea;
            }
        }

        return view('member.index')->with([
            'workouts' => $workouts,
            'nutrition_idea' => $nutrition_idea
        ]);
    }

    public function nutrition() {
        if(Auth::user()->hasCurrentPlan()) {
            if(Auth::user()->currentPlan->nutrition_option) {
                return view('member.nutrition.index')->with(['nutrition_idea' => Setting::first()->nutrition_idea]);
            }     
        }
        return redirect()->route('main.account')->with(['error' => 'Vous n\'avez pas accès à cette fonctionnalité.']);
    }

}
