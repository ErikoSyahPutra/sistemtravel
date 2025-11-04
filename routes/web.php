<?php

use Illuminate\Support\Facades\Route;

// =============== CONTROLLERS ===============
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\GuidesController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\TourPackageController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;

// =============== LANDING PAGE ===============
Route::get('/', function () {
    return view('welcome');
});

// =============== DASHBOARD REDIRECT (DINAMIS) ===============
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    $user = auth()->user();

    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'guide' => redirect()->route('guide.dashboard'),
        default => redirect()->route('customer.dashboard'),
    };
})->name('dashboard');

// =============== PROFILE (SEMUA ROLE) ===============
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ====================================================================
// =========================== ADMIN ROUTE ============================
// ====================================================================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        Route::resource('users', UserController::class);
        Route::resource('guides', GuideController::class);
        Route::resource('destinations', DestinationController::class);
        Route::resource('currencies', CurrencyController::class);
        Route::resource('tourpackages', TourPackageController::class);
    });

// ====================================================================
// =========================== GUIDE ROUTE ============================
// ====================================================================
Route::middleware(['auth', 'role:guide'])
    ->prefix('guide')
    ->name('guide.')
    ->group(function () {
        Route::get('/dashboard', [GuidesController::class, 'index'])->name('dashboard');
    });

// ====================================================================
// ========================= CUSTOMER ROUTE ===========================
// ====================================================================
Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [CustomerController::class, 'index'])->name('dashboard');

        // Destinasi
        Route::get('/destinations', [CustomerController::class, 'destinations'])->name('destinations');
        Route::get('/destinations/{destination}/packages', [CustomerController::class, 'showPackages'])
            ->name('packages.index');

        // Booking
        Route::get('/booking', [BookingController::class, 'index'])->name('booking');
        Route::get('/packages/{tourPackage}/book', [BookingController::class, 'create'])->name('booking.create');
        Route::post('/booking/store/{id}', [BookingController::class, 'store'])->name('booking.store');

        // Pembayaran
        Route::get('/booking/{booking}/pay', [BookingController::class, 'showPayment'])->name('booking.pay');
        Route::post('/booking/{booking}/pay', [BookingController::class, 'processPayment'])->name('booking.process');

        // Pembelian langsung paket
        Route::post('/tourpackages/{id}/buy', [CustomerController::class, 'buy'])->name('tourpackages.buy');

        // Callback & Success Payment
        Route::match(['get', 'post'], '/payment/callback', [BookingController::class, 'paymentCallback'])
            ->name('payment.callback');
        Route::get('/payment/success', [BookingController::class, 'paymentSuccess'])->name('payment.success');
    });

// ====================================================================
// =========================== WEBHOOK ================================
// ====================================================================
Route::post('/webhook/payment', [WebhookController::class, 'handlePayment'])->name('webhook.payment');

// =============== AUTH ROUTE ===============
require __DIR__ . '/auth.php';
