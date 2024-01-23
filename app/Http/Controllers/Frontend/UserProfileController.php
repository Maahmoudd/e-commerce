<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Services\Backend\ProfileService;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{

    protected $profileService;
    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index()
    {
        return view('frontend.dashboard.profile');
    }

}
