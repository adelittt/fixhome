<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::post('/midtrans/notification', [BookingController::class, 'handleMidtransNotification'])
    ->name('midtrans.notification');
