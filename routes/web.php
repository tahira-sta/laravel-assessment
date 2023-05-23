<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController as ProductController;
use App\Http\Controllers\Client\ClientController as ClientController;
use App\Http\Controllers\Client\ClientProductController as ClientProductController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

    // Redirect the root URL to the login page
    Route::redirect('/', '/login');

    // Define the root URL route
    Route::get('/', function () {
        // Check if the user is already authenticated
        if (Auth::check()) {
            // Redirect to the home page
            return redirect('/home');
        } else {
            // Redirect to the login page
            return redirect('/login');
        }
    });

    // Route for logging out
    Route::get('/logout', function () {
        // Redirect to the login page
        return redirect('/login');
    });

    // Laravel authentication routes
    Auth::routes();

    // Route for the home page
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Route for /product
    Route::resource('product', ProductController::class);

    // Route for /product-client
    Route::resource('product-client', ClientProductController::class);
    Route::post('/product-client', [ClientController::class, 'setPrices'])->name('set-price');

    // Route for /client
    Route::resource('client', ClientController::class);
