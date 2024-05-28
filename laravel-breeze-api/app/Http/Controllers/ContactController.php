<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function getContact()
    {
        $contacts = Contact::orderBy('id', 'desc')->get();

        return response()->json([
            'contacts' => $contacts
        ], 200);
    } //End Method
    public function deleteContact($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
    } //End Method

    public function addContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|integer',
            'address' => 'required|string',
            'message' => 'required|string',
        ]);
        Contact::insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'message' => $request->message,
            'created_at' => Carbon::now(),
        ]);
        return response()->json([
            // 'newProduct' => $newProduct
            'message' => 'Message Send  successfully'
        ]);
    }//End Method
}
