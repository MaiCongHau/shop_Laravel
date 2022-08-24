<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    //
    public function index()
    {
        $customer_id = Auth::user()->id;
        $orders = Customer::find($customer_id)->order;
        return view('order.index',['orders'=>$orders]);
    }
    public function show($orderId)
    {
        $orders = Order::find($orderId);
    
        return view('order.show',['orders'=>$orders]);
    }
}
