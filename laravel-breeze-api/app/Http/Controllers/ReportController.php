<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function reports(){
        $products = Product::with('category', 'brand')->orderBy('id', 'desc')->get();
        $orderItems = OrderItems::where('status', 'ordered')->count();
        $orders = Order::where('payment_status', 'Paid')->sum('total_amount');
        $total_users = User::count();

        return response()->json([
            'products' => $products->count(),
            'orderItems' => $orderItems,
            'orders' => $orders,
            'total_users' => $total_users,
        ], 200);
    }

}
