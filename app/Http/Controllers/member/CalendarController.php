<?php

namespace App\Http\Controllers\member;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

// Models
use App\Models\Workout;
use App\Models\RestPeriod;
use App\Models\User;

// Requests
use App\Http\Requests\member\calendar\UpdateWorkoutRequest;

class CalendarController extends Controller
{
    // INDEX
    public function index()
    {
        $rest_periods = RestPeriod::all();
        $user = Auth::user();
        $workouts = Workout::with('user:id,lastname,firstname')->get();

        return view('member.calendar.index')->with(['workouts' => $workouts, 'rest_periods' => $rest_periods]);
    }

    
    // Store WORKOUT
    public function addWorkout() {
        $user = Auth::user();

        // Si l'utilisateur n'a pas utilisé sa séance gratuite
        if($user->first_session) {
            Workout::create([
                'user_id' => $user->id,
                'plan_id' => null,
                'date'    => null,
                'status'  => false,
            ]);

            $user->update(['first_session' => false]);

            return redirect()->back()->with(['success' => 'Séance ajoutée avec succès']);
        } else {
            // On vérifie si l'utilisateur a un abonnement en cours
            if($user->hasCurrentPlan()) {
                // On vérifie qu'il reste des séances dans son abonnements
                if($user->currentPlan->sessions_left > 0) {
                    Workout::create([
                        'user_id' => $user->id,
                        'plan_id' => $user->currentPlan->id,
                        'date'    => null,
                        'status'  => false,
                    ]);

                    $user->currentPlan->decrement('sessions_left');

                    return redirect()->back()->with(['success' => 'Séance ajoutée avec succès']);
                } else {
                    return redirect()->back()->with(['error' => 'Impossible d\'ajouter une séance, vous n\'avez plus de séances dans votre abonnement']);
                }
            } else {
                return redirect()->back()->with(['error' => 'Impossible d\'ajouter une séance, vous n\'avez pas d\'abonnement en cours']);
            }
        }
        return redirect()->back()->with(['error' => 'Impossible d\'ajouter une séance']);
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

        // Si la séance est "finie"
        if($workout->status) {
            return response()->json(
                ['status' => 'error', 
                'message' => 'Impossible de mettre à jour une séance déjà effectuée']
            );
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


}
