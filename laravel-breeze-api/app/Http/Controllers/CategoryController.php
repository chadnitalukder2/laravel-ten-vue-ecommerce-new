<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function get_category(){
        $category = Category::orderBy('id', 'desc')->with('product')->get();
        return response()->json([
            'category' => $category
        ], 200);
        return $this->belongsTo(Product::class);
      
    }

    public function delete_category($id){
        $category = Category::findOrFail($id);
        $category->delete();
    }



    public function add_category(Request $request){
        $request->validate([
            'category_name' => 'required|string',
            'category_img' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);
        
        $imagePath = $request->file('category_img')->store('category_img', 'public');
        $imagePath = asset('storage/'.$imagePath);


        Category::insert([
            'category_name' => $request->category_name,
            'category_img' =>  $imagePath,
            'created_at' => Carbon::now(),
        ]);
        return response()->json([
            // 'newProduct' => $newProduct
            'message' => 'Category added successfully'
        ]);
    }

}
