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

    public function updateSlider($request, $id)
    {
        $slider = Slider::findOrFail($id);
        $sliderBanner = $this->updateImage($request, 'banner', 'uploads', $slider->banner);
        $slider->update($request->validated());
        $slider->banner = empty(!$sliderBanner) ? $sliderBanner : $slider->banner;
        $slider->save();
    }

    public function deleteSlider($id)
    {
        $slider = Slider::findOrFail($id);
        $this->deleteImage($slider->banner);
        $slider->delete();
    }

}
