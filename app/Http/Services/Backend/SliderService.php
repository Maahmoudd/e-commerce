<?php

namespace App\Http\Services\Backend;

use App\Models\Slider;
use App\Traits\ImageUploadTrait;

class SliderService
{

    use ImageUploadTrait;
    public function createSlider($request)
    {
        $request['banner'] = $this->uploadImage($request, 'banner', 'uploads');
        Slider::create($request);
    }

}
