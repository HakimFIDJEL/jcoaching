<?php

namespace App\Http\Controllers\admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\Workout;
use App\Models\User;

// Requests
use App\Http\Requests\admin\calendar\UserRequest;
use App\Http\Requests\admin\members\WorkoutRequest;

class CalendarController extends Controller
{
    public function index(User $user = null)
    {
        $members = User::members()->get();
        return view('admin.calendar.index')->with(['members' => $members, 'user' => $user]);
    }

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

    
    // ADD WORKOUT
    public function addWorkout(WorkoutRequest $request, User $user) {
        $data = $request->validated();

        for($i = 0; $i < $data['nbr_sessions']; $i++) {
            Workout::create([
                'user_id' => $user->id,
                'plan_id' => null,
                'date'    => null,
                'status'  => false,
            ]);
        }

        return redirect()->back()->with(['success' => 'Séances ajoutées avec succès']);
    }

    // DELETE WORKOUT
    public function deleteWorkout(User $user, Workout $workout) {
        if($workout->user_id != $user->id) {
            return redirect()->back()->with(['error' => 'Impossible de supprimer la séance']);
        }
        $workout->delete();
        return redirect()->back()->with(['success' => 'Séance supprimée avec succès']);
    }

    // REFUSE DATE WORKOUT
    public function refuseDateWorkout(User $user, Workout $workout) {
        if($workout->user_id != $user->id) {
            return redirect()->back()->with(['error' => 'Impossible de refuser la date de la séance']);
        }
        $workout->update(['date' => null]);

        // Send Mail

        return redirect()->back()->with(['success' => 'Date refusée avec succès']);
    }

    // SOFT DELETE WORKOUT
    public function softDeleteWorkout(User $user, Workout $workout) {
        if($workout->user_id != $user->id) {
            return redirect()->back()->with(['error' => 'Impossible de mettre à la corbeille la séance']);
        }
        $workout->softDelete();
        return redirect()->back()->with(['success' => 'Séance mise à la corbeille avec succès']);
    }

    // RESTORE WORKOUT
    public function restoreWorkout(User $user, Workout $workout) {
        if($workout->user_id != $user->id) {
            return redirect()->back()->with(['error' => 'Impossible de restaurer la séance']);
        }
        $workout->restore();
        return redirect()->back()->with(['success' => 'Séance restaurée avec succès']);
    }
}
