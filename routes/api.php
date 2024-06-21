<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TestController;
use App\Http\Controllers\API\PaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::middleware(['mock.response'])->group(function () {
Route::get('mockresponse-approved', [TestController::class, 'approveStatus'])->name('approveStatus');
Route::get('mockresponse-failed', [TestController::class, 'failStatus'])->name('failStatus');
});
Route::middleware('auth:sanctum')->group(function () {
Route::get('get-payments', [PaymentController::class, 'index'])->name('payments');
Route::post('store-payments', [PaymentController::class, 'store'])->name('payment-store');
Route::post('changeStatus', [PaymentController::class, 'paymentApproval'])->name('change-status');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

});