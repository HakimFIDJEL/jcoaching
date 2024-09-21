<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\Pricing;
use App\Models\PricingFeature;

// Requests
use App\Http\Requests\admin\pricings\PricingRequest;


class PricingController extends Controller
{
    // INDEX - DONE
    public function index(){
        $pricings = Pricing::all();
        return view('admin.pricings.index')->with(['pricings' => $pricings]);
    }

    // CREATE - DONE
    public function create(){
        return view('admin.pricings.create');
    }

    // EDIT - DONE
    public function edit(Pricing $pricing) {
        return view('admin.pricings.edit')->with(['pricing' => $pricing]);
    }

    // STORE - DONE
    public function store(PricingRequest $request) {
        $data = $request->validated();
        
        $pricing = Pricing::create($data);

        if (!$pricing) {
            return redirect()->route('admin.pricings.index')->with(['error' => 'Erreur lors de la création du tarif.']);
        }

        foreach ($data['features'] as $feature) {
            $pricing->features()->create([
                'label' => $feature
            ]);
        }

        return redirect()->route('admin.pricings.index')->with(['success' => 'Le tarif a été créé avec succès']);
    }

    // UPDATE - DONE
    public function update(PricingRequest $request, Pricing $pricing) {
        $data = $request->validated();
        
        $pricing->update($data);
        
        $pricing->features()->delete();

        foreach ($data['features'] as $feature) {
            $pricing->features()->create([
                'label' => $feature
            ]);
        }

        return redirect()->route('admin.pricings.index')->with(['success' => 'Le tarif a été modifié avec succès']);
    }

    // SOFT DELETE - DONE
    public function softDelete(Pricing $pricing){
        $pricing->delete();
        return redirect()->route('admin.pricings.index')->with(['success' => 'Le tarif a été mis à la corbeille avec succès']);
    }

    // RESTORE - DONE
    public function restore(int $id){
        $pricing = Pricing::withTrashed()->findOrFail($id);
        $pricing->restore();
        return redirect()->back()->with(['success' => 'Le tarif a été restauré avec succès']);
    }

    // DELETE - DONE
    public function delete(int $id) {
        $pricing = Pricing::withTrashed()->findOrFail($id);
        $pricing->features()->delete(); 
        $pricing->forceDelete();
        return redirect()->back()->with(['success' => 'Le tarif a été supprimé avec succès']); 
    }   
}
