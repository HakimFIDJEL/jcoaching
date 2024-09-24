<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

// Models
use App\Models\Workout;
use App\Models\RestPeriod;
use App\Models\User;

// Requests
use App\Http\Requests\calendar\StoreWorkoutRequest;
use App\Http\Requests\calendar\UpdateWorkoutRequest;
use App\Http\Requests\calendar\AddRestPeriodRequest;
use App\Http\Requests\calendar\UpdateRestPeriodRequest;
use App\Http\Requests\calendar\NotifyRequest;

// Mails
use App\Mail\WorkoutMail;

// Jobs
use App\Jobs\SendEmailJob;


class CalendarController extends Controller
{
    // INDEX - DONE
    public function index(User $user = null) {
        $rest_periods = RestPeriod::all();
        
        if(Auth::user()->isAdmin()) {
            $users = User::members()->get();
            
            if($user) {
                $workouts_visible = Workout::with('user:id,lastname,firstname')->where('user_id', $user->id)->get();
                $workouts_locked  = Workout::where('user_id', '!=' , $user->id)->get();

                return view('admin.members.calendar.index')->with(
                    [
                        'workouts_visible'  => $workouts_visible, 
                        'workouts_locked'   => $workouts_locked,
                        'rest_periods'      => $rest_periods,
                        'users'             => $users,
                        'user'              => $user,
                        'member'              => $user,
                    ]
                );
            } else {

                $workouts_visible = Workout::with('user:id,lastname,firstname')->get();
                $workouts_locked  = collect([]);

                return view('admin.calendar.index')->with(
                    [
                        'workouts_visible'  => $workouts_visible, 
                        'workouts_locked'   => $workouts_locked,
                        'rest_periods'      => $rest_periods,
                        'users'             => $users,
                        'user'              => null,
                    ]
                );
            }
        } else {
            $workouts_visible = Workout::with('user:id,lastname,firstname')->where('user_id', Auth::user()->id)->get();
            $workouts_locked  = Workout::where('user_id', '!=' ,Auth::user()->id)->get();

            return view('member.calendar.index')->with(
                [
                    'workouts_visible'  => $workouts_visible, 
                    'workouts_locked'   => $workouts_locked,
                    'rest_periods'      => $rest_periods,
                ]
            );
        }
    }

    // NOTIFY - DONE
    public function notify(User $user = null) {
        
        if(Auth::user()->isAdmin()) {
            if($user) {
                $workouts_not_notified = Workout::where('notified', false)->where('user_id', $user->id)->get();

                return view('admin.members.calendar.notify')->with(
                    [
                        'workouts_not_notified'  => $workouts_not_notified,
                        'member'                  => $user,
                    ]
                );
            } else {

                $workouts_not_notified = Workout::where('notified', false)->get();

                return view('admin.calendar.notify')->with(
                    [
                        'workouts_not_notified'  => $workouts_not_notified,
                        'member'                 => null,
                    ]
                );
            }
        } else {
            $workouts_not_notified = Workout::where('notified', false)->where('user_id', Auth::user()->id)->get();

            return view('member.calendar.notify')->with(
                [
                    'workouts_not_notified'  => $workouts_not_notified, 
                    ''
                ]
            );
        }
    }

    // TO NOTIFY - DONE
    public function toNotify(NotifyRequest $request) {
        $data = $request->validated();

        if(isset($data['workouts'])) {
            $workouts = Workout::whereIn('id', $data['workouts'])->get();
    
            // On récupère les membres concernés par les $workouts
            $members = $workouts->pluck('user')->unique();
    
            // On récupère les admins
            $admins = User::admins()->get();
    
            // Pour chaque membre on envoie un mail avec les séances qui ont été notifiées
            foreach($members as $member) {
                $mail = new WorkoutMail($member, $workouts->where('user_id', $member->id));
                SendEmailJob::dispatch($mail);
            }
    
            // Pour chaque admin on envoie un mail avec les séances qui ont été notifiées
            foreach($admins as $admin) {
                $mail = new WorkoutMail($admin, $workouts);
                SendEmailJob::dispatch($mail);
            }
        }

        $workouts = Workout::where('notified', false)->get();

        foreach($workouts as $workout) {
            $workout->update(['notified' => true]);
        }

        return redirect()->back()->with(['success' => 'Les utilisateurs concernés ont été notifiés']);
    }

