<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\UpdateVendorProfileRequest;
use App\Http\Services\Backend\ProfileService;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminVendorProfileController extends Controller
{

    protected $profileService;
    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index()
    {
        $profile = Vendor::where('user_id', Auth::user()->id)->first();
        return view('admin.vendor-profile.index', compact('profile'));
    }

    public function create()
    {
        //
    }

    public function store(UpdateVendorProfileRequest $request)
    {
        $vendor = Vendor::where('user_id', Auth::user()->id)->first();
        $this->profileService->profileUpdate($request->validated(), 'banner', $vendor);
        toastr('Updated Successfully!');
        return back();
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
