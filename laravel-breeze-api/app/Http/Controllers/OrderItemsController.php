<?php

namespace App\Http\Controllers;

use App\Models\OrderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_OrderItem(Request $request)
    {
        $review = new OrderItems([
            'quantity' => $request->input('quantity'),
            'color' => $request->input('color'),
            'size' => $request->input('size'),
            'line_total' => $request->input('line_total'),
            'product_id' => $request->input('product_id'),
            'user_id' => $request->input('user_id'),
        ]);
    
        $review->save();
    
        return response()->json(['message' => 'Review added successfully'], 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_OrderItem()
    {
        $userId =  Auth::user()->id;
        $orderItem = OrderItems::orderBy('id', 'desc')->where('user_id', $userId)->where('status', 'cart')->with('product')->get();

        return response()->json([
            'orderItem' => $orderItem
        ], 200);
        // return $this->belongsTo(Product::class);
    }
    public function delete_OrderItem($id){
        $orderItem = OrderItems::findOrFail($id);
        $orderItem->delete();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderItems  $orderItems
     * @return \Illuminate\Http\Response
     */
    public function show(OrderItems $orderItems)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderItems  $orderItems
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderItems $orderItems)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderItems  $orderItems
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderItems $orderItems)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderItems  $orderItems
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderItems $orderItems)
    {
        //
    }
}
