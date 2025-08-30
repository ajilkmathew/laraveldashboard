<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Customer\CustomerController as CustomerDashController;
use App\Http\Controllers\Customer\CustomerAuthController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
})->name('home');


//  Admin Routes
Route::prefix('admin')->name('admin.')->group(function(){

    // Authentication
    Route::get('login', [AdminAuthController::class,'showLogin'])->name('login');
    Route::post('login', [AdminAuthController::class,'login']);
    Route::get('register', [AdminAuthController::class,'showRegister'])->name('register');
    Route::post('register', [AdminAuthController::class,'register']);

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Customer Management
        Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
        Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
        Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
        Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');

        Route::post('/logout', [AdminAuthController::class,'logout'])->name('logout');
    });
});

//  Customer Routes
Route::prefix('customer')->name('customer.')->group(function(){
    Route::get('login', [CustomerAuthController::class,'showLogin'])->name('login');
    Route::post('login', [CustomerAuthController::class,'login']);
    Route::get('register', [CustomerAuthController::class,'showRegister'])->name('register');
    Route::post('register', [CustomerAuthController::class,'register']);

    Route::middleware('auth:customer')->group(function(){
        Route::get('dashboard',[CustomerDashController::class,'dashboard'])->name('dashboard');
        Route::post('logout',[CustomerAuthController::class,'logout'])->name('logout');
    });
});
