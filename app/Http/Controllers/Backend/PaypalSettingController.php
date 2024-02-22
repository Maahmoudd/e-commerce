<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PaypalSettingRequest;
use App\Models\PaypalSetting;
use Illuminate\Http\Request;

class PaypalSettingController extends Controller
{
    public function update(PaypalSettingRequest $request, string $id)
    {
        PaypalSetting::updateOrCreate(
            ['id' => $id],
            $request->validated()
        );

        toastr('Updated Successfully!', 'success', 'Success');
        return redirect()->back();

    }

}
