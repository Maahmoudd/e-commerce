<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Services\Frontend\HomeService;


class HomeController extends Controller
{

    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }


    public function index()
    {
        $sliders = $this->homeService->index();
        return view('frontend.home.home',
            compact('sliders'));
    }
}
