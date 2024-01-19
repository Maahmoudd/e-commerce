<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PasswordUpdateRequest;
use App\Http\Requests\Admin\ProfileUpdateRequest;
use App\Http\Services\Backend\ProfileService;

class ProfileController extends Controller
{

    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index()
    {
        return view('admin.profile.index');
    }

    public function updateProfile(ProfileUpdateRequest $request)
    {
        $this->profileService->profileUpdate($request);

        toastr()->success('Profile Has Been Updated');

        return back();
    }

    public function updatePassword(PasswordUpdateRequest $request)
    {
        $request->user()->update([
            'password' => bcrypt($request->password),
        ]);

        toastr()->success('Password Has Been Updated');
        return back();
    }
}
