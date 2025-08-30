<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    
    public function dashboard()
    {
        return view('admin.dashboard');
    }

   
    public function users(Request $request)
    {
        $customers = Customer::latest()->paginate(5);

       
        if ($request->ajax()) {
            return view('admin.partials.customers_table', compact('customers'))->render();
        }

       
        return view('admin.users', compact('customers'));
    }

    
    public function storeUser(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|min:6'
        ]);

        Customer::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json(['success' => true]);
    }

    
    public function editUser($id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json($customer);
    }

    
    public function updateUser(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
        ]);

        $customer->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return response()->json(['success' => true]);
    }

   
    public function deleteUser($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return response()->json(['success' => true]);
    }
}
