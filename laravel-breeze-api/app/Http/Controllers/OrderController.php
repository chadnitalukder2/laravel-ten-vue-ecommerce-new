<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_orders(Request $request)
    {
        $orderItemsIds = $request->order_items_id;
        DB::beginTransaction();
        try {
            $orders = new Order([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'total_amount' => $request->input('total_amount'),
                'user_id' => Auth::user()->id,
            ]);
    
            $orders->save();
            $order_id = $orders->id;
    
            foreach ($orderItemsIds as $orderItemsId) {
                // Update order_id and status in order_items table
                $orderItem = OrderItems::find($orderItemsId);
                $orderItem->order_id = $order_id;
                $orderItem->status = 'ordered';
                $orderItem->save();

                // Update product_quantity in products table
                $product = Product::find($orderItem->product_id);

                if ($product->product_quantity >= $orderItem->quantity) {
                    $product->product_quantity = $product->product_quantity - $orderItem->quantity;
                    $product->save();
                } else {
                    throw new \Exception("Product quantity is too much. Please check the quantity and try again.");
                }
                
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage() ], 500);
        }
        
    
        return response()->json(['message' => 'orders added successfully'], 201);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_all_Order()
    {
        $orderItems = Order::orderBy('id', 'desc')->get();
        return response()->json([
            'orderItems' => $orderItems
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getOrderItemByOrderId($id)
    {
        $orderItem = OrderItems::orderBy('id', 'desc')->where('order_id', $id)->with('product')->get();

        return response()->json([
            'orderItem' => $orderItem
        ], 200);
        // return $this->belongsTo(Product::class);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update_order_status(Request $request, $id)
    {
        $updateStatus = Order::where('id', $id)->first();
       
        $updateStatus->update([
            'order_status' => $request->order_status,
            'payment_status' => $request->payment_status,
           
         ]);
         return response()->json([
            'updateStatus' => $updateStatus
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function delete_order_item( $id)
    {
        $orderItem = Order::findOrFail($id);
        $orderItem->delete();
    }
}
