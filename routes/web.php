<?php

use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\UserProfileController;
use Illuminate\Support\Facades\Route;

/** Frontend Routes */

Route::get('/', function () {
    return view('frontend.home.home');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('admin/login', [AdminController::class, 'login'])->name('admin.login');


Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'user', 'as' => 'user.'], function (){
   Route::get('dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
   Route::get('profile', [UserProfileController::class, 'index'])->name('profile');
   Route::put('profile',[\App\Http\Controllers\Backend\ProfileController::class, 'updateProfile'])->name('profile.update');
});

require __DIR__.'/auth.php';
