<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PaypalSettingRequest;
use App\Models\StripeSetting;
use Illuminate\Http\Request;

class StripeSettingController extends Controller
{
    public function update(PaypalSettingRequest $request, string $id)
    {
        StripeSetting::updateOrCreate(
            ['id' => $id],
            $request->validated()
        );
        toastr('Updated Successfully!', 'success', 'Success');
        return redirect()->back();
    }
}
