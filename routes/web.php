<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// socialite
Route::get('/sign-in-google', [UserController::class, 'google'])->name('google.login');
Route::get('/auth/google/callback', [UserController::class, 'handleProviderCallback'])->name('google.callback');

// middleware
Route::middleware(['auth'])->group(function () {

    // checkout
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/{camp:slug}', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/checkout/{camp}', [CheckoutController::class, 'store'])->name('checkout.store');
    // user dashboard
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('user.dashboard');
});


require __DIR__ . '/auth.php';
