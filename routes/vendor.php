<?php

use App\Http\Controllers\Backend\VendorController;
use App\Http\Controllers\Backend\VendorProfileController;
use App\Http\Controllers\Backend\VendorShopProfilesController;
use Illuminate\Support\Facades\Route;

/** Vendor Routes */

Route::get('dashboard', [VendorController::class, 'dashboard'])->name('dashboard');
Route::get('profile', [VendorProfileController::class, 'index'])->name('profile');

/** Vendor Shop Profile Route */
Route::resource('shop-profile', VendorShopProfilesController::class);
