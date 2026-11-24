<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\TeknisiController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

/* NOTE: Do Not Remove
/ Livewire asset handling if using sub folder in domain
*/
Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});
/*
/ END
*/

// Splash Screen & Guest Authentication (Single Unified Login for All Roles)
Route::get('/', [AuthController::class, 'showSplash'])->name('splash');
Route::view('/demo-ui', 'pages.demo-ui')->name('demo-ui');
Route::redirect('/admin/login', '/login');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/quick-login/{email}', [AuthController::class, 'quickLogin'])->name('quick-login');

// Customer Routes (Protected)
Route::middleware(['auth'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/set-address', [CustomerController::class, 'showSetAddress'])->name('set-address');
    Route::post('/set-address', [CustomerController::class, 'storeAddress'])->name('store-address');
    Route::get('/home', [CustomerController::class, 'home'])->name('home');
    Route::get('/technicians', [CustomerController::class, 'technicians'])->name('technicians');
    Route::get('/technicians/{id}', [CustomerController::class, 'technicianDetail'])->name('technician-detail');
    Route::get('/orders', [CustomerController::class, 'orders'])->name('orders');
    Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
    Route::get('/api/geocode', [CustomerController::class, 'searchLocation'])->name('api.geocode');
    Route::get('/api/reverse-geocode', [CustomerController::class, 'reverseGeocode'])->name('api.reverse-geocode');
});

// Booking & Payment
Route::middleware(['auth'])->group(function () {
    Route::get('/booking/{teknisiId}', [BookingController::class, 'showBookingForm'])->name('booking.form');
    Route::post('/booking', [BookingController::class, 'storeBooking'])->name('booking.store');
    Route::get('/payment/{bookingId}', [BookingController::class, 'showPayment'])->name('booking.payment');
    Route::post('/payment/{bookingId}', [BookingController::class, 'processPayment'])->name('booking.process-payment');
    Route::post('/review/{bookingId}', [FieldController::class, 'submitReview'])->name('review.submit');

    // Field Tracking & Chat
    Route::get('/tracking-chat/{bookingId}', [FieldController::class, 'showTrackingChat'])->name('tracking.chat');
    Route::post('/chat/{bookingId}', [FieldController::class, 'sendChatMessage'])->name('chat.send');
    Route::get('/api/chat/{bookingId}', [FieldController::class, 'fetchChatMessages'])->name('api.chat.fetch');
    Route::get('/api/gps/{bookingId}', [FieldController::class, 'fetchGpsLocation'])->name('api.gps.fetch');
    Route::post('/api/gps/{bookingId}', [FieldController::class, 'updateGpsLocation'])->name('api.gps.update');
    Route::get('/api/route/{bookingId}', [FieldController::class, 'fetchNavigationRoute'])->name('api.route.fetch');
});

// Teknisi Portal (Protected)
Route::middleware(['auth'])->prefix('teknisi')->name('teknisi.')->group(function () {
    Route::get('/dashboard', [TeknisiController::class, 'dashboard'])->name('dashboard');
    Route::post('/toggle-status', [TeknisiController::class, 'toggleStatus'])->name('toggle-status');
    Route::post('/job-status/{bookingId}', [TeknisiController::class, 'updateJobStatus'])->name('job-status');
    Route::post('/order/{bookingId}/status', [TeknisiController::class, 'updateJobStatus'])->name('order-status');
    Route::get('/wallet', [TeknisiController::class, 'wallet'])->name('wallet');
});
