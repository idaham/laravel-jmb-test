<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PaymentReceiptController;

Route::get('/', function () {
    return view('landing');
});

/*
|--------------------------------------------------------------------------
| Login (guest only)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
});

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/portal', function () {
        abort_unless(auth()->user()->hasRole('resident'), 403);
        //abort_unless(auth()->user()->can('access portal'), 403);

        return view('portal.dashboard');
    });

    Route::get('/system/payments/{payment}/receipt', PaymentReceiptController::class)
        ->name('system.payments.receipt');

});




