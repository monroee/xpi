<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaypalController;
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
    return view('auth.login');
});

Route::get('/paypal/login', [PaypalController::class, 'login'])->name('paypal.login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/paypal/payment', [PaypalController::class, 'index'])->name('paypal.index');
    Route::post('/paypal/bill', [PaypalController::class, 'bill'])->name('paypal.bill');
    Route::get('/paypal/success', [PaypalController::class, 'success'])->name('paypal.success');
    Route::get('/paypal/error', [PaypalController::class, 'error'])->name('paypal.error');
});

require __DIR__.'/auth.php';
