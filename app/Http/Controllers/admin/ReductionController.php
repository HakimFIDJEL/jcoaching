<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
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
        return redirect()->route('admin.reductions.index')->with(['success' => 'Code de réduction restauré avec succès']);
    }

    public function delete($id) {
        $reduction = Reduction::withTrashed()->findOrFail($id);
        $reduction->forceDelete();
        return redirect()->route('admin.reductions.index')->with(['success' => 'Code de réduction supprimé avec succès']);
    }


}
