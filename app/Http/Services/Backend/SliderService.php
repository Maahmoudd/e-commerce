<?php

namespace App\Http\Services\Backend;

use App\Models\Slider;

class SliderService
{
    public function createSlider($request)
    {
        Slider::create($request);
    }

}
