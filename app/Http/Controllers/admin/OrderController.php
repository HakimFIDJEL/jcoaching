<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Order;

class OrderController extends Controller
{
    public function index() {
        $orders = Order::all();

        return view('admin.orders.index')->with([
            'orders' => $orders,
        ]);
    }

    public function delete(Order $order) {
        $invoice = $order->invoice;

        if($order->product_type == 'plan') {

            $plan = $order->plan;
            if($plan) {
                $workouts = $order->plan->workouts;
                foreach($workouts as $workout) {
                    $workout->forceDelete();
                }
                $order->plan->forceDelete();
            }

        } elseif($order->product_type == 'workout') {
            $workouts = $order->workouts;
            if($workouts) {
                foreach($workouts as $workout) {
                    $workout->forceDelete();
                }
            }
        }

        if ($invoice) {
            if($invoice->path) {
                Storage::delete($invoice->path);
            }
            $invoice->delete();
        }

        $order->delete();
        return redirect()->back()->with(['success' => 'Ordre d\'achat supprimée avec succès. ']);
    }
}
