<?php

use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Frontend\CartItemsController;
use App\Http\Controllers\Frontend\CartsController;
use App\Http\Controllers\Frontend\CheckOutController;
use App\Http\Controllers\Frontend\FlashSaleController;
use App\Http\Controllers\Frontend\FrontendProductsController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\OtherPaymentController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\UserAddressesController;
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

/** Cart routes */
Route::post('add-to-cart', [CartsController::class, 'store'])->name('add-to-cart');
Route::get('cart-details', [CartsController::class, 'index'])->name('cart-details');
Route::post('cart/update-quantity', [CartsController::class, 'update'])->name('cart.update-quantity');
Route::get('clear-cart', [CartsController::class, 'destroy'])->name('clear.cart');
Route::get('cart/sidebar-product-total', [CartsController::class, 'cartTotal'])->name('cart.sidebar-product-total');
Route::get('cart-count', [CartsController::class, 'getCartCount'])->name('cart-count');
Route::post('cart/remove-sidebar-product', [CartsController::class, 'removeSidebarProduct'])->name('cart.remove-sidebar-product');

Route::get('apply-coupon', [CartsController::class, 'applyCoupon'])->name('apply-coupon');
Route::get('coupon-calculation', [CartsController::class, 'couponCalculation'])->name('coupon-calculation');

/** Cart Items routes */
Route::get('cart/remove-product/{rowId}', [CartItemsController::class, 'destroy'])->name('cart.remove-product');
Route::get('cart-products', [CartItemsController::class, 'index'])->name('cart-products');

/** Profile routes */
Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'user', 'as' => 'user.'], function (){
   Route::get('dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
   Route::get('profile', [UserProfileController::class, 'index'])->name('profile');
   Route::put('profile',[\App\Http\Controllers\Backend\ProfileController::class, 'updateProfile'])->name('profile.update');
   Route::put('password',[\App\Http\Controllers\Backend\ProfileController::class, 'updatePassword'])->name('profile.update.password');

   Route::resource('address', UserAddressesController::class);

    /** Checkout routes */
    Route::get('checkout', [CheckOutController::class, 'index'])->name('checkout');
    Route::post('checkout/address-create', [CheckOutController::class, 'createAddress'])->name('checkout.address.create');
    Route::post('checkout/form-submit', [CheckOutController::class, 'checkOutFormSubmit'])->name('checkout.form-submit');

    /** Payment Routes */
    Route::get('payment', [PaymentController::class, 'index'])->name('payment');
    Route::get('payment-success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');

    /** Paypal routes */
    Route::get('paypal/payment', [PaymentController::class, 'payWithPaypal'])->name('paypal.payment');
    Route::get('paypal/success', [PaymentController::class, 'paypalSuccess'])->name('paypal.success');
    Route::get('paypal/cancel', [PaymentController::class, 'paypalCancel'])->name('paypal.cancel');

    /** Stripe routes */
    Route::post('stripe/payment', [OtherPaymentController::class, 'payWithStripe'])->name('stripe.payment');

    /** Razorpay routes */
    Route::post('razorpay/payment', [OtherPaymentController::class, 'payWithRazorPay'])->name('razorpay.payment');

    /** COD routes */
    Route::get('cod/payment', [OtherPaymentController::class, 'payWithCod'])->name('cod.payment');
});

require __DIR__.'/auth.php';
