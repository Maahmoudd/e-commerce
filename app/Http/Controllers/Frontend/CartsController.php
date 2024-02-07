<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Services\Frontend\CartService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartsController extends Controller
{

    protected $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /** Show cart page  */
    public function index()
    {
        $cartItems = $this->cartService->getItems();

        if(!$cartItems){
            toastr('Please add some products in your cart for view the cart page', 'warning', 'Cart is empty!');
            return redirect()->route('home');
        }
        return view('frontend.pages.cart-detail', compact('cartItems'));
    }

    /** Add item to cart */
    public function store(Request $request)
    {

        $product = $this->cartService->checkProductAvailability($request->product_id, $request->qty);
        if($product == 'false'){
            return response(['status' => 'error', 'message' => 'Product stock out']);
        }elseif($product == 'true'){
            return response(['status' => 'error', 'message' => 'Quantity not available in our stock']);
        }
        $variantsData = $this->cartService->prepareVariants($request);
        $variants = $variantsData['variants'];
        $variantTotalAmount = $variantsData['variantTotalAmount'];
        /** check discount */
        $productPrice = $this->cartService->checkOffer($product);
        $this->cartService->storeCart($product, $request, $productPrice, $variants, $variantTotalAmount);
        return response(['status' => 'success', 'message' => 'Added to cart successfully!']);
    }

    /** Update product quantity */
    public function update(Request $request)
    {
        $product = $this->cartService->getCartProduct($request);
        if($product->qty === 0){
            return response(['status' => 'error', 'message' => 'Product stock out']);
        }elseif($product->qty < $request->qty){
            return response(['status' => 'error', 'message' => 'Quantity not available in our stock']);
        }

        Cart::update($request->rowId, $request->quantity);
        $productTotal = $this->cartService->getProductTotal($request->rowId);

        return response(['status' => 'success', 'message' => 'Product Quantity Updated!', 'product_total' => $productTotal]);
    }

    /** get product total */

    /** get cart total amount */
    public function cartTotal()
    {
        return $this->cartService->cartTotal();
    }

    /** clear all cart products */
    public function destroy()
    {
        Cart::destroy();
        return response(['status' => 'success', 'message' => 'Cart cleared successfully']);
    }


    public function getCartCount()
    {
        return Cart::content()->count();
    }

    public function removeSidebarProduct(Request $request)
    {
        Cart::remove($request->rowId);
        return response(['status' => 'success', 'message' => 'Product removed successfully!']);
    }

}
