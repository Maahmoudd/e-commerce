<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CouponDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CreateCouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    public function index(CouponDataTable $dataTable)
    {
        return $dataTable->render('admin.coupon.index');
    }

    public function create()
    {
        return view('admin.coupon.create');
    }

    public function store(CreateCouponRequest $request)
    {
        Coupon::create($request->validated());
        toastr('Created Successfully!');
        return redirect()->route('admin.coupons.index');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupon.edit', compact('coupon'));
    }

    public function update(CreateCouponRequest $request, string $id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->update($request->validated());
        toastr('Updated Successfully!');
        return redirect()->route('admin.coupons.index');
    }

    public function destroy(string $id)
    {
        Coupon::destroy($id);
        return response(['status' => 'success', 'message', 'Deleted!']);
    }

    public function changeStatus(Request $request)
    {
        $coupon = Coupon::findOrFail($request->id);
        $coupon->status = $request->status == 'true' ? 1 : 0;
        $coupon->save();
        return response(['message' => 'Status Updated!']);
    }
}
