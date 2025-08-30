<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    
    public function index(Request $request)
    {
        if($request->ajax()){
        $customers = \App\Models\Customer::orderBy('id','desc')->paginate(5); 

        return response()->json([
            'data' => $customers->items(), 
            'pagination' => [
                'current_page' => $customers->currentPage(),
                'last_page'    => $customers->lastPage(),
                'per_page'     => $customers->perPage(),
                'total'        => $customers->total(),
            ],
        ]);
        }

        return view('admin.customers.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|string|min:6',
        ]);

        $customer=Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

         return response()->json([
        'status' => 'success',
        'message' => 'Customer added successfully!',
        'data' => $customer
    ]);
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json($customer);
    }

    
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:customers,email,{$id}",
            'password' => 'nullable|string|min:6',
        ]);

        $customer->name = $request->name;
        $customer->email = $request->email;

        if($request->password){
            $customer->password = Hash::make($request->password);
        }

        $customer->save();

        return response()->json([
        'status' => 'success',
        'message' => 'Customer updated successfully!',
        'data' => $customer
    ]);
    }

    
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return response()->json(['success' => true]);
    }
}
