<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function get_product(Request $request){

        $queryParams = $request['filter'];
        $products = Product::orderBy('id', 'desc')
        ->with('category', 'brand')
        ->when(isset($queryParams['category_id']), function($query) use ($queryParams){
            return $query->whereIn('category_id', $queryParams['category_id']);
        })
        ->when(isset($queryParams['brand_id']), function($query) use ($queryParams){
            return $query->whereIn('brand_id', $queryParams['brand_id']);
        })
        ->when(isset($queryParams['search']), function($query) use ($queryParams){
            return $query->where('product_name', 'like', '%'.$queryParams['search'].'%');
        })
        ->get();
        
        foreach ($products as $product) {
            $product->product_colors = json_decode($product->product_colors);
            $product->product_sizes = json_decode($product->product_sizes);

            $averageRating = $product->averageRating();
            $product->average_rating = round($averageRating, 2);
        }    
        return response()->json([
            'products' => $products
        ], 200);
      
    }

    public function add_products(Request $request){
        $request->validate([
            'product_name' => 'required|string',
            'product_price' => 'required|numeric',
            'product_quantity' => 'required|integer',
            'category_id' => 'required|integer',
            'brand_id' => 'required|integer',
            'product_details' => 'required|string',
            'product_img' => 'required|image|mimes:jpeg,png,jpg,gif',
           
        ]);
        $imagePath = $request->file('product_img')->store('product_images', 'public');
        $imagePath = asset('storage/'.$imagePath);
   
        

        // $imagePath =  storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $imagePath );
      //--------------------------------
        // $newProduct = new Product(); 
        // $newProduct->fill($request->except('product_img'));
        
        // $newProduct->product_img = $imagePath;

        // $newProduct->save();
        //----------------------
        Product::insert([
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'product_quantity' => $request->product_quantity,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'short_description' => $request->short_description,
            'product_details' => $request->product_details,
            'product_colors' => $request->product_colors,
            'product_sizes' => $request->product_sizes,
            'product_img' =>  $imagePath,
            'created_at' => Carbon::now(),
        ]);

        return response()->json([
            // 'newProduct' => $newProduct
            'message' => 'Product added successfully'
        ]);
    }

    public function delete_product($id){
        $product = Product::findOrFail($id);
        $product->delete();
    }

    public function edit_product($id){
        $product = Product::with('reviews.user')->find($id);
        $averageRating = $product->averageRating();
        $product->average_rating = round($averageRating, 2);

        $product->product_colors = json_decode($product->product_colors);
        $product->product_sizes = json_decode($product->product_sizes);
        return response()->json([
            'product' => $product,
            'user_id' => Auth::user()->id,
        ], 200);
    }

    public function update_product(Request $request , $id){
        $product = Product::where('id', $id)->first();
        $product->update([
                'product_name' => $request->product_name,
                'product_price' => $request->product_price,
                'product_quantity' => $request->product_quantity,
                // 'brand_id ' => $request->brand_id ,
                // 'category_id ' => $request->category_id ,
                'product_colors' => $request->product_colors,
                'product_sizes' => $request->product_sizes,
                'short_description' => $request->short_description,
                'product_details' => $request->product_details,
        ]);
      
    }


}
