<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\TourPackageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// =============== DASHBOARD REDIRECT (DINAMIS) ===============
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'guide') {
        return redirect()->route('guide.dashboard');
    } else {
        return redirect()->route('customer.dashboard');
    }
})->name('dashboard');

// =============== PROFILE (SEMUA ROLE BISA) ===============
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =============== ADMIN ROUTE ===============
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('guides', GuideController::class);
    Route::resource('destinations', DestinationController::class);
    Route::resource('currencies', CurrencyController::class);
    Route::resource('tourpackages', TourPackageController::class);
});

// =============== GUIDE ROUTE ===============
Route::middleware(['auth', 'role:guide'])->prefix('guide')->name('guide.')->group(function () {
    Route::get('/dashboard', [GuideController::class, 'index'])->name('dashboard');
});

// =============== CUSTOMER ROUTE ===============
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'index'])->name('dashboard');
});

require __DIR__ . '/auth.php';
