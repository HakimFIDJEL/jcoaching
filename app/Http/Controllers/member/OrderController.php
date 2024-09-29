<?php

namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Order;

class OrderController extends Controller
{
    public function index() {
        $orders = Auth::user()->orders;

        return view('member.orders.index')->with([
            'orders' => $orders,
        ]);
    }
}
