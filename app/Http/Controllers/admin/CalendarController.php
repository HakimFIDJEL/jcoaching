<?php

namespace App\Http\Controllers\admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

// Models
use App\Models\Workout;
use App\Models\RestPeriod;
use App\Models\User;

// Requests
use App\Http\Requests\admin\calendar\UserRequest;
use App\Http\Requests\admin\calendar\AddWorkoutRequest;
use App\Http\Requests\admin\calendar\UpdateWorkoutRequest;
use App\Http\Requests\admin\calendar\AddRestPeriodRequest;
use App\Http\Requests\admin\calendar\UpdateRestPeriodRequest;

class CalendarController extends Controller
{
    

    

    // SEARCH
    public function search(UserRequest $request)
    {
        if (empty($request->user)) {
            return redirect()->route('admin.calendar.index');
        }

        $user = User::where('id', $request->user)->first();

        if ($user->isAdmin()) {
            return redirect()->route('admin.index')->with(['error' => 'L\'utilisateur est un administrateur']);
        }

        return redirect()->route('admin.calendar.index', ['user' => $user]);
    }



   
}