    // ADD WORKOUT - DONE
    public function addWorkout() {

        $user = Auth::user();

        if($user->isAdmin()) {
            return redirect()->back()->with(['error' => 'Un administrateur ne peut pas avoir de séance']);
        } else {
            // Si l'utilisateur n'a pas utilisé sa séance gratuite
            if($user->first_session) {
                Workout::create([
                    'user_id' => $user->id,
                    'plan_id' => null,
                    'date'    => null,
                    'status'  => false,
                ]);

                $user->update(['first_session' => false]);

                return redirect()->back()->with(['success' => 'Séance gratuite ajoutée avec succès']);
            // Si l'utilisateur a utilisé sa séance gratuite
            } else {
                // Si l'utilisateur a un abonnement en cours
                if($user->hasCurrentPlan()) {
                    // Si l'utilisateur a des séances restantes dans son abonnement
                    if($user->currentPlan->sessions_left > 0) {
                        Workout::create([
                            'user_id' => $user->id,
                            'plan_id' => $user->currentPlan->id,
                            'order_id'=> $user->currentPlan->order_id,
                            'date'    => null,
                            'status'  => false,
                        ]);

                        $user->currentPlan->decrement('sessions_left');

                        return redirect()->back()->with(['success' => 'Séance ajoutée avec succès']);
                    // Si l'utilisateur n'a plus de séances dans son abonnement
                    } else {
                        return redirect()->back()->with(['error' => 'Impossible d\'ajouter une séance, vous n\'avez plus de séances dans votre abonnement']);
                    }
                // Si l'utilisateur n'a pas d'abonnement en cours
                } else {
                    return redirect()->back()->with(['error' => 'Impossible d\'ajouter une séance, vous n\'avez pas d\'abonnement en cours']);
                }
            }
            return redirect()->back()->with(['error' => 'Impossible d\'ajouter une séance']);
        }

    }

