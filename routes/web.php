<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\CheckoutController as AdminCheckoout;
use App\Http\Controllers\Admin\DiscountController as AdminDiscount;

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

// midtrans routes
Route::get('/payment/success', [CheckoutController::class, 'midtransCallback'])->name('midtrans.callback');
Route::post('/payment/success', [CheckoutController::class, 'midtransCallback'])->name('midtrans.callback');

// middleware
Route::middleware(['auth'])->group(function () {

    // checkout
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success')->middleware('ensureUserRole:user');
    Route::get('/checkout/{camp:slug}', [CheckoutController::class, 'create'])->name('checkout.create')->middleware('ensureUserRole:user');
    Route::post('/checkout/{camp}', [CheckoutController::class, 'store'])->name('checkout.store')->middleware('ensureUserRole:user');
    // dashboard
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('user.dashboard');

    // user dashboard
    Route::prefix('user/dashboard')->namespace('User')->name('user.')->middleware('ensureUserRole:user')->group(function () {
        Route::get('/', [UserDashboard::class, 'index'])->name('dashboard');
    });

    // admin dashboard
    Route::prefix('admin/dashboard')->name('admin.')->middleware('ensureUserRole:admin')->group(function () {
        Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');

        // admin checkout
        Route::post('checkout/{checkout}', [AdminCheckoout::class, 'update'])->name('checkout.update');

        // admin discount
        Route::resource('discount', AdminDiscount::class);
    });
});


require __DIR__ . '/auth.php';
