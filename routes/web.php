<?php

use Illuminate\Support\Facades\Route;

// =============== CONTROLLERS ===============
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\GuidesController; // Pastikan controller ini ada
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\TourPackageController;
use App\Http\Controllers\WebhookController;
// Perhatikan: Pastikan namespace BookingController Anda benar (App\Http\Controllers atau App\Http\Controllers\User)
// Sesuai kode terakhir Anda, namespace-nya adalah App\Http\Controllers
use App\Http\Controllers\BookingController; 
use App\Http\Controllers\PaymentController; // Jika PaymentController digabung ke BookingController, baris ini mungkin tidak perlu, tapi kita biarkan aman.

// =============== LANDING PAGE ===============
Route::get('/', function () {
    return view('welcome');
});

// =============== DASHBOARD REDIRECT (DINAMIS) ===============
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    $user = auth()->user();

    // Pastikan logika role ini sesuai dengan database Anda (apakah kolom 'role' string atau menggunakan Spatie)
    // Jika menggunakan Spatie: if ($user->hasRole('admin')) ...
    // Jika menggunakan kolom string biasa:
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

        // Destinasi (Opsional, sesuai kode asli Anda)
        Route::get('/destinations', [CustomerController::class, 'destinations'])->name('destinations');
        Route::get('/destinations/{destination}/packages', [CustomerController::class, 'showPackages'])
            ->name('packages.index');

        // --- TOUR PACKAGES (BARU) ---
        // Menampilkan daftar paket tour khusus customer
        Route::get('/tourpackages', [TourPackageController::class, 'index'])->name('tourpackages.index');
        Route::get('/tourpackages/{id}', [TourPackageController::class, 'show'])->name('tourpackages.show');

        // --- BOOKING (UPDATED) ---
        Route::get('/booking', [BookingController::class, 'index'])->name('booking'); // List booking user
        
        // Form Booking (Route Anda sebelumnya: /packages/{tourPackage}/book)
        // Kita sesuaikan agar konsisten dengan controller yang baru kita buat
        Route::get('/booking/create/{tourPackage}', [BookingController::class, 'create'])->name('booking.create');
        
        // Store Booking
        Route::post('/booking/store/{id}', [BookingController::class, 'store'])->name('booking.store');

        // CHECK AVAILABILITY (AJAX - FITUR BARU)
        Route::post('/booking/check-availability', [BookingController::class, 'checkAvailability'])->name('booking.check');

        // DETAIL / REVIEW BOOKING (FITUR BARU)
        // Halaman ini muncul setelah store, sebelum payment
        Route::get('/booking/detail/{booking}', [BookingController::class, 'show'])->name('booking.show');

        // --- PEMBAYARAN ---
        // Route untuk menampilkan halaman pembayaran/invoice
        Route::get('/booking/{booking}/pay', [BookingController::class, 'showPayment'])->name('booking.pay'); // Alias untuk payment.show
        // Alias agar konsisten dengan redirect di controller:
        Route::get('/payment/{booking}', [BookingController::class, 'showPayment'])->name('payment.show');
        
        // Proses Konfirmasi Pembayaran Manual
        Route::post('/booking/{booking}/pay', [BookingController::class, 'processPayment'])->name('booking.process');
        Route::post('/payment/{booking}', [BookingController::class, 'processPayment'])->name('payment.process');

        // Pembelian langsung paket (Opsional, dari kode asli Anda)
        Route::post('/tourpackages/{id}/buy', [CustomerController::class, 'buy'])->name('tourpackages.buy');

        // Callback & Success Payment Gateway
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