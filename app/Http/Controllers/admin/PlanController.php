<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Plan;

class PlanController extends Controller
{
    public function index() {
        $plans = Plan::all();
        return view('admin.plans.index')->with(['plans' => $plans]);
    }

    public function softDelete(Plan $plan) {
        $plan->delete();
        return redirect()->back()->with(['success' => 'Plan mis à la corbeille avec succès']);
    }

    public function restore(int $id) {
        $plan = Plan::withTrashed()->findOrFail($id);
        $plan->restore();
        return redirect()->back()->with(['success' => 'Plan restauré avec succès']);
    }

    public function delete(int $id) {
        $plan = Plan::withTrashed()->findOrFail($id);
        $plan->forceDelete();
        return redirect()->back()->with(['success' => 'Plan supprimé avec succès']);
    }
}
