<?php

use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Frontend\FlashSaleController;
use App\Http\Controllers\Frontend\FrontendProductsController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\UserProfileController;
use Illuminate\Support\Facades\Route;

/** Frontend Routes */

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('admin/login', [AdminController::class, 'login'])->name('admin.login');

Route::get('flash-sale', [FlashSaleController::class, 'index'])->name('flash-sale');

/** Products Details Routes */
Route::get('product-detail/{slug}', [FrontendProductsController::class, 'showProduct'])->name('product-detail');


Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'user', 'as' => 'user.'], function (){
   Route::get('dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
   Route::get('profile', [UserProfileController::class, 'index'])->name('profile');
   Route::put('profile',[\App\Http\Controllers\Backend\ProfileController::class, 'updateProfile'])->name('profile.update');
   Route::put('password',[\App\Http\Controllers\Backend\ProfileController::class, 'updatePassword'])->name('profile.update.password');
});

require __DIR__.'/auth.php';
