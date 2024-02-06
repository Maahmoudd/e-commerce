<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\AdminVendorProfileController;
use App\Http\Controllers\Backend\BrandsController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ChildCategoryController;
use App\Http\Controllers\Backend\FlashSaleController;
use App\Http\Controllers\Backend\ProductImageGalleryController;
use App\Http\Controllers\Backend\ProductsController;
use App\Http\Controllers\Backend\ProductVariantController;
use App\Http\Controllers\Backend\ProductVariantItemsController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SellerProductsController;
use App\Http\Controllers\Backend\SettingsController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SubCategoryController;
use Illuminate\Support\Facades\Route;

/** Admin Routes */

Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

/** Profile Routes */

Route::get('profile', [ProfileController::class, 'index'])->name('profile');
Route::post('profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::post('profile/update/password', [ProfileController::class, 'updatePassword'])->name('password.update');

/** Slider Route */
Route::resource('slider', SliderController::class);

/** Category Route */
Route::put('change-status', [CategoryController::class, 'changeStatus'])->name('category.change-status');
Route::resource('category', CategoryController::class);
/** Sub Category Route */
Route::put('sub-category/change-status', [SubCategoryController::class, 'changeStatus'])->name('sub-category.change-status');
Route::resource('sub-category', SubCategoryController::class);
/** Child Category Route */
Route::put('child-category/change-status', [ChildCategoryController::class, 'changeStatus'])->name('child-category.change-status');
Route::get('get-subcategories', [ChildCategoryController::class, 'getSubCategories'])->name('get-subcategories');
Route::resource('child-category', ChildCategoryController::class);

/** Brand Routes */
Route::put('brand/change-status', [BrandsController::class, 'changeStatus'])->name('brand.change-status');
Route::resource('brand', BrandsController::class);

/** Vendor Profile Routes */
Route::resource('vendor-profile', AdminVendorProfileController::class);

/** Products routes */
Route::get('product/get-subcategories', [ProductsController::class, 'getSubCategories'])->name('product.get-subcategories');
Route::get('product/get-child-categories', [ProductsController::class, 'getChildCategories'])->name('product.get-child-categories');
Route::put('product/change-status', [ProductsController::class, 'changeStatus'])->name('product.change-status');
Route::resource('products', ProductsController::class);

/** Product Images Gallery Route */
Route::resource('products-image-gallery', ProductImageGalleryController::class);

/** Product Variant Route */
Route::put('products-variant/change-status', [ProductVariantController::class, 'changeStatus'])->name('products-variant.change-status');
Route::resource('products-variant', ProductVariantController::class);

/** Product Variant Item Route */
Route::get('products-variant-item/{productId}/{variantId}', [ProductVariantItemsController::class, 'index'])->name('products-variant-item.index');
Route::get('products-variant-item/create/{productId}/{variantId}', [ProductVariantItemsController::class, 'create'])->name('products-variant-item.create');
Route::post('products-variant-item', [ProductVariantItemsController::class, 'store'])->name('products-variant-item.store');
Route::get('products-variant-item-edit/{variantItemId}', [ProductVariantItemsController::class, 'edit'])->name('products-variant-item.edit');
Route::put('products-variant-item-update/{variantItemId}', [ProductVariantItemsController::class, 'update'])->name('products-variant-item.update');
Route::delete('products-variant-item/{variantItemId}', [ProductVariantItemsController::class, 'destroy'])->name('products-variant-item.destroy');
Route::put('products-variant-item-status', [ProductVariantItemsController::class, 'changeStatus'])->name('products-variant-item.change-status');

/** Seller Products Routes */
Route::get('seller-products', [SellerProductsController::class, 'index'])->name('seller-products.index');
Route::get('seller-pending-products', [SellerProductsController::class, 'pendingProducts'])->name('seller-pending-products.index');
Route::put('change-approve-status', [SellerProductsController::class, 'changeApproveStatus'])->name('change-approve-status');

/** Flash Sale Routes */
Route::get('flash-sale', [FlashSaleController::class, 'index'])->name('flash-sale.index');
Route::put('flash-sale', [FlashSaleController::class, 'update'])->name('flash-sale.update');
Route::post('flash-sale/add-product', [FlashSaleController::class, 'create'])->name('flash-sale.add-product');
Route::put('flash-sale/show-at-home/status-change', [FlashSaleController::class, 'changeShowAtHomeStatus'])->name('flash-sale.show-at-home.change-status');
Route::put('flash-sale-status', [FlashSaleController::class, 'changeStatus'])->name('flash-sale-status');
Route::delete('flash-sale/{id}', [FlashSaleController::class, 'destroy'])->name('flash-sale.destroy');

/** settings routes */
Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
Route::put('generale-setting-update', [SettingsController::class, 'generalSettingUpdate'])->name('generale-setting-update');
Route::put('email-setting-update', [SettingsController::class, 'emailConfigSettingUpdate'])->name('email-setting-update');
Route::put('logo-setting-update', [SettingsController::class, 'logoSettingUpdate'])->name('logo-setting-update');
Route::put('pusher-setting-update', [SettingsController::class, 'pusherSettingUpdate'])->name('pusher-setting-update');
