<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\UpdateSettingsRequest;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $generalSettings = GeneralSetting::first();
        return view('admin.setting.index', compact('generalSettings'));
    }

    public function generalSettingUpdate(UpdateSettingsRequest $request)
    {
        GeneralSetting::updateOrCreate(['id' => 1], $request->validated());
        toastr('Updated Successfully!');
        return back();
    }
}
