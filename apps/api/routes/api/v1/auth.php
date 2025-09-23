<?php

use App\Http\Controllers\Api\V1\Auth\OtpAuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:otp_request')->name('auth.')->group(function () {
    Route::post('otp/request', [OtpAuthController::class, 'requestOtp'])->name('otp.request');
    Route::post('otp/verify', [OtpAuthController::class, 'verifyOtp'])->name('otp.verify');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', function () {
        return auth()->user();
    })->name('me');
    Route::post('logout', function () {
        // revoke current token
        auth()->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    })->name('logout');
});