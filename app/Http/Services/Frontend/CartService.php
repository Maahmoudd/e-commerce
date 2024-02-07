<?php

namespace App\Http\Services\Frontend;

use App\Models\Product;
use App\Models\ProductVariantItem;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getItems()
    {
        $cartItems = Cart::content();
        if(count($cartItems) === 0){
            Session::forget('coupon');
            return false;
        }
        return $cartItems;
    }

    public function checkProductAvailability($id, $qty)
    {
        $product = Product::findOrFail($id);
        // check product quantity
        if($product->qty === 0){
            return false;
        }elseif($product->qty < $qty){
            return true;
        }
        return $product;
    }

    public function prepareVariants($request)
    {
        $variants = [];
        $variantTotalAmount = 0;

        if ($request->has('variants_items')) {
            foreach ($request->variants_items as $item_id) {
                $variantItem = ProductVariantItem::find($item_id);
                $variants[$variantItem->productVariant->name]['name'] = $variantItem->name;
                $variants[$variantItem->productVariant->name]['price'] = $variantItem->price;
                $variantTotalAmount += $variantItem->price;
            }
        }

        return [
            'variants' => $variants,
            'variantTotalAmount' => $variantTotalAmount,
        ];
    }

    public function checkOffer($product)
    {
        $productPrice = 0;

        if(checkDiscount($product)){
            $productPrice = $product->offer_price;
        }else {
            $productPrice = $product->price;
        }
        return $productPrice;
    }

    public function storeCart($product, $request, $productPrice, $variants, $variantTotalAmount)
    {
        $cartData = [];
        $cartData['id'] = $product->id;
        $cartData['name'] = $product->name;
        $cartData['qty'] = $request->qty;
        $cartData['price'] = $productPrice;
        $cartData['weight'] = 10;
        $cartData['options']['variants'] = $variants;
        $cartData['options']['variants_total'] = $variantTotalAmount;
        $cartData['options']['image'] = $product->thumb_image;
        $cartData['options']['slug'] = $product->slug;
        Cart::add($cartData);
    }

    public function getCartProduct($request)
    {
        $productId = Cart::get($request->rowId)->id;
        return Product::findOrFail($productId);
    }

    public function getProductTotal($rowId)
    {
        $product = Cart::get($rowId);
        $total = ($product->price + $product->options->variants_total) * $product->qty;
        return $total;
    }

    public function cartTotal()
    {
        $total = 0;
        foreach(Cart::content() as $product){
            $total += $this->getProductTotal($product->rowId);
        }

        return $total;
    }
}
