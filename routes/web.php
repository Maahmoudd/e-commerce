<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/** User Routes */

Route::get('/', function () {
    return view('frontend.home.home');
});

Route::get('/dashboard', function () {
    return view('frontend.dashboard.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('admin/login', [AdminController::class, 'login'])->name('admin.login');

require __DIR__.'/auth.php';
