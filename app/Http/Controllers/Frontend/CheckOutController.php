<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CheckoutFormRequest;
use App\Http\Requests\Frontend\CreateUserAddressRequest;
use App\Models\ShippingRule;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckOutController extends Controller
{
    public function index()
    {
        $addresses = UserAddress::where('user_id', Auth::user()->id)->get();
        $shippingMethods = ShippingRule::where('status', 1)->get();
        return view('frontend.pages.checkout', compact('addresses', 'shippingMethods'));
    }

    public function createAddress(CreateUserAddressRequest $request)
    {
        UserAddress::create(array_merge($request->validated(), ['user_id' => Auth::user()->id]));
        toastr('Address created successfully!', 'success', 'Success');
        return back();

    }

    public function checkOutFormSubmit(CheckoutFormRequest $request)
    {
        $shippingMethod = ShippingRule::findOrFail($request['shipping_method_id']);
        if($shippingMethod){
            Session::put('shipping_method', [
                'id' => $shippingMethod->id,
                'name' => $shippingMethod->name,
                'type' => $shippingMethod->type,
                'cost' => $shippingMethod->cost
            ]);
        }
        $address = UserAddress::findOrFail($request['shipping_address_id'])->toArray();
        if($address){
            Session::put('address', $address);
        }

        return response(['status' => 'success', 'redirect_url' => route('user.payment')]);
    }
}
