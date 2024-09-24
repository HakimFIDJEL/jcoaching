<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\User;
use App\Models\Reduction;

// Requests
use App\Http\Requests\admin\reductions\ReductionRequest;

class ReductionController extends Controller
{
    public function index() {
        $reductions = Reduction::all();
        return view('admin.reductions.index')->with(['reductions' => $reductions]);
    }

    public function create() {
        return view('admin.reductions.create');
    }

    public function edit(Reduction $reduction) {
        return view('admin.reductions.edit')->with(['reduction' => $reduction]);
    }

    public function members(Reduction $reduction) {
        return view('admin.reductions.members')->with(['reduction' => $reduction, 'members' => User::members()->get()]);
    }

    public function link(User $user, Reduction $reduction) {

        if($user->hasUsedReduction($reduction->id)) {
            return redirect()->back()->with(['error' => 'Ce membre a déjà utilisé ce code de réduction']);
        }
    
        $user->reductions()->attach($reduction->id, [
            'created_at' => now(),
            'updated_at' => now()
        ]);
    
        return redirect()->back()->with(['success' => 'Membre associé avec succès']);
    }
    

    public function unlink(User $user, Reduction $reduction) {

        if(!$user->hasUsedReduction($reduction->id)) {
            return redirect()->back()->with(['error' => 'Ce membre n\'a pas utilisé ce code de réduction']);
        }
    
        $user->reductions()->detach($reduction->id);
        return redirect()->back()->with(['success' => 'Membre dissocié avec succès']);
    }
    

    public function store(ReductionRequest $request) {
        $data = $request->validated();
        Reduction::create($data);
        return redirect()->route('admin.reductions.index')->with(['success' => 'Code de réduction créé avec succès']);
    }

    public function update(ReductionRequest $request, Reduction $reduction) {
        $data = $request->validated();
        $reduction->update($data);
        return redirect()->route('admin.reductions.index')->with(['success' => 'Code de réduction modifié avec succès']);
    }

    public function softDelete(Reduction $reduction) {
        $reduction->delete();
        return redirect()->route('admin.reductions.index')->with(['success' => 'Code de réduction mis à la corbeille avec succès']);
    }

    public function restore($id) {
        $reduction = Reduction::withTrashed()->findOrFail($id);
        $reduction->restore();
        return redirect()->back()->with(['success' => 'Code de réduction restauré avec succès']);
    }

    public function delete($id) {
        $reduction = Reduction::withTrashed()->findOrFail($id);
        $reduction->forceDelete();
        return redirect()->back()->with(['success' => 'Code de réduction supprimé avec succès']);
    }


}
