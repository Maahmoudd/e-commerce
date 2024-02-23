<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\RazorpaySettingRequest;
use App\Models\RazorpaySetting;
use Illuminate\Http\Request;

class RazorpaySettingController extends Controller
{
    public function update(RazorpaySettingRequest $request, string $id)
    {
        RazorpaySetting::updateOrCreate(
            ['id' => $id],
            $request->validated()
        );
        toastr('Updated Successfully!', 'success', 'Success');
        return redirect()->back();
    }
}
