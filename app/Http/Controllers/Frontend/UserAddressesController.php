<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CreateUserAddressRequest;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;

class UserAddressesController extends Controller
{

    public function index()
    {
        $addresses = UserAddress::where('user_id', Auth::user()->id)->get();
        return view('frontend.dashboard.address.index', compact('addresses'));
    }

    public function create()
    {
        return view('frontend.dashboard.address.create');
    }

    public function store(CreateUserAddressRequest $request)
    {
        UserAddress::create(array_merge($request->validated(), ['user_id' => Auth::user()->id]));
        toastr('Created Successfully!');
        return redirect()->route('user.address.index');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $address = UserAddress::findOrFail($id);
        return view('frontend.dashboard.address.edit', compact('address'));
    }

    public function update(CreateUserAddressRequest $request, string $id)
    {
        $address = UserAddress::findOrFail($id);
        $address->update($request->validated());
        toastr('Updated!');
        return redirect()->route('user.address.index');
    }

    public function destroy(string $id)
    {
        UserAddress::destroy($id);
        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }
}
