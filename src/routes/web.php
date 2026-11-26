<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicPageController;
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

// Public Multi-Page Marketing & Guest Authentication (Customer & Teknisi; Admin uses /admin/login)
Route::get('/', [AuthController::class, 'showSplash'])->name('splash');
Route::get('/layanan', [PublicPageController::class, 'layanan'])->name('public.layanan');
Route::get('/teknisi', [PublicPageController::class, 'teknisi'])->name('public.teknisi');
Route::get('/cara-kerja', [PublicPageController::class, 'caraKerja'])->name('public.cara-kerja');
Route::get('/jadi-mitra', [PublicPageController::class, 'jadiMitra'])->name('public.jadi-mitra');
Route::get('/tentang-kami', [PublicPageController::class, 'tentangKami'])->name('public.tentang-kami');
Route::view('/demo-ui', 'pages.demo-ui')->name('demo-ui');
Route::redirect('/login/admin', '/admin/login');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register/send-otp', [AuthController::class, 'sendTeknisiOtp'])->name('register.send-otp');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Customer Routes (Protected — Opaque Hashed Paths)
Route::middleware(['auth'])->name('customer.')->group(function () {
    Route::get('/a7f3c9', [CustomerController::class, 'showSetAddress'])->name('set-address');
    Route::post('/a7f3c9', [CustomerController::class, 'storeAddress'])->name('store-address');
    Route::get('/h5e2b8', [CustomerController::class, 'home'])->name('home');
    Route::get('/k3d9f1', [CustomerController::class, 'technicians'])->name('technicians');
    Route::get('/t6b4e2/{teknisiId}', [CustomerController::class, 'technicianDetail'])->name('technician-detail');
    Route::get('/m8c1a4', [CustomerController::class, 'orders'])->name('orders');
    Route::get('/u2f7d5', [ProfileController::class, 'show'])->name('profile');
    Route::post('/u2f7d5', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/x4b9e3', [CustomerController::class, 'searchLocation'])->name('api.geocode');
    Route::get('/x4b9e3/r', [CustomerController::class, 'reverseGeocode'])->name('api.reverse-geocode');
});

// Booking, Payment, Invoice & Live Session (Protected — Opaque Hashed Paths + HMAC Token IDs)
Route::middleware(['auth'])->group(function () {
    Route::get('/b9d4e1/{teknisiId}', [BookingController::class, 'showBookingForm'])->name('booking.form');
    Route::post('/b9d4e1', [BookingController::class, 'storeBooking'])->name('booking.store');
    Route::get('/p3f8c2/{bookingId}', [BookingController::class, 'showPayment'])->name('booking.payment');
    Route::post('/p3f8c2/{bookingId}', [BookingController::class, 'processPayment'])->name('booking.process-payment');
    Route::post('/p3f8c2/{bookingId}/s', [BookingController::class, 'createMidtransSnap'])->name('booking.midtrans-snap');
    Route::get('/p3f8c2/{bookingId}/c', [BookingController::class, 'checkMidtransStatus'])->name('booking.midtrans-status');
    Route::get('/r7a2e6/{bookingId}', [BookingController::class, 'showInvoice'])->name('booking.invoice');
    Route::post('/r7a2e6/{bookingId}/m', [BookingController::class, 'resendInvoiceEmail'])->name('booking.invoice-resend');
    Route::post('/v5c8d3/{bookingId}', [FieldController::class, 'submitReview'])->name('review.submit');

    // Field Tracking & Chat (Opaque Hashed URL)
    Route::get('/c4f9b2/{bookingId}', [FieldController::class, 'showTrackingChat'])->name('tracking.chat');
    Route::post('/q2e7a5/{bookingId}', [FieldController::class, 'sendChatMessage'])->name('chat.send');
    Route::get('/q2e7a5/{bookingId}/f', [FieldController::class, 'fetchChatMessages'])->name('api.chat.fetch');
    Route::get('/g6d3f8/{bookingId}', [FieldController::class, 'fetchGpsLocation'])->name('api.gps.fetch');
    Route::post('/g6d3f8/{bookingId}', [FieldController::class, 'updateGpsLocation'])->name('api.gps.update');
    Route::get('/n8b1c4/{bookingId}', [FieldController::class, 'fetchNavigationRoute'])->name('api.route.fetch');
});

// Teknisi Portal (Protected — Opaque Hashed Paths)
Route::middleware(['auth'])->name('teknisi.')->group(function () {
    Route::get('/d1e5a9', [TeknisiController::class, 'dashboard'])->name('dashboard');
    Route::post('/d1e5a9/t', [TeknisiController::class, 'toggleStatus'])->name('toggle-status');
    Route::post('/j3c6f2/{bookingId}', [TeknisiController::class, 'updateJobStatus'])->name('job-status');
    Route::post('/o9a4b7/{bookingId}', [TeknisiController::class, 'updateJobStatus'])->name('order-status');
    Route::get('/w7f2d6', [TeknisiController::class, 'wallet'])->name('wallet');
});
