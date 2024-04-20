<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;

class ReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function prepareMonthlyReport(){

        $monthlyReport = Order::selectRaw('sum(total_amount) as total_amount, MONTH(created_at) as month')
        ->where('payment_status', 'Paid')
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();

        return $monthlyReport;
    }


    public function getReports(){
        $products = Product::with('category', 'brand')->orderBy('id', 'desc')->get();
        $orderItems = OrderItems::where('status', 'ordered')->count();
        $orders = Order::where('payment_status', 'Paid')->sum('total_amount');
        $total_users = User::count();

        return response()->json([
            'products' => $products->count(),
            'total_order_items' => $orderItems,
            'total_paid_amount' => $orders,
            'total_users' => $total_users,
            'monthly_order_report' => $this->prepareMonthlyReport(),
        ], 200);
    }


}
