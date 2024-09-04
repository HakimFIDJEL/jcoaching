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
    // INDEX
    public function index(User $user = null)
    {
        $members = User::members()->get();
        $rest_periods = RestPeriod::all();
        if($user) {
            $workouts = Workout::with('user:id,lastname,firstname')->where('user_id', $user->id)->get();
        } else {
            $workouts = Workout::with('user:id,lastname,firstname')->get();
        }
        return view('admin.calendar.index')->with(['members' => $members, 'user' => $user, 'workouts' => $workouts, 'rest_periods' => $rest_periods]);
    }

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


    // ADD REST PERIOD
    public function addRestPeriod(AddRestPeriodRequest $request) {
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);

        // End date est bien supérieure à la date de début
        if($end_date->lte($start_date)) {
            return redirect()->back()->with(['error' => 'La date de fin doit être supérieure à la date de début']);
        }

        // Vérifier les conflits avec les autres périodes de repos
        $overlappingRestPeriods = RestPeriod::where(function($query) use ($start_date, $end_date) {
            $query->whereBetween('start_date', [$start_date, $end_date])
                ->orWhereBetween('end_date', [$start_date, $end_date])
                ->orWhere(function($query) use ($start_date, $end_date) {
                    $query->where('start_date', '<', $start_date)
                          ->where('end_date', '>', $start_date);
                })
                ->orWhere(function($query) use ($start_date, $end_date) {
                    $query->where('start_date', '<', $end_date)
                          ->where('end_date', '>', $end_date);
                });
        })->exists();
        
        if($overlappingRestPeriods) {
            return redirect()->back()->with(['error' => 'Impossible d\'ajouter la période de repos, une autre période de repos est déjà prévue à cette date']);
        }

        // Vérifier les conflits avec les séances
        $overlappingWorkouts = Workout::where(function($query) use ($start_date, $end_date) {
            $query->whereBetween('date', [$start_date, $end_date])
                ->orWhere(function($query) use ($start_date, $end_date) {
                    $query->where('date', '<', $start_date)
                          ->where('date', '>', $start_date->copy()->subHour());
                });
        })->exists();

        if($overlappingWorkouts) {
            return redirect()->back()->with(['error' => 'Impossible d\'ajouter la période de repos, une séance est déjà prévue à cette date']);
        }

        RestPeriod::create([
            'start_date' => $start_date,
            'end_date'   => $end_date,
        ]);

        return redirect()->back()->with(['success' => 'Période de repos ajoutée avec succès']);
    }

    // UPDATE REST PERIOD - Ajax
    public function updateRestPeriod(UpdateRestPeriodRequest $request) {
        $rest_period = RestPeriod::findOrFail($request->rest_period);

        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);

        // Vérifier les conflits avec les autres périodes de repos
        $overlappingRestPeriods = RestPeriod::where('id', '!=', $rest_period->id)
            ->where(function($query) use ($start_date, $end_date) {
                $query->whereBetween('start_date', [$start_date, $end_date])
                    ->orWhereBetween('end_date', [$start_date, $end_date])
                    ->orWhere(function($query) use ($start_date, $end_date) {
                        $query->where('start_date', '<', $start_date)
                            ->where('end_date', '>', $start_date);
                    })
                    ->orWhere(function($query) use ($start_date, $end_date) {
                        $query->where('start_date', '<', $end_date)
                            ->where('end_date', '>', $end_date);
                    });
            })->exists();

        if($overlappingRestPeriods) {
            return response()->json(['status' => 'error', 'message' => 'Impossible de mettre à jour la période de repos, une autre période de repos est déjà prévue à cette date']);
        }

        // Vérifier les conflits avec les séances (workouts)
        $overlappingWorkouts = Workout::where(function($query) use ($start_date, $end_date) {
            $query->whereBetween('date', [$start_date, $end_date])
                ->orWhere(function($query) use ($start_date) {
                    $query->where('date', '<', $start_date)
                        ->where('date', '>', $start_date->copy()->subHour());
                });
        })->exists();

        if($overlappingWorkouts) {
            return response()->json(['status' => 'error', 'message' => 'Impossible de mettre à jour la période de repos, une séance est déjà prévue à cette date']);
        }

        // Update the rest period
        $rest_period->update([
            'start_date' => $start_date,
            'end_date'   => $end_date,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Période de repos mise à jour avec succès']);
    }

    // DELETE REST PERIOD - Ajax
    public function deleteRestPeriod(UpdateRestPeriodRequest $request) {
        $rest_period = RestPeriod::findOrFail($request->rest_period);

        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);

        $rest_period->delete();

        return response()->json(['status' => 'success', 'message' => 'Période de repos supprimée avec succès']);
    }


    
    // ADD WORKOUT
    public function addWorkout(AddWorkoutRequest $request) {
        $data = $request->validated();

        $user = User::where('id', $data['user'])->first();
        // Vérifier si l'utilisateur est un admin
        if($user->isAdmin()) {
            return redirect()->back()->with(['error' => 'Impossible d\'ajouter des séances à un administrateur']);
        }

        // Ajouter les séances
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

    // UPDATE WORKOUT - Ajax
    public function updateWorkout(UpdateWorkoutRequest $request) {
        $workout = Workout::findOrFail($request->workoutId);

        // L'utilisateur de la séance n'est pas le même que celui fournit en paramètre
        if($workout->user->id != $request->userId) {
            return response()->json(['status' => 'error', 'message' => 'Impossible de mettre à jour la séance']);
        }

        // Si l'utilisateur n'est pas admin
        if(!Auth::user()->isAdmin()) {
            // Il ne peut modifier que ses propres séances
            if($workout->user != Auth::user()) {
                return response()->json(
                    ['status' =>  'error', 
                    'message' => 'Impossible de mettre à jour la séance d\'un autre membre que vous']
                );
            }
        }

        // Une séance ne peut être placée sur une autre séance ou période de repos
        if($request->date) {
            $newStart = Carbon::parse($request->date);
            $newEnd = $newStart->copy()->addHour();
    
            // Vérifier les conflits avec les autres séances de cet utilisateur
            $overlappingWorkouts = Workout::where('id', '!=', $workout->id)
                ->where(function($query) use ($newStart, $newEnd) {
                    $query->whereBetween('date', [$newStart, $newEnd->subSecond()])
                        ->orWhere(function($query) use ($newStart, $newEnd) {
                            $query->where('date', '<', $newStart)
                                  ->where('date', '>', $newStart->copy()->subHour());
                        });
                })
                ->exists();
    
            if ($overlappingWorkouts) {
                return response()->json(['status' => 'error', 'message' => 'Impossible de mettre à jour la séance, une autre séance est déjà prévue à cette date']);
            }

            // Vérifier les conflits avec les périodes de repos
            $overlappingRestPeriods = RestPeriod::where(function($query) use ($newStart, $newEnd) {
                $query->whereBetween('start_date', [$newStart, $newEnd->subSecond()])
                    ->orWhereBetween('end_date', [$newStart, $newEnd->subSecond()])
                    ->orWhere(function($query) use ($newStart, $newEnd) {
                        $query->where('start_date', '<', $newStart)
                              ->where('end_date', '>', $newStart);
                    })
                    ->orWhere(function($query) use ($newStart, $newEnd) {
                        $query->where('start_date', '<', $newEnd)
                              ->where('end_date', '>', $newEnd);
                    });
            })->exists();

            if ($overlappingRestPeriods) {
                return response()->json(['status' => 'error', 'message' => 'Impossible de mettre à jour la séance, une période de repos est déjà prévue à cette date']);
            }
        }



        // Mise à jour de la séance
        if($request->date) {
            $workout->update(['date' => Carbon::parse($request->date)]);
        } else {
            $workout->update(['date' => null]);
        }



        return response()->json(
            [
                'status' => 'success', 
                'message' => 'Séance mise à jour avec succès',
                'workout' => $workout
            ]
        );
    }

    // DONE WORKOUT
    public function doneWorkout(User $user, Workout $workout) {
        if($workout->user_id != $user->id) {
            return redirect()->back()->with(['error' => 'Impossible de marquer la séance comme faite']);
        }
        $workout->update(['status' => true]);
        return redirect()->back()->with(['success' => 'Séance marquée comme faite']);
    }

    // UNDONE WORKOUT
    public function undoneWorkout(User $user, Workout $workout) {
        if($workout->user_id != $user->id) {
            return redirect()->back()->with(['error' => 'Impossible de marquer la séance comme non faite']);
        }
        $workout->update(['status' => false]);
        return redirect()->back()->with(['success' => 'Séance marquée comme non faite']);
    }

    // DELETE WORKOUT
    public function deleteWorkout(User $user, Workout $workout) {
        if($workout->user_id != $user->id) {
            return redirect()->back()->with(['error' => 'Impossible de supprimer la séance']);
        }
        $workout->forceDelete();
        return redirect()->back()->with(['success' => 'Séance supprimée avec succès']);
    }

    // SOFT DELETE WORKOUT
    public function softDeleteWorkout(User $user, Workout $workout) {
        if($workout->user_id != $user->id) {
            return redirect()->back()->with(['error' => 'Impossible de mettre à la corbeille la séance']);
        }
        $workout->delete();
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
