<?php

namespace App\Http\Services\Frontend;

use App\Models\Slider;

class HomeService
{
    public function index()
    {
        return Slider::where('status', 1)->orderBy('serial', 'asc')->get();
    }

}
