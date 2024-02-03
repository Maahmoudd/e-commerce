<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PasswordUpdateRequest;
use App\Http\Requests\Backend\ProfileUpdateRequest;
use App\Http\Services\Backend\ProfileService;
use Illuminate\Support\Facades\Auth;

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
        $this->profileService->profileUpdate($request->validated(), 'image', Auth::user(), 'uploads/Admins');

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
