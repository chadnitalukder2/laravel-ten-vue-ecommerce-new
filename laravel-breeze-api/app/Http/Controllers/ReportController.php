<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    function all_product(){
        $products = Product::orderBy('id', 'desc')->get();
        return response()->json([
            'products' => $products
        ], 200);
    }
    function selling_product (){
        $orderItems = OrderItems::where('status', 'ordered')->get();
        return response()->json([
            'orderItems' => $orderItems
        ], 200);
    }
    function total_amount (){
        $orders = Order::where('payment_status', 'Paid')->get();
        return response()->json([
            'orders' => $orders
        ], 200);
    }
}
