<?php

namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\Plan;
use App\Models\Workout;
use App\Models\Setting;
use App\Models\Reduction;
use App\Models\Pricing;

class PaymentController extends Controller
{
    public function plan_index() {
        $pricings = Pricing::available()->get();

        return view('member.payment.plan_index')->with([
            'pricings' => $pricings,
            'nutrition_price' => Setting::first()->nutrition_price,
        ]);
    }

    public function workout_index() {
        // 
    }

    // GET REDUCTION - DOING
    public function get_reduction(ReductionRequest $request) {
        $data = $request->validated();
        $code = $data['code'];

        $reduction = Reduction::available()->where('code', $code)->first();

        if($reduction) {
            return response()->json([
                'status' => "success",
                'reduction' => $reduction,
            ]);
        } else {
            return response()->json([
                'status' => "error",
                'message' => 'Code de réduction invalide.',
            ]);
        }
    }

    
}
