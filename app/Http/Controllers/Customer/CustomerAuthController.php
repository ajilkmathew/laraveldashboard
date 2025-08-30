<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends Controller
{
    
    public function showRegister() {
        return view('customer.register');
    }

    
    public function register(Request $request) {
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:customers,email',
            'password'=>'required|min:6|confirmed'
        ]);

        Customer::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);

        return redirect()->route('customer.login')->with('success','Registration successful! Login now.');
    }

     
    public function showLogin() {
        return view('customer.login');
    }

    
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::guard('customer')->attempt($request->only('email','password'))) {
            return redirect()->route('customer.dashboard');
        }

        return back()->withErrors(['email'=>'Invalid credentials']);
    }

    
    public function logout() {
        Auth::guard('customer')->logout();
        return redirect()->route('customer.login');
    }
}
