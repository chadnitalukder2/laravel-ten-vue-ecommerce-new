<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function get_user(){
        $user = User::orderBy('id', 'desc')->get();
        return response()->json([
            'user' => $user
        ], 200);
    }

    public function delete_user($id) {
        $user = User::findOrFail($id);
        $user->delete();
    }

    public function edit_user ($id){
        $user = User::find($id);
        return response()->json([
            'user' => $user
        ], 200);
    }

    public function update_user (Request $request, $id){
        $user = User::where('id', $id)->first();
       
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
           
         ]);
         return response()->json([
            'user' => $user
        ], 200);
    }


}
