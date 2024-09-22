<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $order->delete();
        return redirect()->back()->with(['success' => 'Ordre d\'achat supprimée avec succès.']);
    }
}
