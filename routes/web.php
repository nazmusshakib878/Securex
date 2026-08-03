<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;

Route::get('/', [HomeController::class, "viewHomePage"])->name('home');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/login', function () {
    return view('pages.login');
})->name('login');
Route::post('/login', [AuthController::class, 'loginCheck'])->name('loginCheck');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [PasswordResetController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'edit'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'update'])->name('password.update');
});

Route::get('/signup', [AuthController::class, 'viewSignup'])->name('viewSignup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
Route::get('/auth/google/redirect', [AuthController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::middleware(['auth', 'admin'])->prefix('admin-panel')->group(function () {
    Route::get('/', [AdminController::class, 'viewAdminPanel'])->name('viewAdminPanel');
    Route::get('/add-service', [ServiceController::class, 'viewServiceAddForm'])->name('viewServiceAddForm');
    Route::post('/add-service', [ServiceController::class, 'storeService'])->name('storeService');
    Route::get('/service-list', [ServiceController::class, 'viewServiceList'])->name('viewServiceList');
    Route::get('/edit-service/{id}', [ServiceController::class, 'viewServiceEditForm'])->name('viewServiceEditForm');
    Route::delete('/services/{service}', [ServiceController::class, 'deleteService'])->name('deleteService');
    Route::post('/edit-service', [ServiceController::class, 'editService'])->name('editService');
    Route::get('/bookings', [BookingController::class, 'adminIndex'])->name('admin.bookings');
    Route::post('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('admin.bookings.status');
    Route::get('/contact-messages', [ContactController::class, 'index'])->name('contactMessages');
    Route::get('/users', [AdminController::class, 'users'])->name('adminUsers');
});

Route::middleware('auth')->get('/bookings', [BookingController::class, 'index'])->name('user.bookings');
Route::middleware('auth')->get('/bookings/{booking}/invoice', [BookingController::class, 'invoice'])->name('bookings.invoice');
Route::middleware('auth')->post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
Route::post('/admin-panel/create-booking', [BookingController::class, 'createBooking'])->middleware('auth')->name('createBooking');
