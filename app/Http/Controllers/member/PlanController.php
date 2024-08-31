<?php

namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Plan;
use App\Models\User;
use App\Models\Pricing;
use App\Models\Workout;

class PlanController extends Controller
{
    public function index() {
        $user = Auth::user();
        $plans = $user->plans;

        return view('member.plans.index')->with(['plans' => $plans]);
    }
}
