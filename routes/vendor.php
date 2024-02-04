<?php

use App\Http\Controllers\Backend\VendorController;
use App\Http\Controllers\Backend\VendorProductImageGalleryController;
use App\Http\Controllers\Backend\VendorProductsController;
use App\Http\Controllers\Backend\VendorProductVariantItemsController;
use App\Http\Controllers\Backend\VendorProductVariantsController;
use App\Http\Controllers\Backend\VendorProfileController;
use App\Http\Controllers\Backend\VendorShopProfilesController;
use Illuminate\Support\Facades\Route;

/** Vendor Routes */

Route::get('dashboard', [VendorController::class, 'dashboard'])->name('dashboard');
Route::get('profile', [VendorProfileController::class, 'index'])->name('profile');

/** Shop Profile Route */
Route::resource('shop-profile', VendorShopProfilesController::class);

/** Product Routes */
Route::get('product/get-subcategories', [VendorProductsController::class, 'getSubCategories'])->name('product.get-subcategories');
Route::get('product/get-child-categories', [VendorProductsController::class, 'getChildCategories'])->name('product.get-child-categories');
Route::put('product/change-status', [VendorProductsController::class, 'changeStatus'])->name('product.change-status');
Route::resource('products', VendorProductsController::class);

/** Products image gallery route */
Route::resource('products-image-gallery', VendorProductImageGalleryController::class);

/** Products variant route */
Route::put('products-variant/change-status', [VendorProductVariantsController::class, 'changeStatus'])->name('products-variant.change-status');
Route::resource('products-variant', VendorProductVariantsController::class);

/** Products variant item route */
Route::get('products-variant-item/{productId}/{variantId}', [VendorProductVariantItemsController::class, 'index'])->name('products-variant-item.index');
Route::get('products-variant-item/create/{productId}/{variantId}', [VendorProductVariantItemsController::class, 'create'])->name('products-variant-item.create');
Route::post('products-variant-item', [VendorProductVariantItemsController::class, 'store'])->name('products-variant-item.store');
Route::get('products-variant-item-edit/{variantItemId}', [VendorProductVariantItemsController::class, 'edit'])->name('products-variant-item.edit');
Route::put('products-variant-item-update/{variantItemId}', [VendorProductVariantItemsController::class, 'update'])->name('products-variant-item.update');
Route::delete('products-variant-item/{variantItemId}', [VendorProductVariantItemsController::class, 'destroy'])->name('products-variant-item.destroy');
Route::put('products-variant-item-status', [VendorProductVariantItemsController::class, 'changeStatus'])->name('products-variant-item.change-status');
