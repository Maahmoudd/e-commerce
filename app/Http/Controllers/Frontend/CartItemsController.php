<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartItemsController extends Controller
{

    public function index()
    {
        return Cart::content();
    }
    public function destroy($rowId)
    {
        Cart::remove($rowId);
        toastr('Product removed successfully!', 'success', 'Success');
        return redirect()->back();
    }
}