    // STORE WORKOUT - DONE
    public function storeWorkout(StoreWorkoutRequest $request) {
        $data = $request->validated();

        // Si l'utilisateur n'est pas admin
        if(!Auth::user()->isAdmin()) {
            return redirect()->back()->with(['error' => 'Vous n\'avez pas les droits pour ajouter des séances']);
        }

        $user = User::where('id', $data['user'])->first();

        // Si l'utilisateur est admin
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

    // UPDATE WORKOUT - DONE
    public function updateWorkout(UpdateWorkoutRequest $request) {

        $workout = Workout::findOrFail($request->workoutId);

        // Si l'utilisateur n'est pas admin il y a des vérifications à faire
        if(!Auth::user()->isAdmin()) {

            // Si il y a une erreur dans la requête
            if($workout->user->id != $request->userId) {
                return response()->json(['status' => 'error', 'message' => 'Impossible de mettre à jour la séance']);
            }

            // Si l'utilisateur n'est pas le propriétaire de la séance
            if($workout->user->id != Auth::id()) {
                return response()->json(['status' =>  'error', 'message' => 'Impossible de mettre à jour la séance d\'un autre membre que vous']);
            }
            
            // Si la séance est terminée
            if($workout->status) {
                return response()->json(['status' => 'error', 'message' => 'Impossible de mettre à jour une séance déjà effectuée']);
            }

            // Si la date est fournie, c'est une modification de séance
            if($request->date) {

                // Si la date est passée ou est aujourd'hui
                if (Carbon::parse($request->date)->isPast() || Carbon::parse($request->date)->isToday()) {
                    return response()->json(['status' => 'error', 'message' => 'Impossible de mettre à jour la séance, la date fournie est déjà passée ou c\'est aujourd\'hui']);
                }
                
                // Si la date n'est pas fournie, c'est un retrait de séance
            } else {
                if(Carbon::parse($workout->date)->isPast()) {
                    return response()->json(['status' => 'error', 'message' => 'Impossible de retirer la séance, car la date est déjà passée']);
                }
            }
        }
        
        
        // Si la date se superpose à une autre séance ou une période de repos
        if($request->date) {
            $newStart = Carbon::parse($request->date);
            $newEnd = $newStart->copy()->addHour();
        
            // Vérifier les conflits de séances
            if ($workout->hasOverlappingWorkouts($newStart, $newEnd, $workout->id)) {
                return response()->json([
                    'status' => 'error', 
                    'message' => 'Impossible de mettre à jour la séance, une autre séance est déjà prévue à cette date'
                ]);
            }
        
            // Vérifier les conflits de périodes de repos
            if ($workout->hasOverlappingRestPeriods($newStart, $newEnd)) {
                return response()->json([
                    'status' => 'error', 
                    'message' => 'Impossible de mettre à jour la séance, une période de repos est déjà prévue à cette date'
                ]);
            }
        }

        if($request->date) {
            // Mettre à jour la séance
            $workout->update([
                'date' => Carbon::parse($request->date),
                'status' => false, 
                'notified' => false
            ]);

            // dd('Il y a une date dans la requête : ' . $request->date);
            // dd('Date du workout mis à jour : ' . $workout->date);
        } else {
            // Retirer la séance
            $workout->update([
                'date' => null,
                'status' => false, 
                'notified' => false
            ]);
        }


        $workout->load('user:id,lastname,firstname');

        return response()->json(
            [
                'status' => 'success', 
                'message' => 'Séance mise à jour avec succès',
                'workout' => $workout,
            ]
        );
    }

    // DONE WORKOUT - DONE
    public function doneWorkout(User $user, Workout $workout) {

        // Si l'utilisateur n'est pas admin
        if(!Auth::user()->isAdmin()) {
            return redirect()->back()->with(['error' => 'Vous n\'avez pas les droits pour marquer une séance comme faite']);
        }

        // Si la séance n'appartient pas à l'utilisateur fournie
        if($workout->user_id != $user->id) {
            return redirect()->back()->with(['error' => 'Impossible de marquer la séance comme faite']);
        }

        // On ne peut pas si la séance est dans le futur
        if(Carbon::parse($workout->date)->isFuture()) {
            return redirect()->back()->with(['error' => 'Impossible de marquer une séance future comme faite']);
        }

        $workout->update(['status' => true, 'notified' => false]);
        return redirect()->back()->with(['success' => 'Séance marquée comme faite']);
    }

    // UNDONE WORKOUT - DONE
    public function undoneWorkout(User $user, Workout $workout) {

        // Si l'utilisateur n'est pas admin
        if(!Auth::user()->isAdmin()) {
            return redirect()->back()->with(['error' => 'Vous n\'avez pas les droits pour marquer une séance comme non faite']);
        }

        // Si la séance n'appartient pas à l'utilisateur fournie
        if($workout->user_id != $user->id) {
            return redirect()->back()->with(['error' => 'Impossible de marquer la séance comme non faite']);
        }

        // On ne peut pas si la séance est dans le futur
        if(Carbon::parse($workout->date)->isFuture()) {
            return redirect()->back()->with(['error' => 'Impossible de marquer une séance future comme non faite']);
        }

        $workout->update(['status' => false, 'notified' => false]);
        return redirect()->back()->with(['success' => 'Séance marquée comme non faite']);
    }

    // SOFT DELETE WORKOUT - DONE
    public function softDeleteWorkout(User $user, Workout $workout) {

        // Si l'utilisateur n'est pas admin
        if(!Auth::user()->isAdmin()) {
            return redirect()->back()->with(['error' => 'Vous n\'avez pas les droits pour mettre à la corbeille une séance']);
        }

        // Si la séance n'appartient pas à l'utilisateur fournie
        if($workout->user_id != $user->id) {
            return redirect()->back()->with(['error' => 'Impossible de mettre à la corbeille la séance']);
        }

        $workout->delete();
        return redirect()->back()->with(['success' => 'Séance mise à la corbeille avec succès']);
    }
    
    // RESTORE WORKOUT - DONE
    public function restoreWorkout(int $id) {

        $workout = Workout::withTrashed()->findOrFail($id);

        // Si l'utilisateur n'est pas admin
        if(!Auth::user()->isAdmin()) {
            return redirect()->back()->with(['error' => 'Vous n\'avez pas les droits pour restaurer une séance']);
        }

        $workout->restore();
        return redirect()->back()->with(['success' => 'Séance restaurée avec succès']);
    }
    
    // DELETE WORKOUT - DONE
    public function deleteWorkout(int $id) {

        $workout = Workout::withTrashed()->findOrFail($id);
        
        // Si l'utilisateur n'est pas admin
        if(!Auth::user()->isAdmin()) {
            return redirect()->back()->with(['error' => 'Vous n\'avez pas les droits pour supprimer une séance']);
        }

        $workout->forceDelete();
        return redirect()->back()->with(['success' => 'Séance supprimée avec succès']);
    }

    // ADD REST PERIOD - DONE
    public function addRestPeriod(AddRestPeriodRequest $request) {
        // Si l'utilisateur n'est pas admin
        if(!Auth::user()->isAdmin()) {
            return redirect()->back()->with(['error' => 'Vous n\'avez pas les droits pour ajouter des périodes de repos']);
        }

        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);

        // Vérifier les dates
        if ($end_date->lte($start_date)) {
            return redirect()->back()->with(['error' => 'La date de fin doit être supérieure à la date de début']);
        }

        // Vérifier les conflits de périodes de repos
        if (RestPeriod::overlapsWithOtherRestPeriods($start_date, $end_date)) {
            return redirect()->back()->with(['error' => 'Une autre période de repos est déjà prévue à cette date']);
        }

        // Vérifier les conflits de séances
        if (RestPeriod::overlapsWithWorkouts($start_date, $end_date)) {
            return redirect()->back()->with(['error' => 'Une séance est déjà prévue à cette date']);
        }

        RestPeriod::create([
            'start_date' => $start_date,
            'end_date'   => $end_date,
        ]);

        return redirect()->back()->with(['success' => 'Période de repos ajoutée avec succès']);
    }


    // UPDATE REST PERIOD - DONE
    public function updateRestPeriod(UpdateRestPeriodRequest $request) {
        // Si l'utilisateur n'est pas admin
        if(!Auth::user()->isAdmin()) {
            return redirect()->back()->with(['error' => 'Vous n\'avez pas les droits pour ajouter des périodes de repos']);
        }

        $rest_period = RestPeriod::findOrFail($request->rest_period);

        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);

        // Vérifier les dates
        if ($end_date->lte($start_date)) {
            return response()->json(['status' => 'error', 'message' => 'La date de fin doit être supérieure à la date de début']);
        }

        // Vérifier les conflits de périodes de repos
        if (RestPeriod::overlapsWithOtherRestPeriods($start_date, $end_date, $rest_period->id)) {
            return response()->json(['status' => 'error', 'message' => 'Une autre période de repos est déjà prévue à cette date']);
        }

        // Vérifier les conflits de séances
        if (RestPeriod::overlapsWithWorkouts($start_date, $end_date)) {
            return response()->json(['status' => 'error', 'message' => 'Une séance est déjà prévue à cette date']);
        }

        // Mise à jour de la période de repos
        $rest_period->update([
            'start_date' => $start_date,
            'end_date'   => $end_date,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Période de repos mise à jour avec succès']);
    }


    // DELETE REST PERIOD - DONE
    public function deleteRestPeriod(UpdateRestPeriodRequest $request) {

        // Si l'utilisateur n'est pas admin
        if(!Auth::user()->isAdmin()) {
            return redirect()->back()->with(['error' => 'Vous n\'avez pas les droits pour ajouter des périodes de repos']);
        }

        $rest_period = RestPeriod::findOrFail($request->rest_period);
        $rest_period->delete();

        return response()->json(['status' => 'success', 'message' => 'Période de repos supprimée avec succès']);
    }


    
}
